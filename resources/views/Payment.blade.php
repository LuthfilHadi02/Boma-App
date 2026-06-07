<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesaikan Pembayaran — BOMA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    {{-- Midtrans Snap.js — WAJIB ada di halaman ini --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; color: #1a1a2e; }

        .payment-wrapper {
            max-width: 560px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 32px;
        }
        .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
        .step-circle {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem; font-weight: 700;
        }
        .step.done .step-circle  { background: #008774; color: #fff; }
        .step.active .step-circle { background: #008774; color: #fff; box-shadow: 0 0 0 4px rgba(0,135,116,0.15); }
        .step.idle .step-circle  { background: #e5e7eb; color: #9ca3af; }
        .step-label { font-size: 0.72rem; color: #6b7280; font-weight: 600; white-space: nowrap; }
        .step.active .step-label { color: #008774; }
        .step-line { width: 60px; height: 2px; background: #e5e7eb; margin-bottom: 20px; }
        .step-line.done { background: #008774; }

        .card-payment {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            overflow: hidden;
        }

        .card-header-payment {
            background: linear-gradient(135deg, #008774, #00a896);
            padding: 24px 28px;
            color: #fff;
        }
        .card-header-payment h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.2rem; font-weight: 800; margin: 0 0 4px;
        }
        .card-header-payment p { font-size: 0.85rem; opacity: 0.85; margin: 0; }

        .card-body-payment { padding: 28px; }

        .order-summary { margin-bottom: 24px; }
        .order-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.875rem;
        }
        .order-row:last-child { border-bottom: none; }
        .order-row .label { color: #6b7280; }
        .order-row .value { font-weight: 600; color: #111827; text-align: right; max-width: 60%; }
        .order-row.total .label { font-weight: 700; color: #111827; font-size: 1rem; }
        .order-row.total .value { color: #008774; font-size: 1.2rem; font-weight: 800; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 12px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700;
            background: #fef9c3; color: #854d0e;
            border: 1px solid #fde68a;
            margin-bottom: 20px;
        }
        .status-badge i { font-size: 0.7rem; }

        .btn-bayar {
            width: 100%; padding: 15px;
            background: #008774; color: #fff;
            border: none; border-radius: 10px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem; font-weight: 800;
            cursor: pointer; letter-spacing: 0.03em;
            transition: background 0.2s, transform 0.1s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }
        .btn-bayar:hover { background: #006f5f; }
        .btn-bayar:active { transform: scale(0.98); }
        .btn-bayar:disabled { background: #9ca3af; cursor: not-allowed; }

        .payment-note {
            margin-top: 14px;
            font-size: 0.78rem; color: #9ca3af;
            text-align: center; line-height: 1.6;
        }

        .btn-back {
            display: block; text-align: center;
            margin-top: 20px; font-size: 0.85rem;
            color: #6b7280; text-decoration: none;
        }
        .btn-back:hover { color: #008774; }

        .loading-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.4);
            align-items: center; justify-content: center;
            z-index: 9999;
        }
        .loading-overlay.show { display: flex; }
        .loading-spinner {
            background: #fff; border-radius: 16px; padding: 32px 40px;
            text-align: center;
        }
        .loading-spinner i { font-size: 2rem; color: #008774; margin-bottom: 12px; display: block; }
        .loading-spinner p { font-size: 0.9rem; color: #374151; margin: 0; }
    </style>
</head>
<body>

@include('partials.navbar')

    <div class="payment-wrapper">

        {{-- Step Indicator --}}
        <div class="step-indicator">
            <div class="step done">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <span class="step-label">Isi Data</span>
            </div>
            <div class="step-line done"></div>
            <div class="step done">
                <div class="step-circle"><i class="fa-solid fa-check"></i></div>
                <span class="step-label">Konfirmasi</span>
            </div>
            <div class="step-line done"></div>
            <div class="step active">
                <div class="step-circle">3</div>
                <span class="step-label">Pembayaran</span>
            </div>
            <div class="step-line"></div>
            <div class="step idle">
                <div class="step-circle">4</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>

        {{-- ✅ REVISI TEMUAN 4: Kotak Display Notifikasi Error pending_invoice --}}
        @error('pending_invoice')
            <div style="background:#fef9c3; border:1px solid #fde68a; color:#854d0e; 
                        padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:0.85rem;">
                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $message }}
            </div>
        @enderror

        {{-- Card Utama --}}
        <div class="card-payment">
            <div class="card-header-payment">
                <h2><i class="fa-solid fa-credit-card me-2"></i>Selesaikan Pembayaran</h2>
                <p>Order ID: {{ $payment->midtrans_order_id }}</p>
            </div>

            <div class="card-body-payment">

                <span class="status-badge">
                    <i class="fa-solid fa-clock"></i> Menunggu Pembayaran
                </span>

                {{-- Ringkasan Order --}}
                <div class="order-summary">
                    <div class="order-row">
                        <span class="label">Lapangan</span>
                        <span class="value">{{ $payment->booking->facility->name }}</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Tanggal Main</span>
                        <span class="value">
                            {{ \Carbon\Carbon::parse($payment->booking->booking_date)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div class="order-row">
                        <span class="label">Jam Mulai</span>
                        {{-- ✅ REVISI TEMUAN 3: Merapikan Tampilan Jam 12:00:00 -> 12:00 --}}
                        <span class="value">{{ \Carbon\Carbon::parse($payment->booking->start_time)->format('H:i') }} WIB</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Durasi</span>
                        <span class="value">{{ $payment->booking->jumlah_sesi }} Jam</span>
                    </div>
                    <div class="order-row">
                        <span class="label">Harga / Jam</span>
                        <span class="value">
                            Rp {{ number_format($payment->booking->facility->price_per_hour, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="order-row total">
                        <span class="label">Total Bayar</span>
                        <span class="value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Tombol Bayar --}}
                <button class="btn-bayar" id="btnBayar" onclick="openSnapPayment()">
                    <i class="fa-solid fa-lock"></i>
                    Bayar Sekarang via Midtrans
                </button>

                <form action="{{ route('booking.cancel', $payment->booking_id) }}" method="POST" style="margin-top: 12px;" onsubmit="return confirm('Yakin mau ngebatalin booking jadwal ini bray?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" style="width:100%; padding: 12px; background:#dc2626; color:#fff; border:none; border-radius:10px; font-weight:700; font-family:'Montserrat',sans-serif; cursor:pointer; font-size:0.9rem;">
                        <i class="fa-solid fa-trash-can me-1"></i> Batalkan & Pilih Jadwal Lain
                    </button>
                </form>

                <p class="payment-note">
                    <i class="fa-solid fa-shield-halved me-1"></i>
                    Pembayaran diproses aman oleh Midtrans. Mendukung transfer bank, QRIS, kartu kredit, dan dompet digital.
                </p>

                <a href="{{ route('booking') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke katalog lapangan
                </a>

            </div>
        </div>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <i class="fa-solid fa-spinner fa-spin"></i>
            <p>Membuka halaman pembayaran...</p>
        </div>
    </div>

    <script>
        function openSnapPayment() {
            const btn = document.getElementById('btnBayar');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';

            snap.pay('{{ $payment->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("payment.success", $payment->id) }}';
                },
                onPending: function(result) {
                    alert('Pembayaran kamu sedang diproses. Cek email untuk instruksi selanjutnya.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang via Midtrans';
                },
                onError: function(result) {
                    alert('Pembayaran gagal. Silakan coba lagi.');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang via Midtrans';
                },
                onClose: function() {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Sekarang via Midtrans';
                }
            });
        }
    </script>
@include('partials.footer-mini')
</body>
</html> 