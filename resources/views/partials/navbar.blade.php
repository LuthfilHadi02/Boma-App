{{-- resources/views/partials/navbar.blade.php --}}
<header class="navbar bg-accent">
    <div class="logo-container">
        {{-- Klik logo otomatis balik ke landing page utama --}}
        <a href="{{ url('/') }}" style="text-decoration: none; display: flex; align-items: center; gap: inherit; color: inherit;">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60">
            <div class="logo-text">
                Badan Olahraga<br>Mahasiswa
            </div>
        </a>
    </div>

    <nav class="nav-links">
        {{-- Logika jangkar pintar: kalau di home smooth scroll, kalau di luar halaman terbang balik ke home --}}
        <a href="{{ Request::is('/') ? '#home' : url('/#home') }}">Home</a>
        <a href="{{ Request::is('/') ? '#profil' : url('/#profil') }}">Visi-Misi</a>
        <a href="{{ Request::is('/') ? '#kategori' : url('/#kategori') }}">Divisi</a>
        <a href="{{ Request::is('/') ? '#recent' : url('/#recent') }}">Berita</a>
        <a href="{{ route('jadwal.index') }}">Jadwal Latihan</a>
        <a href="{{ route('booking') }}">Booking Lapang</a>
        <a href="{{ Request::is('/') ? '#articles' : url('/#articles') }}">Tentang Kami</a>
    </nav>

    <div class="nav-right">
    @auth
        {{-- SUNTIKAN ID DISINI BRAY BIAR DIKENAL GLOBAL --}}
        <div class="profile-dropdown" id="bomaProfileDropdown">
            {{-- SUNTIKAN ONCLICK INLINE GLOBAL BIAR BYPASS ERROR BOOKING.JS --}}
            <a href="#" class="profile-trigger" onclick="window.toggleBomaMenu(event)">
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
                {{-- 🚀 SUNTIKAN SAKTI: Link Latihan Saya nongol di semua page bray! --}}
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
</header>

<style>
    /* ============================================================
        BOMA PURE CLICK DROPDOWN (ANTI HOVER, ANTI BUG, TOKCER MOBILE)
    ============================================================ */
    .profile-dropdown {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none; /* Default sembunyi murni bray */
        position: absolute;
        right: 0;
        top: 100%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 8px 0;
        margin-top: 8px;
        min-width: 160px;
        z-index: 9999 !important;
    }

    /* 🚀 SAKTI: Dropdown baru muncul kalau ada class .show-menu (Murni via Klik) */
    .profile-dropdown.show-menu .dropdown-menu {
        display: block !important;
    }

    /* Styling link di dalam menu */
    .dropdown-item-link {
        display: flex !important;
        align-items: center;
        gap: 8px;
        padding: 10px 16px !important;
        color: #334155 !important;
        text-decoration: none !important;
        font-size: 0.85rem !important;
        font-weight: 500;
        transition: background 0.15s;
    }
    .dropdown-item-link:hover {
        background: #f1f5f9 !important;
        color: #008774 !important;
    }
</style>

<script>
    (function() {
        // Bikin fungsi global biar nempel langsung di window browser, anti diblocking script lain!
        window.toggleBomaMenu = function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            const dropdown = document.getElementById('bomaProfileDropdown');
            if (dropdown) {
                dropdown.classList.toggle('show-menu');
            }
        };

        // Global click buat nutup si dropdown di mana aja bray
        document.addEventListener('click', function() {
            const dropdown = document.getElementById('bomaProfileDropdown');
            if (dropdown) dropdown.classList.remove('show-menu');
        });
    })();
</script>