<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidang Basket - BOMA</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/basket.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-['Inter']">

    <header class="navbar bg-accentsticky top-0 z-50 transition-all duration-300">
        <div class="logo-container">
            <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" height="60" class="object-contain">
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
            <div class="profile-dropdown relative group">
                <a href="#" class="profile-trigger flex items-center gap-1">
                    <i class="fas fa-user-circle text-lg"></i> Profile <i class="fas fa-chevron-down small-icon text-[10px]"></i>
                </a>
                <ul class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item-link px-4 py-2.5 flex items-center gap-2 hover:bg-slate-50 text-slate-700 text-sm rounded-t-xl transition-colors">
                            <i class="fas fa-user text-slate-400"></i> My Account
                        </a>
                    </li>
                    <li><hr class="border-slate-100"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="logout-btn-link w-full text-left px-4 py-2.5 flex items-center gap-2 hover:bg-red-50 text-red-600 text-sm rounded-b-xl transition-colors">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

<div class="search-btn flex items-center gap-2 bg-white px-3 py-1.5 rounded-full border border-slate-200 focus-within:ring-2 focus-within:ring-emerald-800 transition-all">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-900">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <input type="text" placeholder="Search" class="bg-transparent border-none outline-none text-emerald-900 text-sm placeholder-slate-400 w-24 focus:w-36 transition-all duration-300">
</div>
        </div>
    </header>

    <section class="basket-hero min-h-[60vh] flex items-center relative overflow-hidden">
        <div class="container hero-content-basket relative z-10">
            <span class="badge-divisi inline-block bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full mb-4 tracking-wider uppercase">DIVISI OLAHRAGA</span>
            <h1 class="text-4xl md:text-6xl font-['Montserrat'] font-900 tracking-tight text-white mb-4">BASKETBALL</h1>
            <p class="text-lg text-white/90 max-w-xl mb-6 leading-relaxed">Membangun mental juara, kerjasama tim, dan sportivitas tinggi di dalam maupun luar lapangan.</p>
            <a href="#roster" class="btn-primary inline-block bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:bg-orange-700 transition-all transform hover:-translate-y-0.5">Lihat Roster Tim</a>
        </div>
    </section>

    <main class="container mx-auto px-4 py-12 space-y-16"> <section class="section-padding">
            <div class="about-basket-grid grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="about-text space-y-6">
                    <h2 class="text-3xl font-['Montserrat'] font-bold text-slate-900">Sejarah & Visi Divisi Basket</h2>
                    <p class="text-slate-600 leading-relaxed text-justify">Bidang Basket BOMA didirikan untuk mewadahi minat dan bakat mahasiswa dalam olahraga bola basket. Kami tidak hanya focus pada peningkatan <em class="text-orange-600 font-medium not-italic">skill</em> individu, tetapi juga pada pembentukan karakter dan solidaritas tim.</p>
                    
                    <div class="stats-row grid grid-cols-3 gap-4 pt-4">
                        <div class="stat-box p-4 bg-white rounded-2xl shadow-sm border border-slate-100 text-center transition-all hover:shadow-md">
                            <h3 class="text-3xl font-['Montserrat'] font-extrabold text-orange-600">15+</h3>
                            <span class="text-xs text-slate-500 font-medium block mt-1">Penghargaan</span>
                        </div>
                        <div class="stat-box p-4 bg-white rounded-2xl shadow-sm border border-slate-100 text-center transition-all hover:shadow-md">
                            <h3 class="text-3xl font-['Montserrat'] font-extrabold text-emerald-600">40</h3>
                            <span class="text-xs text-slate-500 font-medium block mt-1">Anggota Aktif</span>
                        </div>
                        <div class="stat-box p-4 bg-white rounded-2xl shadow-sm border border-slate-100 text-center transition-all hover:shadow-md">
                            <h3 class="text-3xl font-['Montserrat'] font-extrabold text-blue-600">2</h3>
                            <span class="text-xs text-slate-500 font-medium block mt-1">Pelatih Pro</span>
                        </div>
                    </div>
                </div>
                <div class="about-img overflow-hidden rounded-2xl shadow-xl border border-slate-100 transform hover:scale-[1.01] transition-all duration-300">
                    <img src="https://images.unsplash.com/photo-1546519638-68e109498ffc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Tim Basket BOMA" class="w-full h-auto object-cover">
                </div>
            </div>
        </section>

        <section id="roster" class="section-padding !pt-2 !pb-12 scroll-mt-24">
            <div class="text-center max-w-xl mx-auto mb-6 space-y-1">
                <h2 class="section-title text-3xl font-['Montserrat'] font-black text-slate-900 uppercase">Roster Tim Basket</h2>
                <p class="text-slate-500 text-sm">Kenali para pilar lapangan kami musim ini</p>
            </div>

            <div class="roster-tabs flex justify-center gap-4 mb-6">
                <a href="{{ route('divisi.basket', ['gender' => 'putra']) }}" class="tab-btn px-6 py-2.5 rounded-full font-semibold text-sm border transition-all text-center no-underline {{ $gender === 'putra' ? 'bg-emerald-900 text-white border-emerald-900 shadow-md shadow-emerald-950/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Tim Putra</a>
                <a href="{{ route('divisi.basket', ['gender' => 'putri']) }}" class="tab-btn px-6 py-2.5 rounded-full font-semibold text-sm border transition-all text-center no-underline {{ $gender === 'putri' ? 'bg-emerald-900 text-white border-emerald-900 shadow-md shadow-emerald-950/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">Tim Putri</a>
            </div>

            <div class="w-full py-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 justify-center">
                    @forelse($rosters as $roster)
                    <div class="w-full h-auto">
                        <div class="group relative aspect-[3/4] w-full bg-[#072418] rounded-2xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.1)] border border-emerald-950/40 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            
                            <div class="absolute inset-0 w-full h-full">
                                @if($roster->photo)
                                    <img src="{{ asset('storage/'.$roster->photo) }}" alt="{{ $roster->name }}" class="w-full h-full object-cover object-top block transition-transform duration-500 ease-out group-hover:scale-105">
                                /@else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-b from-emerald-950 to-[#072418]">
                                        <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Default" class="opacity-15 object-contain w-3/4 h-3/4 p-6">
                                    </div>
                                @endif
                            </div>

                            <div class="absolute inset-0 bg-gradient-to-t from-[#072418] via-[#072418]/80 via-40% to-transparent transition-all duration-300"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                            
                            <div class="absolute top-4 left-4 w-8 h-8 bg-[#ff6b00] text-white text-xs font-black rounded-full flex items-center justify-center border-2 border-white/20 z-10 shadow-[0_4px_12px_rgba(255,107,0,0.35)]">
                                {{ $roster->number }}
                            </div>

                            <div class="absolute bottom-0 left-0 w-full p-4 pb-5 z-10 flex flex-col gap-0.5">
                                <span class="text-[10px] tracking-wider text-emerald-400 font-extrabold uppercase flex items-center gap-1.5 mb-1 drop-shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Active Player
                                </span>
                                <h3 class="text-sm md:text-base font-black text-white leading-tight tracking-wide uppercase line-clamp-2 font-['Montserrat'] drop-shadow-[0_2px_4px_rgba(0,0,0,0.6)]">
                                    {{ $roster->name }}
                                </h3>
                                <p class="text-[11px] font-normal text-slate-300/80 line-clamp-1 mt-0.5">
                                    {{ $roster->position }}
                                </p>
                            </div>

                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-20 text-slate-400">
                        <i class="fa-regular fa-folder-open text-5xl block mb-4 text-slate-300"></i>
                        <p class="text-sm">Belum ada data roster untuk kategori ini, bre.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="section-padding">
            <div class="schedule-banner bg-gradient-to-br from-emerald-900 to-slate-950 text-white rounded-3xl p-8 md:p-12 text-center shadow-xl relative overflow-hidden space-y-6">
                <div class="relative z-10 space-y-3">
                    <h2 class="text-3xl font-['Montserrat'] font-bold">Ingin Bergabung Bersama Kami?</h2>
                    <p class="text-slate-300 max-w-lg mx-auto text-sm md:text-base">Latihan rutin diadakan di GOR Kampus. Buka untuk semua tingkat kemampuan!</p>
                </div>
                <div class="jadwal-badges flex flex-wrap justify-center gap-3 relative z-10">
                    <span class="badge-waktu bg-white/10 px-4 py-2 rounded-xl text-xs font-medium border border-white/10 flex items-center gap-2"><i class="fa-regular fa-calendar text-orange-400"></i> Selasa & Kamis</span>
                    <span class="badge-waktu bg-white/10 px-4 py-2 rounded-xl text-xs font-medium border border-white/10 flex items-center gap-2"><i class="fa-regular fa-clock text-orange-400"></i> 16.00 - 18.00 WIB</span>
                </div>
                <div class="relative z-10 pt-2">
                    <button class="btn-basket-join bg-orange-600 hover:bg-orange-700 text-white text-sm font-semibold px-8 py-3.5 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">Daftar Anggota Baru</button>
                </div>
            </div>
        </section>

    </main>

    <footer class="site-footer bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800" id="articles">
        <div class="container mx-auto px-4">
            <div class="footer-grid grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                
                <div class="footer-col space-y-4">
                    <h4 class="text-white font-['Montserrat'] font-bold tracking-wider text-sm uppercase">BADAN OLAHRAGA MAHASISWA</h4>
                    <p class="footer-address text-sm leading-relaxed">
                        Jl. Pendidikan No.15, Cibiru Wetan, <br>
                        Kec. Cileunyi, Kabupaten Bandung, <br>
                        Jawa Barat 40625.
                    </p>
                    <div class="copyright-bottom text-xs text-slate-500 pt-4">
                        &copy; 2026 BOMA UPI Cibiru.
                    </div>
                </div>

                <div class="footer-col space-y-4">
                    <h4 class="text-white font-['Montserrat'] font-bold tracking-wider text-sm uppercase">TENTANG KAMI</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Data Atlet & Staff</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Dokumentasi Kegiatan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">E-Learning Olahraga</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Ikatan Alumni BOMA</a></li>
                    </ul>
                </div>

                <div class="footer-col space-y-4">
                    <h4 class="text-white font-['Montserrat'] font-bold tracking-wider text-sm uppercase">KONTAK KAMI</h4>
                    <div class="contact-info space-y-2 text-sm">
                        <p class="flex items-center gap-2"><i class="fa-solid fa-envelope text-orange-500 w-4"></i> boma@upicibiru.ac.id</p>
                        <p class="flex items-center gap-2"><i class="fa-solid fa-phone text-orange-500 w-4"></i> (022) 7801332</p>
                    </div>
                    <div class="social-pills flex flex-wrap gap-2 pt-2">
                        <a href="https://www.instagram.com/boma_upicibiru/" class="pill bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1.5 transition-colors">
                            <i class="fa-brands fa-instagram text-pink-500"></i> Instagram
                        </a>
                        <a href="#" class="pill bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1.5 transition-colors">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i> WhatsApp
                        </a>
                        <a href="https://www.youtube.com/@KampusUPI" class="pill bg-slate-800 hover:bg-slate-700 text-slate-300 px-3 py-1.5 rounded-lg text-xs flex items-center gap-1.5 transition-colors">
                            <i class="fa-brands fa-youtube text-red-500"></i> YouTube
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>