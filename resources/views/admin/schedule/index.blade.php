<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Kelola Jadwal Latihan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

<div class="d-flex">
    
    <!-- SIDEBAR SERAGAM INTEGRASI ADMIN BOMA -->
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
            <!-- MENU BERGGENGSI KARYA MURSYID DANISWARA (ACTIVE STATE AUTO) -->
            <li class="nav-item">
                <a href="{{ route('admin.schedule.index') }}" class="nav-link text-white {{ Request::is('admin/schedule*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-days me-2 text-warning"></i> <span class="text-warning fw-bold">Kelola Jadwal Latihan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white">
                    <i class="fa-solid fa-users me-2"></i> Verifikasi Akun Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.payments.index') }}" class="nav-link text-white {{ Request::is('admin/payments*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt me-2"></i> Transaksi & Refund
                </a>
            </li>
            
            <hr class="bg-secondary opacity-25">
            
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444 !important; text-decoration: none; display: flex; align-items: center; padding: 8px 16px;">
                        <i class="fa-solid fa-right-from-bracket me-2"></i><span>Keluar (Logout)</span>
                    </a>
                </form>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT CONTAINER -->
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
                        <h3 class="fw-bold text-dark mb-1">Kelola Jadwal Latihan BOMA</h3>
                        <p class="text-muted small mb-0">Manajemen kalender agenda latihan berkala, lokasi, serta kuota partisipasi mahasiswa UPI Cibiru.</p>
                    </div>
                    <button type="button" class="btn btn-success px-4 py-2 fw-semibold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
                        <i class="fa-solid fa-circle-plus me-1"></i> Tambah Jadwal Latihan
                    </button>
                </div>

                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm small mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- TABEL DATA JADWAL (READ / VIEW ACTION) -->
                <div class="table-responsive border rounded-3">
                    <table class="table table-hover align-middle mb-0 text-sm">
                        <thead class="table-light text-secondary small uppercase">
                            <tr>
                                <th class="px-4 py-3">Nama Agenda / Kegiatan</th>
                                <th class="px-4 py-3">Tanggal Pelaksanaan</th>
                                <th class="px-4 py-3">Waktu / Sesi Sparing</th>
                                <th class="px-4 py-3">Lokasi / Tempat</th>
                                <th class="px-4 py-3 text-center">Status Kuota</th>
                                <th class="px-4 py-3 text-center">Aksi Operasional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                                <tr>
                                    <td class="px-4 py-3 fw-bold text-dark fs-6">{{ $schedule->title }}</td>
                                    <td class="px-4 py-3 text-secondary">{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</td>
                                    <td class="px-4 py-3 font-monospace">{{ $schedule->time }} WIB</td>
                                    <td class="px-4 py-3 text-muted"><i class="fa-solid fa-location-dot me-1 text-teal-dark"></i>{{ $schedule->location }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="badge bg-light text-dark border px-2.5 py-1.5 fw-bold" style="font-size: 0.75rem;">
                                            {{ $schedule->current_quota }} / {{ $schedule->max_quota }} Anggota
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- TOMBOL TRIGGER EDIT MODAL -->
                                            <button type="button" class="btn btn-sm btn-outline-primary px-2.5 py-1 rounded-3" data-bs-toggle="modal" data-bs-target="#modalEditJadwal{{ $schedule->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </button>

                                            <!-- TOMBOL DELETE ACTION -->
                                            <form action="{{ route('admin.schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal latihan ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-3 px-3">
                                                    <i class="fa-solid fa-trash me-1"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- 🔁 MODAL POP UP EDIT JADWAL (DIGENERATE OTOMATIS BERDASARKAN ID LOOPING) -->
                                <div class="modal fade" id="modalEditJadwal{{ $schedule->id }}" tabindex="-1" aria-hidden="true" style="color: #333;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-warning text-white px-4 py-3">
                                                <h5 class="modal-title fw-bold"><i class="fa-solid fa-calendar-check me-2"></i>Perbarui Jadwal Latihan</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('admin.schedule.update', $schedule->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body p-4 text-start">
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Nama Agenda Kegiatan</label>
                                                        <input type="text" name="title" class="form-control border rounded-3 p-2.5 text-sm" value="{{ $schedule->title }}" required>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Tanggal Latihan</label>
                                                            <input type="date" name="date" class="form-control border rounded-3 p-2.5 text-sm" value="{{ $schedule->date }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Jam Sesi (WIB)</label>
                                                            <input type="text" name="time" class="form-control border rounded-3 p-2.5 text-sm" value="{{ $schedule->time }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Lokasi Lapangan</label>
                                                        <input type="text" name="location" class="form-control border rounded-3 p-2.5 text-sm" value="{{ $schedule->location }}" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Kuota Maksimal</label>
                                                        <input type="number" name="max_quota" min="1" class="form-control border rounded-3 p-2.5 text-sm" value="{{ $schedule->max_quota }}" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top bg-light px-4 py-3 rounded-bottom-4">
                                                    <button type="button" class="btn btn-secondary px-3 py-2 text-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning px-4 py-2 text-sm rounded-3 fw-semibold text-white">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <div class="fs-2 mb-2">📅</div>
                                        <div class="fw-bold">Semua Bersih!</div>
                                        <div class="small text-muted">Belum ada agenda latihan rutin BOMA yang diterbitkan saat ini.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="text-center text-muted small py-3 border-top bg-white mt-auto">
            <p class="mb-0">BOMA System Operations &copy; 2026 • Mengikuti Undang-Undang Perlindungan Data Pribadi</p>
        </footer>
    </div>
</div>

<!-- ➕ MODAL POP UP TAMBAH JADWAL BARU (CREATE ACTION) -->
<div class="modal fade" id="modalTambahJadwal" tabindex="-1" aria-hidden="true" style="color: #333;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-light border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-calendar-plus me-2 text-success"></i>Terbitkan Jadwal Latihan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.schedule.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Nama Agenda Kegiatan / Divisi</label>
                        <input type="text" name="title" class="form-control border rounded-3 p-2.5 text-sm" placeholder="Contoh: Latihan Rutin Divisi Futsal BOMA" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Tanggal Latihan</label>
                            <input type="date" name="date" class="form-control border rounded-3 p-2.5 text-sm" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Jam Sesi (WIB)</label>
                            <input type="text" name="time" class="form-control border rounded-3 p-2.5 text-sm" placeholder="Contoh: 16.00 - 18.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Lokasi Lapangan / GOR</label>
                        <input type="text" name="location" class="form-control border rounded-3 p-2.5 text-sm" placeholder="Contoh: Lapangan Serbaguna UPI Cibiru" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label text-secondary small uppercase fw-bold" style="font-size: 0.75rem;">Kuota Maksimal Partisipan</label>
                        <input type="number" name="max_quota" min="1" class="form-control border rounded-3 p-2.5 text-sm" placeholder="30" required>
                    </div>
                </div>
                <div class="modal-footer border-top bg-light px-4 py-3 rounded-bottom-4">
                    <button type="button" class="btn btn-secondary px-3 py-2 text-sm rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 py-2 text-sm rounded-3 fw-semibold" style="background-color: #006557; border: none;">Terbitkan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>