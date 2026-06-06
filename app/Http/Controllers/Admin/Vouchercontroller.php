<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(15);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'               => 'required|string|unique:vouchers,code|max:50',
            'discount_type'      => 'required|in:percentage,fixed',
            'discount_value'     => 'required|numeric|min:0',
            'min_booking_amount' => 'nullable|numeric|min:0',
            'max_uses'           => 'nullable|integer|min:1',
            'expires_at'         => 'nullable|date|after:today',
        ]);

        $voucher = Voucher::create([
            'code'               => strtoupper($request->code),
            'discount_type'      => $request->discount_type,
            'discount_value'     => $request->discount_value,
            'min_booking_amount' => $request->min_booking_amount ?? 0,
            'max_uses'           => $request->max_uses,
            'expires_at'         => $request->expires_at,
            'is_active'          => true,
        ]);

        ActivityLog::record('create', 'Voucher', $voucher->id, null, $voucher->toArray(), "Buat voucher: {$voucher->code}");

        return back()->with('success', 'Voucher berhasil dibuat.');
    }

    public function toggleActive(Voucher $voucher)
    {
        $voucher->update(['is_active' => !$voucher->is_active]);
        $status = $voucher->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLog::record('update', 'Voucher', $voucher->id, null, null, "Voucher {$voucher->code} {$status}");
        return back()->with('success', "Voucher berhasil {$status}.");
    }

    public function destroy(Voucher $voucher)
    {
        ActivityLog::record('delete', 'Voucher', $voucher->id, $voucher->toArray(), null, "Hapus voucher: {$voucher->code}");
        $voucher->delete();
        return back()->with('success', 'Voucher berhasil dihapus.');
    }

    // API: validate voucher (dipanggil dari form booking user)
    public function validate(Request $request)
    {
        $request->validate(['code' => 'required', 'amount' => 'required|numeric']);

        $voucher = Voucher::where('code', strtoupper($request->code))->first();

        if (!$voucher || !$voucher->isValid()) {
            return response()->json(['valid' => false, 'message' => 'Kode voucher tidak valid atau sudah kadaluarsa.']);
        }

        if ($request->amount < $voucher->min_booking_amount) {
            return response()->json(['valid' => false, 'message' => 'Minimum pemesanan untuk voucher ini Rp ' . number_format($voucher->min_booking_amount, 0, ',', '.')]);
        }

        $discount = $voucher->calculateDiscount($request->amount);

        return response()->json([
            'valid'    => true,
            'discount' => $discount,
            'label'    => $voucher->discount_type === 'percentage'
                ? "Diskon {$voucher->discount_value}%"
                : 'Potongan Rp ' . number_format($voucher->discount_value, 0, ',', '.'),
        ]);
    }
}