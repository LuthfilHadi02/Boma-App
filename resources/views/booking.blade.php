<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Lapangan - BOMA</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/booking.css') }}">
</head>
<body>

    <header class="navbar bg-accent">
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
        <div class="profile-dropdown">
            <a href="#" class="profile-trigger">
                <i class="fas fa-user-circle"></i> Profile <i class="fas fa-chevron-down small-icon"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item-link">
                        <i class="fas fa-user"></i> My Account
                    </a>
                </li>
                
                <li><hr class="dropdown-divider"></li>
                
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn-link">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>

            <div class="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Search">
            </div>
        </div>
    </header>

    <main class="container">
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

        <section class="mb-50">
            <h2 class="section-title">Lebih Banyak</h2>
            <div class="grid-banyak">
                <div class="card-img-overlay tall-card">
                    <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Triditi Futsal">
                    <div class="badge-price">Rp 100.000/Jam</div>
                    <div class="content">
                        <h3>Triditi Futsal Corner</h3>
                        <p>Cibiru, Kota Bandung</p>
                    </div>
                </div>
                <div class="card-img-overlay">
                    <img src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Rabbani Basket">
                    <div class="badge-price">Rp 100.000/Jam</div>
                    <div class="content">
                        <h3>Rabbani Basket</h3>
                        <p>Ujung Berung, Kota Bandung</p>
                    </div>
                </div>
                <div class="card-img-overlay">
                    <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Futsal Erlangga">
                    <div class="badge-price">Rp 150.000/Jam</div>
                    <div class="content">
                        <h3>Futsal Erlangga</h3>
                        <p>Cibiru, Kota Bandung</p>
                    </div>
                </div>
                <div class="card-img-overlay">
                    <img src="https://images.unsplash.com/photo-1629851606558-7c8dd76e2cba?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Gor Hidayat">
                    <div class="badge-price">Rp 150.000/Jam</div>
                    <div class="content">
                        <h3>Gor Hidayat Badminton</h3>
                        <p>Cibiru, Kota Bandung</p>
                    </div>
                </div>
                <div class="card-img-overlay">
                    <img src="https://images.unsplash.com/photo-1551958219-acbc608c6aff?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Futsal Majasari">
                    <div class="badge-price">Rp 150.000/Jam</div>
                    <div class="content">
                        <h3>Line Futsal Majasari</h3>
                        <p>Cibiru, Kota Bandung</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-50">
            <h2 class="section-title">Lapangan Futsal</h2>
            <div class="grid-4">
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=400&q=80" alt="Futsal">
                        <span class="badge-popular">Popular Choice</span>
                    </div>
                    <h3>Triditi Futsal Corner</h3>
                    <p>Cibiru, Kota Bandung</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1551958219-acbc608c6aff?auto=format&fit=crop&w=400&q=80" alt="Futsal">
                    </div>
                    <h3>Futsal Madasuka</h3>
                    <p>Madasuka, Kota Bandung</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=400&q=80" alt="Futsal">
                    </div>
                    <h3>Futsal Cihuniuk</h3>
                    <p>Cihuniuk</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1629851606558-7c8dd76e2cba?auto=format&fit=crop&w=400&q=80" alt="Futsal">
                    </div>
                    <h3>Futsal Erlangga</h3>
                    <p>Cibiru</p>
                </div>
            </div>
        </section>

        <section class="mb-50">
            <h2 class="section-title">Lapangan Basket</h2>
            <div class="grid-4">
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&w=400&q=80" alt="Basket">
                        <span class="badge-popular">Popular Choice</span>
                    </div>
                    <h3>Rabbani Basket</h3>
                    <p>Ujung Berung, Kota Bandung</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&w=400&q=80" alt="Basket">
                        <span class="badge-popular">Popular Choice</span>
                    </div>
                    <h3>Rabbani Basket</h3>
                    <p>Ujung Berung, Kota Bandung</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&w=400&q=80" alt="Basket">
                        <span class="badge-popular">Popular Choice</span>
                    </div>
                    <h3>Rabbani Basket</h3>
                    <p>Ujung Berung, Kota Bandung</p>
                </div>
                <div class="card-standard">
                    <div class="img-box">
                        <img src="https://images.unsplash.com/photo-1504450758481-7338eba7524a?auto=format&fit=crop&w=400&q=80" alt="Basket">
                        <span class="badge-popular">Popular Choice</span>
                    </div>
                    <h3>Rabbani Basket</h3>
                    <p>Ujung Berung, Kota Bandung</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4>BADAN OLAHRAGA MAHASISWA</h4>
                    <p>Jl. Pendidikan No.15, Cibiru Wetan,<br>Kec. Cileunyi, Kabupaten Bandung,<br>Jawa Barat 40625.</p>
                    <div class="footer-bottom">© 2026 BOMA UPI Cibiru.</div>
                </div>
                <div class="footer-col">
                    <h4>TENTANG KAMI</h4>
                    <a href="#">Data Atlet & Staff</a>
                    <a href="#">Dokumentasi Kegiatan</a>
                    <a href="#">E-Learning Olahraga</a>
                    <a href="#">Ikatan Alumni BOMA</a>
                </div>
                <div class="footer-col">
                    <h4>KONTAK KAMI</h4>
                    <p><i class="fa-regular fa-envelope"></i> admin@boma.com</p>
                    <p><i class="fa-solid fa-phone"></i> +62 812 3456 7890</p>
                    <br>
                    <a href="#" class="social-btn"><i class="fa-brands fa-instagram"></i> Instagram</a>
                    <a href="#" class="social-btn"><i class="fa-brands fa-youtube"></i> YouTube</a>
                </div>
            </div>
        </div>
    </footer>
    
<script src="{{ asset('js/booking.js') }}"></script>
</body>
</html>