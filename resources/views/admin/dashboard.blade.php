<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Dashboard Teal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="d-flex">
        
        <div class="boma-sidebar p-3 text-white">
            <div class="sidebar-brand mb-4 px-2 d-flex align-items-center justify-content-between">
                <div class="brand-text">
                    <h4 class="fw-bold text-teal-light mb-0">BOMA</h4>
                    <span class="fs-6 text-white fw-normal">Admin</span>
                </div>
                <img src="{{ asset('src/Foto_LogoBoma.png') }}" alt="Logo BOMA" class="sidebar-logo">
            </div>
            
            <ul class="nav nav-pills flex-column mb-auto gap-1 list-unstyled">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link text-white {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie me-2"></i> Dashboard Overview
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.berita.index') }}" class="nav-link text-white {{ Request::is('admin/berita*') ? 'active' : '' }}">
                        <i class="fa-solid fa-newspaper me-2"></i> Kelola Berita Kegiatan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mitra.index') }}" class="nav-link text-white {{ Request::is('admin/mitra*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building-user me-2"></i> Persetujuan Mitra
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.facilities.index') }}" class="nav-link text-white {{ Request::is('admin/facilities*') || Request::is('admin/facility*') ? 'active' : '' }}">
                        <i class="fa-solid fa-map-location-dot me-2"></i> Kelola Fasilitas Lapangan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.schedule.index') }}" class="nav-link text-white {{ Request::is('admin/schedule*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days me-2"></i> Kelola Jadwal Latihan
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="fa-solid fa-users me-2"></i> Verifikasi Akun Pengguna
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payments.index') }}" class="nav-link text-white">
                        <i class="fa-solid fa-receipt me-2"></i> Transaksi & Refund
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#rosterSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->is('admin/roster*') ? 'active' : '' }}">
                        <div><i class="fa-solid fa-users-gear me-2"></i> Kelola Roster Tim</div>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem;"></i>
                    </a>
                    <ul class="collapse list-unstyled mt-1 {{ request()->is('admin/roster*') ? 'show' : '' }}" id="rosterSubmenu" style="background-color: rgba(0,0,0,0.1); border-radius: 8px;">
                        <li>
                            <a href="{{ route('admin.roster.index', ['gender' => 'putra']) }}" 
                            class="nav-link py-2 ps-4 {{ request()->is('admin/roster*') && request()->query('gender', 'putra') == 'putra' ? 'text-warning fw-bold' : 'text-white' }}">
                                <i class="fa-solid fa-mars me-2"></i> Tim Putra
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roster.index', ['gender' => 'putri']) }}" 
                            class="nav-link py-2 ps-4 {{ request()->is('admin/roster*') && request()->query('gender') == 'putri' ? 'text-warning fw-bold' : 'text-white' }}">
                                <i class="fa-solid fa-venus me-2"></i> Tim Putri
                            </a>
                        </li>
                    </ul>
                </li>
                
                <hr class="bg-secondary opacity-25">
                
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" 
                           onclick="event.preventDefault(); this.closest('form').submit();" 
                           style="color: #ef4444 !important; text-decoration: none; display: flex; align-items: center; padding: 8px 16px;">
                            <i class="fa-solid fa-right-from-bracket me-2"></i>
                            <span>Keluar (Logout)</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>

        <div class="boma-main-content flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3 shadow-sm">
                <div class="container-fluid p-0">
                    <span class="navbar-text p-0 fw-semibold text-dark fs-5">Workspace Pemantauan Utama</span>
                    
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-teal-dark px-3 py-2">Mode Sistem: Batasan MVP Scope</span>
                        <div class="vertical-divider"></div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="small fw-medium text-secondary">{{ Auth::user()->name }}</span>
                            <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=004d40&color=ffffff' }}" 
                                alt="Profile" 
                                class="rounded-circle border" 
                                style="width: 32px; height: 32px; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </nav>

            <div class="p-4 container-fluid">
                
                <div class="p-4 mb-4 text-white rounded-3 boma-welcome-banner shadow-sm">
                    <h2 class="fw-bold mb-1">Selamat Datang, {{ Auth::user()->name }}</h2>
                    <p class="mb-0 opacity-75 fs-6">Kelola request pendaftaran mitra BOMA, verifikasi fasilitas lapangan baru, dan audit data arus kas masuk di dalam ekosistem aplikasi hari ini.</p>
                </div>

                <div class="card mb-4 boma-card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="fw-bold mb-0 text-teal-dark"><i class="fa-solid fa-bell me-2"></i>Status Operasional</h6>
                            <span class="badge bg-light text-secondary border">Lihat Semua</span>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-2 px-0 border-0">
                                <span class="badge bg-warning-subtle text-warning me-3"><i class="fa-solid fa-circle-exclamation"></i></span>
                                <div class="flex-grow-1 small">
                                    <span class="fw-semibold text-dark">3 Mitra Menunggu Verifikasi</span>
                                    <p class="mb-0 text-muted small">Butuh review sertifikasi lapangan olahraga baru.</p>
                                </div>
                                <i class="fa-solid fa-chevron-right text-muted small"></i>
                            </a>
                            
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-2 px-0 border-0">
                                <span class="badge bg-danger-subtle text-danger me-3"><i class="fa-solid fa-gavel"></i></span>
                                <div class="flex-grow-1 small">
                                    <span class="fw-semibold text-dark">1 Sengketa Refund Pending</span>
                                    <p class="mb-0 text-muted small">Batas audit: 24 jam ke depan.</p>
                                </div>
                                <i class="fa-solid fa-chevron-right text-muted small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card boma-card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="text-muted fw-semibold small mb-1">Total Penyewaan Lapangan</div>
                                    <h2 class="fw-bold my-2">{{ number_format($totalBooking) }} <span class="fs-6 fw-normal text-muted">Order</span></h2>
                                    <div class="small {{ $persenBooking >= 0 ? 'text-success' : 'text-danger' }} fw-medium">
                                        {{ $persenBooking >= 0 ? '▲' : '▼' }} {{ number_format(abs($persenBooking), 2) }}% 
                                        <span class="text-muted fw-normal">vs bulan lalu</span>
                                    </div>
                                    <div class="small text-muted mt-2" style="font-size: 0.7rem;">* Mengacu pada data bulan sebelumnya</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card boma-card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="text-muted fw-semibold small mb-1">Total Arus Pendapatan (Escrow)</div>
                                    <h2 class="fw-bold my-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                                    <div class="small {{ $persenPendapatan >= 0 ? 'text-success' : 'text-danger' }} fw-medium">
                                        {{ $persenPendapatan >= 0 ? '▲' : '▼' }} {{ number_format(abs($persenPendapatan), 2) }}% 
                                        <span class="text-muted fw-normal">termasuk komisi</span>
                                    </div>
                                    <div class="small text-muted mt-2" style="font-size: 0.7rem;">* Mengacu pada data bulan sebelumnya</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card boma-card h-100 shadow-sm">
                                <div class="card-body">
                                    <div class="text-muted fw-semibold small mb-1">Mitra Terverifikasi Aktif</div>
                                    <h2 class="fw-bold my-2">{{ number_format($totalMitra) }} <span class="fs-6 fw-normal text-muted">Mitra</span></h2>
                                    <div class="small {{ $persenMitra >= 0 ? 'text-success' : 'text-danger' }} fw-medium">
                                        {{ $persenMitra >= 0 ? '▲' : '▼' }} {{ number_format(abs($persenMitra), 2) }}% 
                                        <span class="text-muted fw-normal">tren pertumbuhan</span>
                                    </div>
                                    <div class="small text-muted mt-2" style="font-size: 0.7rem;">* Mengacu pada data bulan sebelumnya</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-auto text-center text-muted small">
                    <p>BOMA System Operations &copy; 2026 • Mengikuti Regulasi Tata Kelola Data <strong>UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong></p>
                </footer>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>