<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya — BOMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <style>
        body { background-color: #f4f7f6; font-family: 'Inter', sans-serif; color: #1a1a2e; }

        .page-wrapper { max-width: 860px; margin: 40px auto; padding: 0 20px; }

        .page-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5rem; font-weight: 800;
            color: #111827; margin-bottom: 4px;
        }
        .page-sub { font-size: 0.875rem; color: #6b7280; margin-bottom: 28px; }

        /* ---- BOOKING CARD ---- */
        .booking-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 16px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: center;
            transition: box-shadow 0.15s;
        }
        .booking-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

        .booking-card .facility-name {
            font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 4px;
        }
        .booking-card .mitra-name {
            font-size: 0.78rem; color: #9ca3af; margin-bottom: 10px;
        }
        .meta-row {
            display: flex; flex-wrap: wrap; gap: 12px;
            font-size: 0.82rem; color: #4b5563;
        }
        .meta-row span { display: flex; align-items: center; gap: 5px; }
        .meta-row i { color: #008774; font-size: 0.75rem; }

        /* Status badge */
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 14px; border-radius: 999px;
            font-size: 0.75rem; font-weight: 700;
            white-space: nowrap;
        }
        .status-pending   { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
        .status-confirmed { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .status-cancelled { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* Right side: price + actions */
        .card-right { text-align: right; }
        .total-price {
            font-size: 1.1rem; font-weight: 800;
            color: #008774; margin-bottom: 10px;
        }
        .card-actions { display: flex; flex-direction: column; gap: 6px; align-items: flex-end; }

        .btn-sm {
            padding: 6px 14px; border-radius: 8px;
            font-size: 0.8rem; font-weight: 600;
            text-decoration: none; display: inline-flex;
            align-items: center; gap: 6px; cursor: pointer;
            border: none; transition: background 0.15s;
        }
        .btn-bayar  { background: #008774; color: #fff; }
        .btn-bayar:hover  { background: #006f5f; }
        .btn-cancel { background: #fee2e2; color: #b91c1c; }
        .btn-cancel:hover { background: #fecaca; }
        .btn-detail { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
        .btn-detail:hover { background: #e5e7eb; }

        /* Order ID */
        .order-id { font-size: 0.7rem; color: #d1d5db; margin-top: 6px; }

        /* Empty state */
        .empty-state {
            background: #fff; border: 1.5px dashed #e5e7eb;
            border-radius: 14px; padding: 60px 20px;
            text-align: center;
        }
        .empty-state i { font-size: 3rem; color: #d1d5db; margin-bottom: 12px; display: block; }
        .empty-state h3 { font-family: 'Montserrat', sans-serif; font-size: 1rem; font-weight: 700; color: #374151; margin-bottom: 6px; }
        .empty-state p  { font-size: 0.85rem; color: #9ca3af; margin-bottom: 20px; }
        .btn-cari {
            display: inline-block; padding: 10px 24px;
            background: #008774; color: #fff;
            border-radius: 8px; font-weight: 700;
            font-size: 0.875rem; text-decoration: none;
        }
        .btn-cari:hover { background: #006f5f; }

        /* Pagination */
        .pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }
        .pagination-wrap nav { display: flex; gap: 6px; }
        .pagination-wrap span, .pagination-wrap a {
            padding: 6px 12px; border-radius: 7px;
            font-size: 0.82rem; border: 1px solid #e5e7eb;
            color: #374151; text-decoration: none;
            background: #fff;
        }
        .pagination-wrap span[aria-current] {
            background: #008774; color: #fff; border-color: #008774; font-weight: 700;
        }

        /* Cancel confirm modal - simple */
        .cancel-form { display: inline; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <header class="navbar bg-accent">
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text">Badan Olahraga<br>Mahasiswa</div>
        </div>
        <nav class="nav-links">
            <a href="/">Home</a>
            <a href="{{ route('jadwal.index') }}">Jadwal Latihan</a>
            <a href="{{ route('booking') }}" >Booking Lapang</a>
        </nav>
        <div class="nav-right">
            @auth
            <div class="profile-dropdown">
                <a href="#" class="profile-trigger">
                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
                    <i class="fas fa-chevron-down small-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-link">
                            <i class="fas fa-user"></i> My Account
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('booking.history') }}" class="dropdown-item-link" style="color:#008774;font-weight:600;">
                            <i class="fas fa-receipt"></i> Pesanan Saya
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn-link" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </header>

    <div class="page-wrapper">
        <h1 class="page-title"><i class="fa-solid fa-receipt me-2" style="color:#008774"></i>Pesanan Saya</h1>
        <p class="page-sub">Riwayat semua booking lapangan yang pernah kamu buat.</p>

        @if(session('success'))
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;color:#166534;padding:12px 16px;border-radius:10px;font-size:0.875rem;margin-bottom:20px;display:flex;gap:10px;align-items:center;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @forelse($bookings as $booking)
            <div class="booking-card">
                <div>
                    {{-- Status badge --}}
                    @php
                        $statusClass = match($booking->status) {
                            'confirmed' => 'status-confirmed',
                            'cancelled' => 'status-cancelled',
                            default     => 'status-pending',
                        };
                        $statusLabel = match($booking->status) {
                            'confirmed' => '✅ Terkonfirmasi',
                            'cancelled' => '❌ Dibatalkan',
                            default     => '⏳ Menunggu Bayar',
                        };
                    @endphp
                    <div class="status-badge {{ $statusClass }}" style="margin-bottom:10px;">
                        {{ $statusLabel }}
                    </div>

                    <div class="facility-name">{{ $booking->facility->name }}</div>
                    <div class="mitra-name">
                        <i class="fa-solid fa-building-user"></i>
                        {{ $booking->facility->mitra->brand_name ?? 'Mitra BOMA' }}
                    </div>

                    <div class="meta-row">
                        <span><i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($booking->booking_date)->translatedFormat('d F Y') }}
                        </span>
                        <span><i class="fa-regular fa-clock"></i>
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} WIB
                        </span>
                        <span><i class="fa-solid fa-hourglass-half"></i>
                            {{ $booking->jumlah_sesi }} Jam
                        </span>
                        <span><i class="fa-solid fa-tag"></i>
                            {{ $booking->facility->type }}
                        </span>
                    </div>

                    @if($booking->latestPayment && $booking->latestPayment->midtrans_order_id)
                        <div class="order-id">Order: {{ $booking->latestPayment->midtrans_order_id }}</div>
                    @endif
                </div>

                <div class="card-right">
                    <div class="total-price">
                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                    </div>
                    <div class="card-actions">
                        {{-- Tombol bayar: hanya jika masih pending dan ada snap token --}}
                        @if($booking->status === 'pending' && $booking->latestPayment && $booking->latestPayment->snap_token)
                            <a href="{{ route('payment.show', $booking->latestPayment->id) }}" class="btn-sm btn-bayar">
                                <i class="fa-solid fa-credit-card"></i> Bayar Sekarang
                            </a>
                            <form class="cancel-form" action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin mau batalkan booking ini?')">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-sm btn-cancel">
                                    <i class="fa-solid fa-xmark"></i> Batalkan
                                </button>
                            </form>
                        @elseif($booking->status === 'confirmed')
                            <a href="{{ route('payment.success', $booking->latestPayment->id) }}" class="btn-sm btn-detail">
                                <i class="fa-solid fa-receipt"></i> Lihat Detail
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fa-solid fa-calendar-xmark"></i>
                <h3>Belum ada pesanan</h3>
                <p>Kamu belum pernah booking lapangan. Yuk cari lapangan sekarang!</p>
                <a href="{{ route('booking') }}" class="btn-cari">
                    <i class="fa-solid fa-search me-2"></i>Cari Lapangan
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="pagination-wrap">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</body>
</html>