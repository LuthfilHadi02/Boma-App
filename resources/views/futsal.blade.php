<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidang Futsal - BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/futsal.css') }}">
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
            <div class="search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Search">
            </div>
        </div>
    </header>

    <section class="futsal-hero">
        <div class="container hero-content-futsal">
            <span class="badge-divisi">DIVISI OLAHRAGA</span>
            <h1>FUTSAL</h1>
            <p>Mengasah kelincahan, taktik cepat, dan kekompakan tim di atas lapangan. Kami bermain dengan kebanggaan dan sportivitas.</p>
            <a href="#" class="btn-primary">Lihat Roster Tim</a>
        </div>
    </section>

    <main class="container">
        <section class="section-padding">
            <div class="about-futsal-grid">
                <div class="about-text">
                    <h2>Sejarah & Visi Divisi Futsal</h2>
                    <p>Bidang Futsal BOMA menjadi salah satu divisi dengan peminat tertinggi. Kami berdedikasi untuk mencetak talenta-talenta berbakat yang siap bertarung di berbagai liga kampus dan kejuaraan nasional, dengan menjunjung tinggi nilai persaudaraan.</p>
                    <div class="stats-row">
                        <div class="stat-box">
                            <h3>20+</h3>
                            <span>Trofi Liga</span>
                        </div>
                        <div class="stat-box">
                            <h3>65</h3>
                            <span>Anggota Aktif</span>
                        </div>
                        <div class="stat-box">
                            <h3>3</h3>
                            <span>Pelatih Berlisensi</span>
                        </div>
                    </div>
                </div>
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1511886929837-354d827aae26?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Futsal BOMA">
                </div>
            </div>
        </section>

        <section id="roster" class="section-padding">
            <div style="text-align: center; margin-bottom: 40px;">
                <h2 class="section-title">Roster Tim Futsal</h2>
                <p>Kenali para punggawa andalan lapangan kami musim ini</p>
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
                <p>Latihan rutin diadakan di Lapangan Futsal Utama. Ayo asah skill kamu!</p>
                <div class="jadwal-badges">
                    <span class="badge-waktu"><i class="fa-regular fa-calendar"></i> Senin & Rabu</span>
                    <span class="badge-waktu"><i class="fa-regular fa-clock"></i> 19.00 - 21.00 WIB</span>
                </div>
                <a href="{{ route('daftar.create') }}">
                    <button class="btn-futsal-join">Daftar Anggota Baru</button>
                </a>
            </div>
        </section>
    </main>

    <footer class="site-footer" id="articles">
        <div class="container text-center">
            <p>© 2026 BOMA UPI Cibiru. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <script src="{{ asset('js/futsal.js') }}"></script>
</body>
</html>