<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Kelola Roster</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* Spacing agar tidak dempet */
        .content-wrapper { display: flex; flex-direction: column; gap: 1.5rem; }
    </style>
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
                            <a href="{{ route('admin.roster.index', ['gender' => 'putra']) }}" class="nav-link py-2 ps-4 {{ request()->is('admin/roster*') && request()->query('gender', 'putra') == 'putra' ? 'text-warning fw-bold' : 'text-white' }}">
                                <i class="fa-solid fa-mars me-2"></i> Tim Putra
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roster.index', ['gender' => 'putri']) }}" class="nav-link py-2 ps-4 {{ request()->is('admin/roster*') && request()->query('gender') == 'putri' ? 'text-warning fw-bold' : 'text-white' }}">
                                <i class="fa-solid fa-venus me-2"></i> Tim Putri
                            </a>
                        </li>
                    </ul>
                </li>
                <hr class="bg-secondary opacity-25">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444 !important; text-decoration: none; display: flex; align-items: center; padding: 8px 16px;">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> <span>Keluar (Logout)</span>
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
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 pb-4 mt-4 d-flex flex-column gap-4">
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm">{{ $errors->first() }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold m-0" style="color: #000000;"><i class="fa-solid fa-users-gear me-2"></i>Kelola Roster Tim</h3>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-secondary">Tambah Pemain Baru</h6>
                    <form action="{{ route('admin.roster.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="gender" value="{{ request()->get('gender', 'putra') }}">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-3"><input type="text" name="name" class="form-control bg-light border-0" placeholder="Nama Lengkap" required></div>
                            <div class="col-md-2"><input type="text" name="position" class="form-control bg-light border-0" placeholder="Posisi" required></div>
                            <div class="col-md-1"><input type="number" name="number" class="form-control bg-light border-0" placeholder="No" required></div>
                            <div class="col-md-2">
                                <select name="team_category" class="form-select bg-light border-0">
                                    <option value="basket">Basket</option>
                                    <option value="futsal">Futsal</option>
                                    <option value="bulutangkis">Bulu Tangkis</option>
                                </select>
                            </div>
                            <div class="col"><input type="file" name="photo" class="form-control bg-light border-0" required></div>
                            <div class="col-auto"><button type="submit" class="btn text-white fw-bold px-4" style="background-color: #004d40;">Simpan</button></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-muted">FOTO</th>
                                    <th class="border-0 text-muted">NAMA PEMAIN</th>
                                    <th class="border-0 text-muted">POSISI</th>
                                    <th class="border-0 text-muted text-center">NO PUNGGUNG</th>
                                    <th class="border-0 text-muted text-center">DIVISI</th>
                                    <th class="text-center border-0 text-muted">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($players as $player)
                                <tr>
                                    <td class="ps-4 py-3"><img src="{{ asset('storage/' . $player->photo) }}" class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover;"></td>
                                    <td class="fw-bold text-dark">{{ $player->name }}</td>
                                    <td class="text-secondary">{{ $player->position }}</td>
                                    <td class="text-center"><span class="badge bg-secondary">{{ $player->number }}</span></td>
                                    <td class="text-center"><span class="badge rounded-pill text-capitalize" style="background-color: #e0f2f1; color: #004d40;">{{ $player->team_category }}</span></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#editPlayerModal{{ $player->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <form action="{{ route('admin.roster.destroy', $player->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>