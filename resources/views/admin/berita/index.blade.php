<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Berita</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="d-flex">
        
        <!-- Sidebar -->
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
</ul>        </div>

        <!-- Main Content -->

<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Manajemen Berita Kegiatan</h3>
            <p class="text-muted small">Kelola publikasi berita dan prestasi olahraga mahasiswa BOMA.</p>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 text-dark">Tambah Berita Baru</h5>
                    
                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-uppercase">Judul Berita</label>
                            <input type="text" name="judul" required placeholder="Contoh: Juara 2 Basket" class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-uppercase">Tanggal Kegiatan</label>
                            <input type="date" name="tanggal_kegiatan" required class="form-control rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-uppercase">Deskripsi Singkat</label>
                            <textarea name="deskripsi_singkat" rows="3" required placeholder="Ringkasan untuk kartu home..." class="form-control rounded-3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-uppercase">Konten Lengkap</label>
                            <textarea name="konten_lengkap" rows="5" required placeholder="Isi berita selengkapnya..." class="form-control rounded-3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Link Tujuan</label>
                            <input
                                type="url"
                                name="link"
                                class="form-control"
                                placeholder="https://instagram.com/..."
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-uppercase">Foto Utama</label>
                            <input type="file" name="foto" required class="form-control rounded-3">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold" style="background-color: #0d9488; border: none;">
                            <i class="fa-solid fa-paper-plane me-2"></i> Terbitkan Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="fw-bold mb-0">Daftar Berita Aktif</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-uppercase small text-muted">
                            <tr>
                                <th class="px-4">Foto</th>
                                <th class="px-3">Info Berita</th>
                                <th class="px-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($beritas as $berita)
                            <tr>
                                <td class="px-4">
                                    <img src="{{ asset($berita->foto) }}" alt="Foto" class="rounded-3 shadow-sm" style="width: 80px; height: 50px; object-fit: cover;">
                                </td>
                                <td class="px-3">
                                    <div class="fw-bold text-dark">{{ $berita->judul }}</div>
                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($berita->tanggal_kegiatan)->format('d M Y') }}</div>
                                </td>
                                <td class="px-3 text-center">
                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Yakin hapus, bre?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fa-regular fa-folder-open fa-2x d-block mb-2"></i> Belum ada berita.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>