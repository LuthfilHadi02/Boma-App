<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA - Badan Olahraga Mahasiswa</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
        <a href="#home">Home</a>
        <a href="#profil">Visi-Misi</a>
        <a href="#kategori">Divisi</a>
        <a href="#recent">Berita</a>
        <a href="/jadwal">Jadwal Latihan</a>
        <a href="/booking">Booking Lapang</a>
        <a href="#articles">Tentang Kami</a>
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

    <main>
        <section class="hero-section" id="home" 
            style="background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)), url('{{ asset('src/foto_landingpage.jpeg') }}');">
            <div class="container hero-content">
                <div class="hero-left">
                    <h1 class="hero-title">
                        Sehatkan<br>Badanmu,<br>Banggakan<br>Kampusmu<br>Salam<br>Olahraga
                    </h1>
                </div>
                <div class="hero-right">
                    <div class="hero-desc-box">
                        <p class="hero-text">
                            Wadah terintegrasi untuk memantau jadwal pertandingan, statistik atlet, dan berita terbaru. Dukung terus divisi olahraga favoritmu dan jadilah saksi sejarah kebanggaan kampus.
                        </p>
                        <a href="https://instagram.com/boma_upicibiru" class="btn-primary" target="_blank">GABUNG BOMA</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="visi-misi section-padding" id="profil">
            <div class="container visi-misi-grid">
                <div class="visi-content">
                    <div class="visi-box">
                        <h3>VISI</h3>
                        <p>BOMA (Badan Olahraga Mahasiswa) hadir sebagai wadah untuk mengkoordinasi dan mengembangkan minat bakat di Kampus UPI di CIbiru</p>
                    </div>
                    <div class="misi-box">
                        <h3>MISI</h3>
                        <ul>
                            <li><strong>K</strong> = Kembangkan prestasi</li>
                            <li><strong>E</strong> = Eksplor potensi</li>
                            <li><strong>C</strong> = Ciptakan sportivitas</li>
                            <li><strong>E</strong> = Eratkan solidaritas</li>
                        </ul>
                    </div>
                </div>
                <div class="visi-image-container">
                    <img src="{{ asset('src/foto_login.jpeg') }}" alt="BOMA Kece">
                    <div class="visi-overlay">
                        <span class="hashtag">#BOMAKECE</span>
                        <p>BOMA hadir untuk mengembangkan minat bakat...</p>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="section-padding container" id="kategori">
            <h2 class="section-title text-center">DIVISI OLAHRAGA</h2>
            <div class="grid-3-cols">
                <article class="card">
                    <img src="{{ asset('src/Basket.png') }}" alt="Basket" class="card-img">
                    <div class="card-content">
                        <h2 class="card-title">Bidang Basket</h2>
                        <p class="card-desc">Informasi seputar jadwal latihan, roster, turnamen antar fakultas, dan pencapaian tim basket kampus.</p>
                        <a href="#" class="btn-primary">Learn More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/Futsal.png') }}" alt="Futsal" class="card-img">
                    <div class="card-content">
                        <h2 class="card-title">Bidang Futsal</h2>
                        <p class="card-desc">Kawal tim futsal kebanggaanmu. Pantau klasemen liga kampus dan jadwal latih tanding di sini.</p>
                        <a href="#" class="btn-primary">Learn More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/BuluTangkis.png') }}" alt="Bulu Tangkis" class="card-img">
                    <div class="card-content">
                        <h2 class="card-title">Bidang Bulu Tangkis</h2>
                        <p class="card-desc">Cek ketersediaan lapangan, pendaftaran anggota baru, dan raihan medali dari divisi bulu tangkis.</p>
                        <a href="#" class="btn-primary">Learn More</a>
                    </div>
                </article>
            </div>
        </section>

        <section class="section-padding container" id="recent">
            <h2 class="section-title text-center">BERITA KEGIATAN</h2>
            <div class="grid-3-cols">
                <article class="card">
                    <img src="{{ asset('src/Berita1.png') }}" alt="Berita 1" class="card-img" style="background-color: #ddd; height: 200px; display: block;">
                    <div class="card-content">
                        <span class="meta-text">26 Desember 2025</span>
                        <h2 class="card-title">Juara 2 dan Juara 3</h2>
                        <p class="card-desc">Muhammad Allen Al-Azizu, Mahasiswa Prodi Pendidikan Bisnis FPEB UPI Bersama Tim, Raih Juara 2 dan Juara 3 Kompetisi Basket Provinsi Jawa Barat.</p>
                        <a href="https://fpeb.upi.edu/news/muhammad-allen-al-azizu-mahasiswa-prodi-pendidikan-bisnis-fpeb-upi-bersama-tim-raih-juara-2-dan-juara-3-kompetisi-basket-provinsi-jawa-barat" class="btn-primary">Read More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/Berita2.png') }}" alt="Berita 2" class="card-img" style="background-color: #ddd; height: 200px; display: block;">
                    <div class="card-content">
                        <span class="meta-text">04 April 2026</span>
                        <h2 class="card-title">Tim Futsal Puteri UPI Bandung Juara di Malaysia</h2>
                        <p class="card-desc">Tim Futsal Putri Universitas Pendidikan Idonesia (UPI) Bandung berhasil mentasbihkan dirinya sebagai juara 1 setelah menghempaskan Tim Universitas Negeri Jakarta (UNJ) dengan skor 4-2 dalam ajang The 13th UiTM International Sports Fiesta 2018 di Panasonic Arena, Shah Alam, Malaysia.</p>
                        <a href="https://berita.upi.edu/tim-futsal-puteri-upi-bandung-juara-di-malaysia/" class="btn-primary">Read More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/Berita3.png') }}" alt="Berita 3" class="card-img" style="background-color: #ddd; height: 200px; display: block;">
                    <div class="card-content">
                        <span class="meta-text">03 April 2026</span>
                        <h2 class="card-title">FPOK UPI Raih Dua Medali Perunggu</h2>
                        <p class="card-desc">Kontingen Universitas Pendidikan Indonesia (UPI) kembali menorehkan prestasi gemilang di ajang Kejuaraan Nasional Bulutangkis antar Mahasiswa UM Cup 2025 yang berlangsung di Universitas Negeri Malang. Dari tiga nomor yang diikuti, UPI berhasil membawa pulang dua medali perunggu.</p>
                        <a href="https://fpok.upi.edu/mahasiswa-fpok-upi-raih-dua-medali-perunggu-di-kejurnas-bulutangkis-antar-mahasiswa-um-cup-2025/" class="btn-primary">Read More</a>
                    </div>
                </article>
            </div>
        </section>

    </main>

<footer class="site-footer" id="articles">
    <div class="container footer-grid">
        <div class="footer-col">
            <h2 class="footer-logo">BADAN OLAHRAGA MAHASISWA</h2>
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
</footer>

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>