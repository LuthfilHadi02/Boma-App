<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Kelola Fasilitas Lapangan</title>
    
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

        <div class="boma-main-content flex-grow-1 d-flex flex-column min-h-screen">
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

            <div class="p-4 container-fluid flex-grow-1">
                
                <div class="card border-0 shadow-sm p-4 bg-white rounded-3">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">Kelola Fasilitas Lapangan</h3>
                            <p class="text-muted small mb-0">Manajemen inventaris, tipe lantai, dan peninjauan operasional harga arena olahraga mitra BOMA.</p>
                        </div>
                        <button type="button" class="btn btn-success px-4 py-2 fw-semibold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahLapangan">
                            <i class="fa-solid fa-circle-plus me-1"></i> Tambah Lapangan
                        </button>
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
                                    <th class="px-4 py-3" style="width: 120px;">Foto</th>
                                    <th class="px-4 py-3">Nama Lapangan / Pemilik</th>
                                    <th class="px-4 py-3">Jenis & Tipe Lantai</th>
                                    <th class="px-4 py-3">Harga / Jam</th>
                                    <th class="px-4 py-3 text-center">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($facilities as $facility)
                                    <tr>
                                        <td class="px-4 py-3">
                                            @if($facility->image)
                                                <img src="{{ asset('storage/' . $facility->image) }}" alt="Foto Lapangan" class="img-thumbnail rounded-3 shadow-sm" style="width: 90px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light border text-muted rounded-3 d-flex align-items-center justify-content-center text-uppercase fw-bold shadow-sm" style="width: 90px; height: 60px; font-size: 10px; border-style: dashed !important;">
                                                    No Image
                                                </div>
                                            @endif
                                        </td>
                                       <td class="px-4 py-3">
                                            <div class="fw-bold text-dark fs-6">{{ $facility->name }}</div>
                                            <div class="text-muted small" style="font-size: 0.8rem;">
                                                <i class="fa-solid fa-user-tie me-1 text-secondary"></i> 
                                                {{ $facility->mitra->brand_name ?? 'Mitra Tidak Ditemukan' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-bold" style="font-size: 0.75rem;">{{ $facility->type }}</span>
                                            <div class="text-muted small mt-1" style="font-size: 0.8rem;">Lantai: <span class="fw-semibold text-dark">{{ $facility->floor_type }}</span></div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark fs-6">Rp {{ number_format($facility->price_per_hour, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            @if($facility->is_active)
                                                <span class="badge bg-success-subtle text-success px-3 py-2 border border-success-subtle rounded-pill">Aktif</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning px-3 py-2 border border-warning-subtle rounded-pill">Maintenance</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary px-2.5 py-1" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.facilities.destroy', $facility->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?')">
                                                    @csrf
                                                    @method('DELETE') <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-3">
                                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <div class="fs-2 mb-2">🎉</div>
                                            <div class="fw-bold">Semua Bersih!</div>
                                            <div class="small text-muted">Tidak ada fasilitas lapangan yang terdaftar saat ini.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <footer class="text-center text-muted small py-3 border-top bg-white mt-auto">
                <p class="mb-0">BOMA System Operations &copy; 2026 • Mengikuti Regulasi Tata Kelola Data <strong>UU No. 27 Tahun 2022 (UU PDP)</strong></p>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="modalTambahLapangan" tabindex="-1" aria-labelledby="modalTambahLapanganLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-light border-bottom px-4 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="modalTambahLapanganLabel">Tambah Lapangan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Mitra Pemilik</label>
                            <select name="mitra_id" class="form-select border rounded-3 p-2.5 text-sm" required>
                                <option value="">-- Pilih Mitra Terverifikasi --</option>
                                @foreach($mitras as $mitra)
                                    <option value="{{ $mitra->id }}">{{ $mitra->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Nama Lapangan</label>
                            <input type="text" name="name" class="form-select text-start border rounded-3 p-2.5 text-sm" placeholder="Contoh: Lapangan Futsal Vinyl A" style="background-image: none;" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Jenis Olahraga</label>
                                <select name="type" class="form-select border rounded-3 p-2.5 text-sm" required>
                                    <option value="Futsal">Futsal</option>
                                    <option value="Basket">Basket</option>
                                    <option value="Badminton">Badminton</option>
                                    <option value="Tenis">Tenis</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Tipe Lantai</label>
                                <input type="text" name="floor_type" class="form-control border rounded-3 p-2.5 text-sm" placeholder="Contoh: Interlock / Vinyl" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Harga Sewa Per Jam</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border text-secondary text-sm">Rp</span>
                                <input type="number" name="price_per_hour" class="form-control border p-2.5 text-sm" placeholder="150000" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Foto Fasilitas</label>
                            <input type="file" name="image" class="form-control border text-sm">
                        </div>
                        <div class="mb-1">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Deskripsi Tambahan</label>
                            <textarea name="description" rows="3" class="form-control border rounded-3 text-sm" placeholder="Keterangan opsional fasilitas..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top bg-light px-4 py-3 rounded-bottom-4">
                        <button type="button" class="btn btn-secondary px-3 py-2 text-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 py-2 text-sm rounded-3 fw-semibold">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>