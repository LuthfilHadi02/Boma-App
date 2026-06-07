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
    
    <link rel="stylesheet" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jadwal.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <li>
                            <a href="{{ route('latihan.history') }}" class="dropdown-item-link" style="color: #008774; font-weight: 600; margin-top: 5px; display: block;">
                                <i class="fas fa-dumbbell"></i> Latihan Saya
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

   <div id="modalKegiatan" class="modal-overlay">
        <div class="modal-container" style="max-width: 600px;">
            <div class="modal-header">
                <h2 id="modalTitle">Daftar Kegiatan</h2>
                <p id="modalSub">Selasa, 20 Maret 2026</p>
            </div>

            <div class="modal-body-wrapper">
                <div id="stepKonfirmasi" class="inner-green-card" style="padding: 25px;">
                    <h3 class="card-title" style="margin-bottom: 20px;">Apakah Anda Ingin Mengikuti Latihan Ini bray?</h3>
                    
                    <div class="activity-flex" style="gap: 20px;">
                        <img src="{{ asset('src/Basket.png') }}" alt="Latihan" class="activity-img" id="modalImg" style="width: 180px; height: 130px;">
                        
                        <div class="activity-info-col">
                            <div class="text-info" style="font-size: 14px;">
                                <p><strong>Agenda:</strong> <span id="modalAgenda">Latihan Basket</span></p>
                                <p><strong>Waktu:</strong> <span id="modalWaktu">Rabu, 14 Maret 2026</span></p>
                                <p><strong>Tempat:</strong> <span id="modalTempat">Lapangan Kampus UPI di Cibiru</span></p>
                                
                                <div class="kuota-container" style="margin-top: 10px; padding: 10px; background: rgba(255,255,255,0.15); border-radius: 8px;">
                                    <p style="margin-bottom: 5px; font-size: 12px;">
                                        <strong>Status Slot Kuota:</strong> 
                                        <span id="kuotaTeks" style="float: right; font-weight: 700;">0/0 Terisi</span>
                                    </p>
                                    <div style="width: 100%; height: 6px; background: rgba(0,0,0,0.1); border-radius: 10px; overflow: hidden;">
                                        <div id="kuotaBar" style="width: 0%; height: 100%; background: #059669; transition: 0.5s;"></div>
                                    </div>
                                    <p id="kuotaPeringatan" style="margin-top: 5px; font-size: 11px; color: #FF4B4B; display: none; font-weight: 600;">
                                        <i class="fa-solid fa-circle-exclamation"></i> Yah, kuota latihan udah penuh pak!
                                    </p>
                                </div>
                            </div>

                            <form id="formIkutLatihan" method="POST" action="" style="margin-top: 15px;">
                                @csrf
                                <div class="modal-actions">
                                    <button type="submit" class="btn-confirm-yes" id="btnLanjutIsiData" style="width: 100px; text-align: center;">Ya, Ikut!</button>
                                    <button type="button" class="btn-confirm-no" onclick="window.closeModal()">Tidak</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <script>
        window.isUserLoggedIn = @json(Auth::check());
        window.dataJadwalDB = @json($schedules ?? []);
    </script>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Mantap Terdaftar, Bray! 🎉',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#008774',
                    background: '#ffffff',
                    customClass: { popup: 'rounded-2xl' }
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Waduh, Gagal Pak! ⚠️',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonColor: '#ef4444',
                    background: '#ffffff',
                    customClass: { popup: 'rounded-2xl' }
                });
            });
        </script>
    @endif

    <script src="{{ asset('js/jadwal.js') }}"></script>
</body>
</html>