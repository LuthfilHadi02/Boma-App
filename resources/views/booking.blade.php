<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Lapangan - BOMA</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>

    <header class="navbar bg-accent" style="position: relative; z-index: 99999;">
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text">
                Badan Olahraga<br>Mahasiswa
            </div>
        </div>

        <nav class="nav-links">
            <a href="/">Home</a>
            <a href="/#profil">Visi-Misi</a>
            <a href="/#kategori">Divisi</a>
            <a href="/#recent">Berita</a>
            <a href="/jadwal">Jadwal Latihan</a>
            <a href="/booking">Booking Lapang</a>
            <a href="/#articles">Tentang Kami</a>
        </nav>

         <div class="nav-right">
    @auth
        <div class="profile-dropdown">
            <a href="#" class="profile-trigger">
                <i class="fas fa-user-circle"></i> {{ Auth::user()->name }} <i class="fas fa-chevron-down small-icon"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item-link">
                        <i class="fas fa-user"></i> My Account
                    </a>
                </li>
                <li>
                    <a href="{{ route('booking.history') }}" class="dropdown-item-link" style="color: #008774; font-weight: 600;">
                        <i class="fas fa-receipt"></i> Pesanan Saya
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form-boma">
                        @csrf
                        <button type="submit" class="logout-btn-link" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    @endauth

    @guest
        <div class="auth-buttons" style="display: flex; gap: 15px; align-items: center; margin-right: 15px;">
            <a href="{{ route('login') }}" class="btn-login-boma" style="color: white; text-decoration: none; font-weight: 600; font-size: 14px;">Log In</a>
            <a href="{{ route('register') }}" class="btn-register-boma" style="background-color: #008774; color: white; padding: 8px 18px; border-radius: 25px; text-decoration: none; font-weight: 600; font-size: 14px; border: 2px solid white; transition: 0.3s;">Register</a>
        </div>
    @endguest

    <div class="search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" placeholder="Search">
    </div>
</div>
</header>

    <main class="container" style="min-height: 60vh; position: relative; z-index: 1;">
        <section class="hero">
            <div class="hero-text">
                <h1>Sewa Lapangan Lebih Cepat dan Hemat Di Bandung</h1>
                <p>Boma selain daripada untuk branding organisasi, kita juga membuka usaha untuk sewa lapangan agar bisa melatih enterpreneur dan juga mencari pemasukan untuk boma itu sendiri</p>
                <a href="#" class="hero-btn">Lihat Lebih Banyak</a>
                <div class="hero-stats">
                    <i class="fa-solid fa-location-dot" style="color: var(--primary); font-size: 24px;"></i>
                    <span>100 Fields</span>
                </div>
            </div>
            <div class="hero-img-container">
                <div class="hero-img-wrapper">
                    <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Lapangan Hero">
                </div>
            </div>
        </section>

        <section class="filter-wrapper">
            <div class="filter-bar">
                <div class="filter-item">
                    <i class="fa-regular fa-calendar main-icon"></i>
                    <input type="date" id="filterTanggal" class="filter-input">
                </div>

                <div class="filter-item">
                    <i class="fa-solid fa-running main-icon"></i>
                    <select id="filterCabang" class="filter-input">
                        <option value="" disabled selected>Cabang Olahraga</option>
                        <option value="Futsal">Futsal</option>
                        <option value="Basket">Basket</option>
                        <option value="Badminton">Badminton</option>
                    </select>
                </div>

                <div class="filter-item">
                    <i class="fa-solid fa-location-dot main-icon"></i>
                    <select id="filterKecamatan" class="filter-input">
                        <option value="" disabled selected>Kecamatan</option>
                        <option value="Cibiru">Cibiru</option>
                        <option value="Ujung Berung">Ujung Berung</option>
                        <option value="Madasuka">Madasuka</option>
                    </select>
                </div>
                <button class="btn-search">Search</button>
            </div>
        </section>

        <section class="mb-50" style="margin-bottom: 80px;">
            <h2 class="section-title">Lapangan yang Tersedia</h2>
            <div class="grid-banyak">
                
                @forelse($facilities as $item)
                    <a href="/detail-lapangan/{{ $item->id }}" 
                    class="card-link" 
                    data-auth="{{ Auth::check() ? 'true' : 'false' }}"
                    style="text-decoration: none; display: contents;">
                        <div class="card-img-overlay">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                            @else
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Default Image">
                            @endif
                            
                            <div class="badge-price">Rp {{ number_format($item->price_per_hour, 0, ',', '.') }}/Jam</div>
                            <div class="content">
                                <h3>{{ $item->name }}</h3>
                                <p>{{ $item->mitra->brand_name ?? 'Gor BOMA' }} - {{ $item->floor_type }}</p>
                                <small style="color: #cbd5e1; font-size: 11px;">📍 {{ $item->mitra->address ?? 'Bandung' }}</small>
                            </div>
                        </div>
                    </a>
                @empty
                    @endforelse

            </div>
        </section>
    </main>

    <footer class="site-footer" id="articles">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>BADAN OLAHRAGA MAHASISWA</h4>
                    <p class="footer-address">
                        Jl. Pendidikan No.15, Cibiru Wetan, <br>
                        Kec. Cileunyi, Kabupaten Bandung, <br>
                        Jawa Barat 40625.
                    </p>
                    <div class="copyright-bottom">
                        © 2026 BOMA UPI Cibiru.
                    </div>
                </div>

                <div class="footer-col">
                    <h4>TENTANG KAMI</h4>
                    <ul>
                        <li><a href="#">Data Atlet & Staff</a></li>
                        <li><a href="#">Dokumentasi Kegiatan</a></li>
                        <li><a href="#">E-Learning Olahraga</a></li>
                        <li><a href="#">Ikatan Alumni BOMA</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>KONTAK KAMI</h4>
                    <div class="contact-info">
                        <p><i class="fa-solid fa-envelope"></i> boma@upicibiru.ac.id</p>
                        <p><i class="fa-solid fa-phone"></i> (022) 7801332</p>
                    </div>
                    <div class="social-pills">
                        <a href="https://www.instagram.com/boma_upicibiru/" class="pill"><i class="fa-brands fa-instagram"></i> Instagram</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Suntikan pengaman biar file booking.js tahu user udah login atau belum
        window.isUserLoggedIn = @json(Auth::check());
    </script>
    <script src="{{ asset('js/booking.js') }}"></script>
</body>
</html>