<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
public function index(Request $request)
    {
        // 1. Ambil data keyword filter dari Request URL bray
        $tanggal   = $request->query('tanggal');
        $cabang    = $request->query('cabang');
        $kecamatan = $request->query('kecamatan');

        // 🚀 2. DROPDOWN CABANG OLAHRAGA REAL DINAMIS
        // Langsung narik dari kolom 'type' di table facilities tanpa di-hardcode bray
        $listCabang = Facility::whereNotNull('type')
            ->select('type')
            ->distinct()
            ->pluck('type');

        // 🚀 3. DROPDOWN KECAMATAN DINAMIS (HANYA YANG PUNYA LAPANGAN AKTIF BRAY!)
        // Kita query lewat Model Mitra, tapi diproteksi pake whereHas('facilities')
        $listKecamatan = \App\Models\Mitra::whereNotNull('address')
            ->whereHas('facilities', function ($query) {
                // Pastiin lapangannya berstatus aktif juga bray
                $query->where('is_active', true);
            })
            ->select('address')
            ->distinct()
            ->pluck('address');

        // 🕵️‍♂️ 4. EKSEKUSI QUERY PENCARIAN UTAMA LAPANGAN
        $facilities = Facility::with('mitra')
            ->where('is_active', true)
            
            // 🏃 Saring murni berdasarkan kolom 'type' bray (Anti Gagal!)
            ->when($cabang, function ($query, $cabang) {
                return $query->where('type', $cabang);
            })

            // 📍 Saring berdasarkan Kecamatan Mitra tempat GOR berada
            ->when($kecamatan, function ($query, $kecamatan) {
                return $query->whereHas('mitra', function ($q) use ($kecamatan) {
                    $q->where('address', 'LIKE', '%' . $kecamatan . '%');
                });
            })
            ->latest()
            ->get();

        // 📦 5. Lempar semua data sakti ini ke view blade bray!
        return view('booking', compact('facilities', 'listCabang', 'listKecamatan'));
    }

    // 📝 2. UNTUK RIWAYAT PESANAN USER (FUNGSI BARU LU BRAY - GANTI NAMA)
    public function history()
    {
        $bookings = Booking::with(['facility.mitra', 'latestPayment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(8);

        // Pastiin nama view blade-nya sesuai ya bray, tadi di routes namanya booking-history
        return view('booking-history', compact('bookings'));
    }

    public function show($id)
    {
        $facility = Facility::with('mitra')->findOrFail($id);
        return view('detail-lapangan', compact('facility'));
    }

    public function store(Request $request)
    {
        // =========================================================================
        // STEP 1: VALIDASI INPUT DATA UTAMA
        // =========================================================================
        $request->validate([
            'facility_id'  => 'required|exists:facilities,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time'   => 'required|string',
            'jumlah_sesi'  => 'required|integer|min:1|max:8',
        ]);

        $facility = Facility::findOrFail($request->facility_id);

        // 🧠 PARSING INTEGRASI TANGGAL + JAM KE OBJEK CARBON MURNI
        $startTime = Carbon::parse($request->booking_date . ' ' . $request->start_time);
        $jumlahSesi = (int) $request->jumlah_sesi;
        $endTime = (clone $startTime)->addHours($jumlahSesi);

        // Ambil Jam Operasional asli dari DB (Fallback default jam 6 pagi s.d 10 malam)
        $openingTime = Carbon::parse($request->booking_date . ' ' . ($facility->opening_time ?? '06:00:00'));
        $closingTime = Carbon::parse($request->booking_date . ' ' . ($facility->closing_time ?? '22:00:00'));


        // =========================================================================
        // 🛑 STEP 2: VALIDASI JAM OPERASIONAL (PR 1 - ANTI OVERTIME)
        // =========================================================================
        if ($startTime->lt($openingTime) || $endTime->gt($closingTime)) {
            return back()->withErrors([
                'operational' => "Waduh pak, durasi sewa lu nabrak jam tutup GOR! Lapangan ini buka jam " . 
                $openingTime->format('H:i') . " s.d " . $closingTime->format('H:i') . "."
            ])->withInput();
        }


        // =========================================================================
        // 📅 STEP 3: VALIDASI ANTI DOUBLE BOOKING (ANTI-BENTROK JADWAL)
        // =========================================================================
        $existingBookings = Booking::where('facility_id', $facility->id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['pending', 'confirmed']) 
            ->get();

        $isBentrok = false;
        foreach ($existingBookings as $existing) {
            $existingStart = Carbon::parse($existing->booking_date . ' ' . $existing->start_time);
            $existingEnd = (clone $existingStart)->addHours((int)$existing->jumlah_sesi);

            if ($startTime->lt($existingEnd) && $endTime->gt($existingStart)) {
                $isBentrok = true;
                break;
            }
        }

        if ($isBentrok) {
            return back()->withErrors([
                'conflict' => "Yah telat, cok! Di rentang jam " . $startTime->format('H:i') . " s.d " . $endTime->format('H:i') . " lapangan sudah di-booking kelompok lain."
            ])->withInput();
        }


        // =========================================================================
        // 🛡️ STEP 4: RESUME PAYMENT (FIX TEMUAN 1 — KHUSUS TANGGAL YANG SAMA)
        // =========================================================================
        $existingPending = Booking::where('user_id', auth()->id())
            ->where('facility_id', $facility->id)
            ->where('booking_date', $request->booking_date) // ← Kunci filter per tanggal biar ga over-blocking!
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($existingPending) {
            $oldPayment = Payment::where('booking_id', $existingPending->id)->first();
            if ($oldPayment) {
                return redirect()->route('payment.show', $oldPayment->id)
                    ->withErrors(['pending_invoice' => 'Woi bray, lu masih punya tagihan pending yang belum dibayar di lapangan ini pada tanggal tersebut! Selesaikan dulu atau klik tombol Batalkan di bawah!']);
            }
        }


        // =========================================================================
        // STEP 5: PROSES LANJUTAN SIMPAN & TRANSAKSI MIDTRANS
        // =========================================================================
        $totalPrice = $facility->price_per_hour * $jumlahSesi;

        $booking = Booking::create([
            'user_id'      => auth()->id(),
            'facility_id'  => $facility->id,
            'booking_date' => $request->booking_date,
            'start_time'   => $startTime->format('H:i:s'), 
            'jumlah_sesi'  => $jumlahSesi,
            'total_price'  => $totalPrice,
            'status'       => 'pending',
        ]);

        $orderId = 'BOMA-' . $booking->id . '-' . time();

        $serverKey = config('midtrans.server_key');
        $payload   = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
                'phone'      => auth()->user()->phone ?? '08000000000',
            ],
            'item_details' => [
                [
                    'id'       => 'LAP-' . $facility->id,
                    'price'    => (int) $facility->price_per_hour,
                    'quantity' => $jumlahSesi,
                    'name'     => $facility->name,
                ],
            ],
        ];

        $response = \Illuminate\Support\Facades\Http::withBasicAuth($serverKey, '')
            ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $payload);

        if (!$response->successful()) {
            $booking->delete();
            return back()->withErrors(['midtrans' => 'Gagal menghubungi sistem pembayaran Midtrans.'])->withInput();
        }

        $snapToken = $response->json('token');

        $payment = Payment::create([
            'booking_id'        => $booking->id,
            'amount'            => $totalPrice,
            'status'            => 'pending',
            'snap_token'        => $snapToken,
            'midtrans_order_id' => $orderId,
        ]);

        return redirect()->route('payment.show', $payment->id);
    }

    public function cancel($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $booking->update(['status' => 'cancelled']);
        Payment::where('booking_id', $booking->id)->update(['status' => 'failed']);

        return redirect()->route('booking.detail', $booking->facility_id)
            ->with('success', 'Booking berhasil dibatalkan bray, silakan tentukan jadwal baru lu!');
    }
}