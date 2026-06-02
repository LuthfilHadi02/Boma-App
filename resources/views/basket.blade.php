<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidang Basket - BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/basket.css') }}">
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
            <a href="/#kategori" class="active">Divisi</a>
            <a href="/#recent">Berita</a>
            <a href="/jadwal">Jadwal Latihan</a>
            <a href="/booking">Sewa Lapangan</a>
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

    <section class="basket-hero">
        <div class="container hero-content-basket">
            <span class="badge-divisi">DIVISI OLAHRAGA</span>
            <h1>BASKETBALL</h1>
            <p>Membangun mental juara, kerjasama tim, dan sportivitas tinggi di dalam maupun luar lapangan.</p>
            <a href="#roster" class="btn-primary">Lihat Roster Tim</a>
        </div>
    </section>

    <main class="container">
        
        <section class="section-padding">
            <div class="about-basket-grid">
                <div class="about-text">
                    <h2>Sejarah & Visi Divisi Basket</h2>
                    <p>Bidang Basket BOMA didirikan untuk mewadahi minat dan bakat mahasiswa dalam olahraga bola basket. Kami tidak hanya fokus pada peningkatan <em>skill</em> individu, tetapi juga pada pembentukan karakter dan solidaritas tim.</p>
                    <div class="stats-row">
                        <div class="stat-box">
                            <h3>15+</h3>
                            <span>Penghargaan</span>
                        </div>
                        <div class="stat-box">
                            <h3>40</h3>
                            <span>Anggota Aktif</span>
                        </div>
                        <div class="stat-box">
                            <h3>2</h3>
                            <span>Pelatih Pro</span>
                        </div>
                    </div>
                </div>
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Basket BOMA">
                </div>
            </div>
        </section>

        <section id="roster" class="section-padding">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="section-title">Roster Tim Basket</h2>
                <p>Kenali para pilar lapangan kami musim ini</p>
            </div>

            <div class="roster-tabs">
                <button class="tab-btn active" onclick="filterRoster('putra')">Tim Putra</button>
                <button class="tab-btn" onclick="filterRoster('putri')">Tim Putri</button>
            </div>

            <div class="roster-grid" id="rosterGrid">
                </div>
        </section>

        <section class="section-padding">
            <div class="schedule-banner">
                <h2>Ingin Bergabung Bersama Kami?</h2>
                <p>Latihan rutin diadakan di GOR Kampus. Buka untuk semua tingkat kemampuan!</p>
                <div class="jadwal-badges">
                    <span class="badge-waktu"><i class="fa-regular fa-calendar"></i> Selasa & Kamis</span>
                    <span class="badge-waktu"><i class="fa-regular fa-clock"></i> 16.00 - 18.00 WIB</span>
                </div>
                <button class="btn-basket-join">Daftar Anggota Baru</button>
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
                        <a href="https://www.instagram.com/boma_upicibiru/" class="pill">
                            <i class="fa-brands fa-instagram"></i> Instagram
                        </a>
                        <a href="#" class="pill">
                            <i class="fa-brands fa-whatsapp"></i> WhatsApp
                        </a>
                        <a href="https://www.youtube.com/@KampusUPI" class="pill">
                            <i class="fa-brands fa-youtube"></i> YouTube
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

    <script src="{{ asset('js/basket.js') }}"></script>
</body>
</html>