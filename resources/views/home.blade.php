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
    <link rel="stylesheet" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

@include('partials.navbar')
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
                        <a href="/divisi/basket" class="btn-primary">Learn More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/Futsal.png') }}" alt="Futsal" class="card-img">
                    <div class="card-content">
                        <h2 class="card-title">Bidang Futsal</h2>
                        <p class="card-desc">Kawal tim futsal kebanggaanmu. Pantau klasemen liga kampus dan jadwal latih tanding di sini.</p>
                        <a href="/divisi/futsal" class="btn-primary">Learn More</a>
                    </div>
                </article>

                <article class="card">
                    <img src="{{ asset('src/BuluTangkis.png') }}" alt="Bulu Tangkis" class="card-img">
                    <div class="card-content">
                        <h2 class="card-title">Bidang Bulu Tangkis</h2>
                        <p class="card-desc">Cek ketersediaan lapangan, pendaftaran anggota baru, dan raihan medali dari divisi bulu tangkis.</p>
                        <a href="/divisi/bulutangkis" class="btn-primary">Learn More</a>
                    </div>
                </article>
            </div>
        </section>

 <section class="section-padding container" id="recent">
    <h2 class="section-title text-center">BERITA KEGIATAN</h2>
    <div class="grid-3-cols">
        @forelse($beritas as $berita)
            <article class="card">
                <img src="{{ asset($berita->foto) }}" alt="{{ $berita->judul }}" class="card-img" style="height: 200px; object-fit: cover; display: block;">
                <div class="card-content">
                    <span class="meta-text">
                        {{ \Carbon\Carbon::parse($berita->tanggal_kegiatan)->translatedFormat('d F Y') }}
                    </span>
                    <h2 class="card-title">{{ $berita->judul }}</h2>
                    <p class="card-desc">{{ $berita->deskripsi_singkat }}</p>
                    @if($berita->link)
                        <a href="{{ $berita->link }}" target="_blank" class="btn-primary">Read More</a>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-12 text-center py-5">
                <p>Belum ada berita kegiatan terbaru nih.</p>
            </div>
        @endforelse
    </div>
</section>
    </main>

<!-- ================================================================= -->
<!-- 🏟️ FLOATING STICKY WIDGET MITRA BOMA (ANTI-SCROLL & INTERAKTIF) -->
<!-- ================================================================= -->

<!-- 1. Tombol Utama yang Melayang di Pojok Kanan Bawah -->
<div class="boma-floating-trigger" id="mitraWidgetTrigger" onclick="toggleMitraWidget()">
    <i class="fa-solid fa-store"></i>
    <span>Gabung Mitra</span>
</div>

<!-- 2. Kotak Pop-up Mini (Bisa Muncul & Sembunyi) -->
<div class="boma-floating-popcard" id="mitraPopCard">
    <div class="popcard-header">
        <h5>🚀 Peluang Bisnis GOR</h5>
        <button onclick="toggleMitraWidget(event)">&times;</button>
    </div>
    <div class="popcard-body">
        <h4>Punya Lapangan Nganggur?</h4>
        <p>Yuk, daftarkan GOR lu jadi Mitra Resmi BOMA! Kelola jadwal sewa otomatis dan jangkau ratusan tim mahasiswa setiap hari.</p>
        
        <a href="/mitra/register" class="btn-popcard-submit">
            Daftarkan Sekarang <i class="fa-solid fa-arrow-right-long"></i>
        </a>
    </div>
</div>

<!-- 🎨 STYLE NATIVE WIDGET (PENGAMANAN TOTAL DAN ANTI-TABRAKAN) -->
<style>

</style>




@include('partials.footer')

<script src="{{ asset('js/home.js') }}"></script>
</body>
</html>