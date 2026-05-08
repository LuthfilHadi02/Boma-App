<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Latihan - BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
</head>
<body>

    <header class="navbar bg-accent">
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text" >
                <a href="/#home">Badan Olahraga<br>Mahasiswa</a>
            </div>
        </div>
        
        <nav class="nav-links">
            <a href="/">Home</a>
            <a href="/#profil">Visi-Misi</a>
            <a href="/#kategori">Divisi</a>
            <a href="/#recent">Berita</a>
            <a href="/jadwal" class="active">Jadwal Latihan</a>
            <a href="/booking">Booking Lapang</a>
            <a href="/#articles">Tentang Kami</a>
        </nav>

        <div class="search-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" placeholder="Search">
        </div>
    </header>

    <main>
        <section class="schedule-header container text-center">
            <div class="badge-green">KALENDER LATIHAN</div>
            <h1 class="page-title">KALENDER LATIHAN<br>BADAN OLAHRAGA MAHASISWA</h1>
            <p class="page-desc">
                Informasi yang ditampilkan di kalender kegiatan latihan<br>
                Badan Olahraga Mahasiswa bersifat informasi umum dan dapat berubah sewaktu-<br>
                waktu tanpa pemberitahuan sebelumnya.
            </p>
        </section>

        <section class="container" style="padding-bottom: 80px;">
            <div class="calendar-card">
                <div class="calendar-nav">
                    <button class="nav-arrow">&#10094;</button> <h2 class="calendar-month">APRIL 2026</h2>
                    <button class="nav-arrow">&#10095;</button> </div>
                <div class="calendar-grid">
                    <div class="day-name">Senin</div>
                    <div class="day-name">Selasa</div>
                    <div class="day-name">Rabu</div>
                    <div class="day-name">Kamis</div>
                    <div class="day-name">Jum'at</div>
                    <div class="day-name">Sabtu</div>
                    <div class="day-name">Minggu</div>

                    <div id="calendar-days" style="display: contents;"></div>
                </div>
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

    <div id="modalKegiatan" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h2 id="modalTitle">Daftar Kegiatan</h2>
                <p id="modalSub">Selasa, 20 Maret 2026</p>
            </div>

            <div class="modal-body-wrapper">
                <div id="stepKonfirmasi" class="inner-green-card">
                    <h3 class="card-title">Apakah Anda Ingin Mengikuti Latihan?</h3>
                    <div class="activity-flex">
                        <img src="{{ asset('src/Basket.png') }}" alt="Latihan" class="activity-img" id="modalImg">
                        <div class="activity-info-col">
                            <div class="text-info">
                                <p><strong>Agenda Kegiatan :</strong><br><span id="modalAgenda">Latihan Basket</span></p>
                                <p><strong>Waktu :</strong><br><span id="modalWaktu">Rabu, 14 Maret 2026</span></p>
                                <p><strong>Tempat :</strong><br><span id="modalTempat">Lapangan Kampus UPI di Cibiru</span></p>
                            </div>
                            <div class="modal-actions">
                                <button class="btn-confirm-yes" onclick="showFormDiri()">Ya</button>
                                <button class="btn-confirm-no" onclick="closeModal()">Tidak</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="stepDataDiri" class="inner-green-card" style="display: none;">
                    <h3 class="card-title">Silahkan Isi Data Diri Anda</h3>
                    <form class="form-diri">
                        @csrf <div class="form-group-modal">
                            <label>Nama Lengkap</label>
                            <input type="text" id="inputNama" placeholder="Nama anda">
                        </div>
                        <div class="form-group-modal">
                            <label>Program Studi</label>
                            <input type="text" id="inputProdi" placeholder="Contoh = RPL">
                        </div>
                        <div class="form-group-modal">
                            <label>Angkatan</label>
                            <input type="text" id="inputAngkatan" placeholder="Contoh = 2025">
                        </div>
                        <div class="modal-actions" style="margin-top: 10px;">
                            <button type="button" class="btn-confirm-yes" onclick="validasiDanKirim()">Benar, Ikut!</button>
                            <button type="button" class="btn-confirm-no" onclick="closeModal()">Tidak</button>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </div>

    <script src="{{ asset('js/jadwal.js') }}"></script>
</body>
</html>