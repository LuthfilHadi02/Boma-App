<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil — BOMA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; color: #1a1a2e; }

        .success-wrapper {
            max-width: 500px;
            margin: 80px auto;
            padding: 0 20px;
            text-align: center;
        }

        .success-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: #f0fdf4; border: 3px solid #bbf7d0;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            font-size: 2.2rem; color: #16a34a;
        }

        h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.6rem; font-weight: 800;
            color: #111827; margin-bottom: 8px;
        }

        .sub { color: #6b7280; font-size: 0.9rem; margin-bottom: 32px; line-height: 1.6; }

        .card-confirm {
            background: #fff; border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 24px 28px; margin-bottom: 24px;
            text-align: left;
        }

        .confirm-row {
            display: flex; justify-content: space-between;
            padding: 9px 0; font-size: 0.875rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .confirm-row:last-child { border-bottom: none; }
        .confirm-row .label { color: #6b7280; }
        .confirm-row .value { font-weight: 600; color: #111827; text-align: right; }
        .confirm-row.paid .value { color: #16a34a; font-size: 1.05rem; }

        .badge-confirmed {
            display: inline-flex; align-items: center; gap: 6px;
            background: #f0fdf4; color: #166534;
            border: 1px solid #bbf7d0;
            padding: 4px 14px; border-radius: 999px;
            font-size: 0.78rem; font-weight: 700;
            margin-bottom: 20px;
        }

        .btn-home {
            display: inline-block; padding: 13px 32px;
            background: #008774; color: #fff;
            border-radius: 10px; font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            text-decoration: none; font-size: 0.95rem;
            transition: background 0.2s;
        }
        .btn-home:hover { background: #006f5f; }

        .btn-booking {
            display: inline-block; padding: 13px 32px;
            border: 1.5px solid #008774; color: #008774;
            border-radius: 10px; font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            text-decoration: none; font-size: 0.95rem;
            margin-left: 12px;
            transition: background 0.2s;
        }
        .btn-booking:hover { background: #f0faf8; }
    </style>
</head>
<body>

@include('partials.navbar')

    <div class="success-wrapper">

        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h1>Pembayaran Berhasil!</h1>
        <p class="sub">Booking lapangan kamu sudah terkonfirmasi. Sampai ketemu di lapangan!</p>

        <div class="card-confirm">
            <div style="text-align:center; margin-bottom: 16px;">
                <span class="badge-confirmed">
                    <i class="fa-solid fa-circle-check"></i> Booking Terkonfirmasi
                </span>
            </div>

            <div class="confirm-row">
                <span class="label">Order ID</span>
                <span class="value" style="font-size:0.8rem; color:#6b7280;">{{ $payment->midtrans_order_id }}</span>
            </div>
            <div class="confirm-row">
                <span class="label">Lapangan</span>
                <span class="value">{{ $payment->booking->facility->name }}</span>
            </div>
            <div class="confirm-row">
                <span class="label">Tanggal Main</span>
                <span class="value">
                    {{ \Carbon\Carbon::parse($payment->booking->booking_date)->translatedFormat('d F Y') }}
                </span>
            </div>
            <div class="confirm-row">
                <span class="label">Jam</span>
                <span class="value">{{ $payment->booking->start_time }} WIB</span>
            </div>
            <div class="confirm-row">
                <span class="label">Durasi</span>
                <span class="value">{{ $payment->booking->jumlah_sesi }} Jam</span>
            </div>
            <div class="confirm-row paid">
                <span class="label">Total Dibayar</span>
                <span class="value">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <a href="/" class="btn-home"><i class="fa-solid fa-house me-2"></i>Kembali ke Home</a>
        <a href="{{ route('booking') }}" class="btn-booking"><i class="fa-solid fa-store me-2"></i>Booking Lagi</a>

    </div>

@include('partials.footer-mini')
</body>
</html>