<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Persetujuan Mitra</title>
    
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
        <a href="#" class="nav-link text-white">
            <i class="fa-solid fa-users me-2"></i> Verifikasi Akun Pengguna
        </a>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link text-white">
            <i class="fa-solid fa-receipt me-2"></i> Transaksi & Refund
        </a>
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
                        </div>
                    </div>
                </div>
            </nav>

            <div class="p-4 container-fluid">
                
                <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Persetujuan Pendaftaran Mitra</h3>
                            <p class="text-muted small mb-0">Review dokumen sertifikasi lapangan dan verifikasi akun bank mitra baru.</p>
                        </div>
                        <span class="badge bg-warning text-dark px-3 py-2">
                            {{ $mitras->count() }} Request Tertunda
                        </span>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm small mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive border rounded-3">
                        <table class="table table-hover align-middle mb-0 text-sm">
                            <thead class="table-light text-secondary small uppercase">
                                <tr>
                                    <th class="px-4 py-3">Detail Bisnis / Klub</th>
                                    <th class="px-4 py-3">Informasi Rekening Bank</th>
                                    <th class="px-4 py-3">Dokumen KYC</th>
                                    <th class="px-4 py-3 text-center">Aksi Keputusan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mitras as $mitra)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark">{{ $mitra->brand_name }}</div>
                                            <div class="text-muted small" style="font-size: 0.8rem;">{{ $mitra->address }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="fw-semibold text-dark">{{ $mitra->bank_name }}</div>
                                            <div class="text-muted small" style="font-size: 0.8rem;">No. Rek: {{ $mitra->bank_account_number }}</div>
                                            <div class="text-muted italic small" style="font-size: 0.75rem;">a.n. {{ $mitra->bank_account_name }}</div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ asset('storage/' . $mitra->identity_document) }}" target="_blank" class="btn btn-sm btn-outline-info px-2 py-1" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-file-invoice me-1"></i> Periksa Berkas
                                            </a>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form action="{{ route('admin.mitra.updateStatus', $mitra->id) }}" method="POST" onsubmit="return confirm('Setujui kemitraan ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Approved">
                                                    <button type="submit" class="btn btn-sm btn-success px-3">Setujui</button>
                                                </form>

                                                <form action="{{ route('admin.mitra.updateStatus', $mitra->id) }}" method="POST" onsubmit="return confirm('Tolak pendaftaran mitra ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Suspended">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3">Tolak</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <div class="fs-2 mb-2">🎉</div>
                                            <div class="fw-bold">Semua Bersih!</div>
                                            <div class="small text-muted">Tidak ada pengajuan pendaftaran mitra baru saat ini.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <footer class="mt-auto text-center text-muted small py-3 border-top bg-white">
                <p class="mb-0">BOMA System Operations &copy; 2026 • Mengikuti Regulasi Tata Kelola Data <strong>UU No. 27 Tahun 2022 (UU PDP)</strong></p>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>