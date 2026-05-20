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
            
            <ul class="nav nav-pills flex-column mb-auto gap-1">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white active">
                        <i class="fa-solid fa-chart-pie me-2"></i> Dashboard Overview
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-building-user me-2"></i> Persetujuan Mitra</span>
                        <span class="badge bg-teal-accent text-white style-badge">3</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="fa-solid fa-map-location-dot me-2"></i> Kelola Fasilitas Lapangan
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">
                        <i class="fa-solid fa-users me-2"></i> Verifikasi Akun Pengguna
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white d-flex align-items-center justify-content-between">
                        <span><i class="fa-solid fa-receipt me-2"></i> Transaksi & Refund</span>
                        <span class="badge bg-danger text-white style-badge">1</span>
                    </a>
                </li>
                <hr class="bg-secondary opacity-25">
                <li>
                    <a href="#" class="nav-link text-white text-opacity-75">
                        <i class="fa-solid fa-gear me-2"></i> Pengaturan Sistem
                    </a>
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
                        <span class="small fw-medium text-secondary">Halo, Muhammad Akmal</span>
                    </div>
                </div>
            </nav>

            <div class="p-4 container-fluid">
                
                <div class="p-4 mb-4 text-white rounded-3 boma-welcome-banner shadow-sm">
                    <h2 class="fw-bold mb-1">Selamat Datang Kembali, Admin 👋</h2>
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

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card boma-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="text-muted fw-semibold small mb-1">Total Penyewaan Lapangan (MVP)</div>
                                <h2 class="fw-bold text-teal-dark my-2">5,312 <span class="fs-6 fw-normal text-muted">Sesi</span></h2>
                                <div class="small text-success fw-medium">
                                    <span>▲ 2.29%</span> <span class="text-muted fw-normal">vs bulan lalu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card boma-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="text-muted fw-semibold small mb-1">Total Arus Pendapatan Kotor (Escrow System)</div>
                                <h2 class="fw-bold text-teal-accent my-2">Rp 120.000.000</h2>
                                <div class="small text-success fw-medium">
                                    <span>▲ 2.19%</span> <span class="text-muted fw-normal">termasuk komisi platform</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card boma-card h-100 shadow-sm">
                            <div class="card-body">
                                <div class="text-muted fw-semibold small mb-1">Pengguna Terverifikasi Aktif</div>
                                <h2 class="fw-bold text-dark my-2">1,245 <span class="fs-6 fw-normal text-muted">Mahasiswa</span></h2>
                                <div class="small text-danger fw-medium">
                                    <span>▼ 3.19%</span> <span class="text-muted fw-normal">angka penurunan termin ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="mt-5 text-center text-muted small">
                    <p>BOMA System Operations &copy; 2026 • Mengikuti Regulasi Tata Kelola Data <strong>UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)</strong></p>
                </footer>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>