<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidang Bulu Tangkis - BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/bulutangkis.css') }}">
</head>
<body>

    <header class="navbar bg-accent">
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text">Badan Olahraga<br>Mahasiswa</div>
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

    <section class="badminton-hero">
        <div class="container hero-content-badminton">
            <span class="badge-divisi">DIVISI OLAHRAGA</span>
            <h1>BADMINTON</h1>
            <p>Fokus, kecepatan, dan presisi. Kami mencetak atlet tangguh yang siap mengharumkan nama kampus di setiap pukulan smash.</p>
            <a href="#roster" class="btn-primary">Lihat Roster Tim</a>
        </div>
    </section>

    <main class="container">
        <section class="section-padding">
            <div class="about-badminton-grid">
                <div class="about-text">
                    <h2>Sejarah & Visi Divisi Bulu Tangkis</h2>
                    <p>Bidang Bulu Tangkis BOMA adalah tempat bertemunya para pecinta tepok bulu. Kami melatih ketangkasan fisik dan mental untuk berlaga di nomor tunggal maupun ganda, serta membangun semangat pantang menyerah.</p>
                    <div class="stats-row">
                        <div class="stat-box">
                            <h3>30+</h3>
                            <span>Medali Emas</span>
                        </div>
                        <div class="stat-box">
                            <h3>50</h3>
                            <span>Atlet Aktif</span>
                        </div>
                        <div class="stat-box">
                            <h3>2</h3>
                            <span>Pelatih Nasional</span>
                        </div>
                    </div>
                </div>
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Bulu Tangkis BOMA">
                </div>
            </div>
        </section>

        <section id="roster" class="section-padding">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="section-title">Roster Atlet Bulu Tangkis</h2>
                <p>Kenali para atlet andalan yang siap berlaga di berbagai sektor</p>
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
                <p>Latihan rutin diadakan di GOR Kampus. Siapkan raketmu dan mari berlatih!</p>
                <div class="jadwal-badges">
                    <span class="badge-waktu"><i class="fa-regular fa-calendar"></i> Rabu & Jumat</span>
                    <span class="badge-waktu"><i class="fa-regular fa-clock"></i> 15.00 - 18.00 WIB</span>
                </div>
                <a href="#">
                    <button class="btn-badminton-join">Daftar Anggota Baru</button>
                </a>
            </div>
        </section>
    </main>

    <footer class="site-footer" id="articles">
        <div class="container text-center">
            <p>© 2026 BOMA UPI Cibiru. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/bulutangkis.js') }}"></script>
</body>
</html>