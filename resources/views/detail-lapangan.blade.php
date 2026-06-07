<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $facility->name }} - Booking Lapangan BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <style>
        /* =====================================================
           DETAIL LAPANGAN PAGE — STYLE KHUSUS
           Warna utama: #008774 (teal BOMA), konsisten dgn jadwal.css
        ===================================================== */

        body {
            background-color: #f4f7f6;
            font-family: 'Inter', sans-serif;
            color: #1a1a2e;
        }

        /* ---- BREADCRUMB ---- */
        .breadcrumb-bar {
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 0;
        }
        .breadcrumb-bar .container {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #6b7280;
        }
        .breadcrumb-bar a {
            color: #008774;
            text-decoration: none;
            font-weight: 500;
        }
        .breadcrumb-bar a:hover { text-decoration: underline; }
        .breadcrumb-bar .separator { color: #d1d5db; }

        /* ---- LAYOUT UTAMA ---- */
        .detail-wrapper {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 28px;
            align-items: start;
        }

        /* ---- KARTU KIRI (Info Lapangan) ---- */
        .card-info {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        .card-info .facility-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
        }
        .card-info .img-placeholder {
            width: 100%;
            height: 320px;
            background: linear-gradient(135deg, #e8f5f3, #c8e6e2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #008774;
            font-size: 3rem;
            gap: 10px;
        }
        .card-info .img-placeholder span {
            font-size: 0.95rem;
            font-weight: 600;
            color: #4b8c83;
        }

        .card-info-body {
            padding: 28px;
        }

        .facility-type-badge {
            display: inline-block;
            background-color: #e8f5f3;
            color: #008774;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 999px;
            border: 1px solid #b2dbd5;
            margin-bottom: 10px;
        }

        .facility-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: #111827;
            margin: 0 0 6px;
            line-height: 1.3;
        }

        .mitra-tag {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .mitra-tag i { color: #008774; margin-right: 5px; }
        .mitra-tag strong { color: #374151; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 24px;
        }
        .info-item {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
        }
        .info-item .label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9ca3af;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .info-item .value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #111827;
        }
        .info-item .value.price {
            color: #008774;
            font-size: 1.1rem;
        }

        /* Amenities */
        .section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 10px;
            margin-top: 20px;
        }
        .amenities-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .amenity-chip {
            background-color: #f0faf8;
            border: 1px solid #c8e6e2;
            color: #008774;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 999px;
        }
        .amenity-chip i { margin-right: 4px; }

        /* Description */
        .facility-desc {
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.7;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #f3f4f6;
        }

        /* Gmaps link */
        .gmaps-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 16px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #008774;
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid #b2dbd5;
            border-radius: 8px;
            background-color: #f0faf8;
            transition: background 0.2s;
        }
        .gmaps-link:hover {
            background-color: #e0f4f0;
            color: #006655;
        }

        /* ---- KARTU KANAN (Form Booking) ---- */
        .card-booking {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
            padding: 28px;
            position: sticky;
            top: 20px;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }
        .booking-header h3 {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }
        .price-display {
            font-size: 1.4rem;
            font-weight: 800;
            color: #008774;
            margin-bottom: 4px;
        }
        .price-display span {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7280;
        }

        .divider {
            border: none;
            border-top: 1px solid #f3f4f6;
            margin: 18px 0;
        }

        /* Form controls */
        .form-label-boma {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            color: #6b7280;
            display: block;
            margin-bottom: 6px;
        }
        .form-control-boma {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            color: #111827;
            background-color: #fff;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .form-control-boma:focus {
            border-color: #008774;
            box-shadow: 0 0 0 3px rgba(0, 135, 116, 0.1);
        }
        .form-group-boma {
            margin-bottom: 16px;
        }

        /* Sesi Selector */
        .sesi-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }
        .sesi-btn {
            background-color: #f9fafb;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 6px;
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
            cursor: pointer;
            text-align: center;
            transition: all 0.15s;
        }
        .sesi-btn:hover {
            border-color: #008774;
            color: #008774;
            background-color: #f0faf8;
        }
        .sesi-btn.active {
            background-color: #008774;
            border-color: #008774;
            color: #ffffff;
        }

        /* Summary harga */
        .price-summary {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin: 18px 0;
        }
        .price-summary .row-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 8px;
        }
        .price-summary .row-price.total {
            color: #111827;
            font-weight: 700;
            font-size: 1rem;
            padding-top: 10px;
            border-top: 1px dashed #e5e7eb;
            margin-top: 10px;
            margin-bottom: 0;
        }
        .price-summary .row-price.total .amount {
            color: #008774;
            font-size: 1.1rem;
        }

        /* Tombol Pesan */
        .btn-pesan {
            width: 100%;
            padding: 14px;
            background-color: #008774;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            letter-spacing: 0.03em;
            transition: background-color 0.2s, transform 0.1s;
        }
        .btn-pesan:hover { background-color: #006f5f; }
        .btn-pesan:active { transform: scale(0.98); }
        .btn-pesan:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        /* Catatan kecil */
        .booking-note {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-top: 14px;
            font-size: 0.78rem;
            color: #9ca3af;
            line-height: 1.5;
        }
        .booking-note i { color: #d1d5db; margin-top: 2px; }

        /* Alert sukses/error */
        .alert-boma {
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 18px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .alert-boma.success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .alert-boma.error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        /* Login prompt */
        .login-prompt {
            background: linear-gradient(135deg, #f0faf8, #e8f5f3);
            border: 1.5px dashed #b2dbd5;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }
        .login-prompt p {
            font-size: 0.875rem;
            color: #4b5563;
            margin-bottom: 12px;
            line-height: 1.6;
        }
        .login-prompt a.btn-login-booking {
            display: inline-block;
            padding: 10px 24px;
            background-color: #008774;
            color: #fff;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.875rem;
            text-decoration: none;
            transition: background 0.2s;
        }
        .login-prompt a.btn-login-booking:hover { background-color: #006f5f; }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-wrapper {
                grid-template-columns: 1fr;
            }
            .card-booking {
                position: static;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    {{-- ============================================================
         NAVBAR BOMA — Konsisten dengan halaman booking & jadwal
    ============================================================ --}}
@include('partials.navbar')
    {{-- ============================================================
         BREADCRUMB
    ============================================================ --}}
    <div class="breadcrumb-bar">
        <div class="container">
            <a href="{{ route('booking') }}"><i class="fa-solid fa-store me-1"></i>Booking Lapangan</a>
            <span class="separator">›</span>
            <span>{{ $facility->name }}</span>
        </div>
    </div>

    {{-- ============================================================
         KONTEN UTAMA
    ============================================================ --}}
    <main>
        <div class="detail-wrapper">

            {{-- ---- KOLOM KIRI: Info Lapangan ---- --}}
            <div class="card-info">

                {{-- Foto --}}
                @if($facility->image)
                    <img src="{{ asset('storage/' . $facility->image) }}" alt="{{ $facility->name }}" class="facility-img">
                @else
                    <div class="img-placeholder">
                        <i class="fa-solid fa-futbol"></i>
                        <span>Foto belum tersedia</span>
                    </div>
                @endif

                <div class="card-info-body">

                    <span class="facility-type-badge">{{ $facility->type }}</span>

                    <h1 class="facility-name">{{ $facility->name }}</h1>

                    <p class="mitra-tag">
                        <i class="fa-solid fa-building-user"></i>
                        Dikelola oleh <strong>{{ $facility->mitra->brand_name ?? 'Mitra BOMA' }}</strong>
                    </p>

                    {{-- Grid Info Singkat --}}
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="label"><i class="fa-solid fa-layer-group me-1"></i>Tipe Lantai</div>
                            <div class="value">{{ $facility->floor_type }}</div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="fa-solid fa-tag me-1"></i>Harga Sewa</div>
                            <div class="value price">Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}<small style="font-size:0.7rem;font-weight:500;color:#6b7280;">/jam</small></div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="fa-solid fa-circle-check me-1"></i>Status</div>
                            <div class="value">
                                @if($facility->is_active)
                                    <span style="color: #16a34a;">● Tersedia</span>
                                @else
                                    <span style="color: #dc2626;">● Tidak Tersedia</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="label"><i class="fa-solid fa-location-dot me-1"></i>Alamat</div>
                            <div class="value" style="font-size:0.82rem;font-weight:500;color:#4b5563;">{{ Str::limit($facility->mitra->address ?? 'Bandung', 30) }}</div>
                        </div>
                    </div>

                    {{-- Fasilitas / Amenities --}}
                    @if($facility->amenities)
                        @php
                            $amenities = is_array($facility->amenities) 
                                ? $facility->amenities 
                                : json_decode($facility->amenities, true);
                        @endphp
                        @if($amenities && count($amenities) > 0)
                            <div class="section-title">Fasilitas Tersedia</div>
                            <div class="amenities-list">
                                @foreach($amenities as $item)
                                    <span class="amenity-chip"><i class="fa-solid fa-check"></i>{{ $item }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endif

                    {{-- Deskripsi --}}
                    @if($facility->description)
                        <div class="section-title" style="margin-top: 20px;">Deskripsi Lapangan</div>
                        <p class="facility-desc">{{ $facility->description }}</p>
                    @endif

                    {{-- Google Maps --}}
                    @if($facility->gmaps_link)
                        <a href="{{ $facility->gmaps_link }}" target="_blank" class="gmaps-link">
                            <i class="fa-brands fa-google"></i> Lihat di Google Maps
                        </a>
                    @endif

                </div>
            </div>

            {{-- ---- KOLOM KANAN: Form Booking ---- --}}
            <div class="card-booking">

                {{-- Alert Flash Message --}}
                @if(session('success'))
                    <div class="alert-boma success">
                        <i class="fa-solid fa-circle-check mt-1"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-boma error">
                        <i class="fa-solid fa-circle-exclamation mt-1"></i>
                        <div>
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="booking-header">
                    <h3>Pesan Lapangan</h3>
                </div>
                <div class="price-display">
                    Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}
                    <span>/ jam</span>
                </div>

                <hr class="divider">

                @auth
                    {{-- ============================================
                         FORM BOOKING — Hanya tampil jika sudah login
                    ============================================ --}}
                    @if($facility->is_active)
                        <form action="{{ route('booking.store') }}" method="POST" id="formBooking">
                            @csrf

                            {{-- Hidden: facility_id --}}
                            <input type="hidden" name="facility_id" value="{{ $facility->id }}">

                            {{-- Tanggal Main --}}
                            <div class="form-group-boma">
                                <label class="form-label-boma">
                                    <i class="fa-regular fa-calendar me-1"></i>Tanggal Main
                                </label>
                                <input 
                                    type="date" 
                                    name="booking_date" 
                                    id="bookingDate"
                                    class="form-control-boma"
                                    min="{{ date('Y-m-d') }}"
                                    value="{{ old('booking_date') }}"
                                    required
                                >
                            </div>

                            {{-- Jam Mulai --}}
                            <div class="form-group-boma">
                                <label class="form-label-boma">
                                    <i class="fa-regular fa-clock me-1"></i>Jam Mulai
                                </label>
                                <select name="start_time" id="startTime" class="form-control-boma" required>
                                    <option value="">-- Pilih Jam --</option>
                                    
                                    {{-- SUNTIKAN DINAMIS: Generate jam otomatis ngikut database lapangan --}}
                                    @php
                                        $open = \Carbon\Carbon::parse($facility->opening_time ?? '06:00');
                                        $close = \Carbon\Carbon::parse($facility->closing_time ?? '22:00');
                                        $current = $open->clone();
                                    @endphp

                                    @while ($current->lt($close))
                                        @php
                                            $timeString = $current->format('H:i');
                                        @endphp
                                        <option value="{{ $timeString }}" {{ old('start_time') == $timeString ? 'selected' : '' }}>
                                            {{ $timeString }} WIB
                                        </option>
                                        @php
                                            $current->addHour();
                                        @endphp
                                    @endwhile
                                </select>
                            </div>

                            {{-- Jumlah Sesi --}}
                            <div class="form-group-boma">
                                <label class="form-label-boma">
                                    <i class="fa-solid fa-hourglass-half me-1"></i>Durasi (Jam)
                                </label>
                                <div class="sesi-selector">
                                    @foreach([1,2,3,4,5,6,7,8] as $sesi)
                                        <button 
                                            type="button" 
                                            class="sesi-btn {{ old('jumlah_sesi') == $sesi ? 'active' : ($sesi == 1 ? 'active' : '') }}"
                                            data-sesi="{{ $sesi }}"
                                            onclick="pilihSesi({{ $sesi }}, this)"
                                        >{{ $sesi }} Jam</button>
                                    @endforeach
                                </div>
                                {{-- Hidden input untuk dikirim ke server --}}
                                <input type="hidden" name="jumlah_sesi" id="jumlahSesi" value="{{ old('jumlah_sesi', 1) }}">
                            </div>

                            <hr class="divider">

                            {{-- Ringkasan Harga --}}
                            <div class="price-summary">
                                <div class="row-price">
                                    <span>Harga Sewa</span>
                                    <span>Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }} × <span id="summSesi">1</span> jam</span>
                                </div>
                                <div class="row-price">
                                    <span>Biaya Layanan</span>
                                    <span>Gratis</span>
                                </div>
                                <div class="row-price total">
                                    <span>Total Bayar</span>
                                    <span class="amount" id="summTotal">
                                        Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit" class="btn-pesan" id="btnPesan">
                                <i class="fa-solid fa-basket-shopping me-2"></i>Konfirmasi Booking
                            </button>

                            <div class="booking-note">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Booking akan berstatus <strong>Pending</strong> hingga pembayaran dikonfirmasi. Pastikan data yang kamu isi sudah benar sebelum submit.</span>
                            </div>

                        </form>
                    @else
                        {{-- Lapangan sedang tidak aktif --}}
                        <div class="login-prompt">
                            <i class="fa-solid fa-tools" style="font-size: 2rem; color: #d97706; margin-bottom: 10px;"></i>
                            <p>Lapangan ini sedang <strong>tidak tersedia</strong> untuk disewa saat ini. Silakan cek lapangan lain atau coba lagi nanti.</p>
                            <a href="{{ route('booking') }}" class="btn-login-booking" style="background-color: #d97706;">
                                <i class="fa-solid fa-arrow-left me-1"></i>Lihat Lapangan Lain
                            </a>
                        </div>
                    @endif

                @endauth

                @guest
                    {{-- ============================================
                         LOGIN PROMPT — Tampil jika belum login
                    ============================================ --}}
                    <div class="login-prompt">
                        <i class="fa-solid fa-lock" style="font-size: 2rem; color: #008774; margin-bottom: 12px;"></i>
                        <p>Kamu perlu <strong>login</strong> terlebih dahulu untuk bisa memesan lapangan ini.</p>
                        <a href="{{ route('login') }}" class="btn-login-booking">
                            <i class="fa-solid fa-right-to-bracket me-1"></i>Login Sekarang
                        </a>
                        <div style="margin-top: 12px; font-size: 0.78rem; color: #9ca3af;">
                            Belum punya akun? <a href="{{ route('register') }}" style="color: #008774; font-weight: 600;">Daftar di sini</a>
                        </div>
                    </div>
                @endguest

            </div>
            {{-- ---- END KOLOM KANAN ---- --}}

        </div>
    </main>

    {{-- ============================================================
         FOOTER — Konsisten dengan halaman lain
    ============================================================ --}}
@include('partials.footer')

    {{-- ============================================================
         JAVASCRIPT: Kalkulasi harga real-time
    ============================================================ --}}
    <script>
        const pricePerHour = {{ $facility->price_per_hour }};

        function pilihSesi(sesi, el) {
            // Reset semua tombol sesi
            document.querySelectorAll('.sesi-btn').forEach(btn => btn.classList.remove('active'));
            // Aktifkan tombol yang diklik
            el.classList.add('active');
            // Update hidden input
            document.getElementById('jumlahSesi').value = sesi;
            // Update summary
            document.getElementById('summSesi').textContent = sesi;
            const total = pricePerHour * sesi;
            document.getElementById('summTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Inisialisasi sesuai nilai default (1 jam)
        document.addEventListener('DOMContentLoaded', function () {
            const defaultSesi = parseInt(document.getElementById('jumlahSesi').value) || 1;
            pilihSesi(defaultSesi, document.querySelector(`.sesi-btn[data-sesi="${defaultSesi}"]`));

            // Set min date untuk input tanggal = hari ini
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('bookingDate').setAttribute('min', today);
        });

        // Konfirmasi sebelum submit
        document.getElementById('formBooking')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const tgl = document.getElementById('bookingDate').value;
            const jam = document.getElementById('startTime').value;
            const sesi = document.getElementById('jumlahSesi').value;
            const total = pricePerHour * parseInt(sesi);

            if (!tgl || !jam) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Eh, ada yang kosong!',
                    text: 'Pastikan tanggal dan jam main sudah dipilih ya.',
                    confirmButtonColor: '#008774',
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Booking',
                html: `
                    <div style="text-align: left; font-size: 0.9rem;">
                        <p>🏟️ <b>Lapangan:</b> {{ $facility->name }}</p>
                        <p>📅 <b>Tanggal:</b> ${tgl}</p>
                        <p>🕐 <b>Jam Mulai:</b> ${jam} WIB</p>
                        <p>⏱️ <b>Durasi:</b> ${sesi} jam</p>
                        <p>💰 <b>Total Bayar:</b> <span style="color:#008774;font-weight:700;">Rp ${total.toLocaleString('id-ID')}</span></p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#008774',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Booking!',
                cancelButtonText: 'Cek Lagi',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formBooking').submit();
                }
            });
        });
    </script>

</body>
</html>