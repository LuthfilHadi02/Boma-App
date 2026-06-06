<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Roster - BOMA Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="flex-grow-1 overflow-auto" style="height: 100vh;">
        
        <div class="topbar p-3 d-flex justify-content-between align-items-center mb-4 sticky-top">
            <h5 class="m-0 text-secondary fs-6 fw-bold">Workspace Pemantauan Utama</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 fw-bold text-dark">{{ auth()->user()->name }}</span>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=004d40&color=fff" class="rounded-circle shadow-sm" width="40" alt="Profile">
            </div>
        </div>

        <div class="container-fluid px-4 pb-4">
            
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0" style="color: #000000;"><i class="fa-solid fa-users-gear me-2"></i>Kelola Roster Tim</h3>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3 text-secondary">Tambah Pemain Baru</h6>
                    <form action="{{ route('admin.roster.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="gender" value="{{ request()->get('gender', 'putra') }}">

                        <div class="row align-items-center g-2">
                            </div>
                        <div class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <input type="text" name="name" class="form-control bg-light border-0" placeholder="Nama Lengkap" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="position" class="form-control bg-light border-0" placeholder="Posisi" required>
                            </div>
                            <div class="col-md-1">
                                <input type="number" name="number" class="form-control bg-light border-0" placeholder="No" required>
                            </div>
                            <div class="col-md-2">
                                <select name="team_category" class="form-select bg-light border-0">
                                    <option value="basket">Basket</option>
                                    <option value="futsal">Futsal</option>
                                    <option value="bulutangkis">Bulu Tangkis</option>
                                </select>
                            </div>
                            <div class="col">
                                <input type="file" name="photo" class="form-control bg-light border-0 w-100 text-secondary" style="font-size: 0.9rem;" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #004d40;">Simpan</button>
                            </div>
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
                                    <th class="ps-4 border-0 text-muted" style="font-size: 0.85rem;">FOTO</th>
                                    <th class="border-0 text-muted" style="font-size: 0.85rem;">NAMA PEMAIN</th>
                                    <th class="border-0 text-muted" style="font-size: 0.85rem;">POSISI</th>
                                    <th class="border-0 text-muted text-center" style="font-size: 0.85rem;">NO PUNGGUNG</th>
                                    <th class="border-0 text-muted text-center" style="font-size: 0.85rem;">DIVISI</th>
                                    <th class="text-center border-0 text-muted" style="font-size: 0.85rem;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($players as $player)
<tr>
    <td class="align-middle ps-4" style="width: 70px;">
        @if($player->photo)
            <img src="{{ asset('storage/' . $player->photo) }}" class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover; border: 2px solid white;">
        @else
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center border text-secondary" style="width: 45px; height: 45px;">
                <i class="fa-solid fa-user"></i>
            </div>
        @endif
    </td>

    <td class="fw-bold text-dark align-middle">{{ $player->name }}</td>

    <td class="text-secondary align-middle">{{ $player->position }}</td>

    <td class="text-center align-middle" style="width: 100px;">
        <span class="badge bg-secondary px-2 py-1">{{ $player->number }}</span>
    </td>

    <td class="text-center align-middle" style="width: 130px;">
        <span class="badge rounded-pill text-capitalize" style="background-color: #e0f2f1; color: #004d40; padding: 6px 12px;">
            {{ $player->team_category }}
        </span>
    </td>

    <td class="text-center align-middle" style="width: 100px; white-space: nowrap;">
        <div class="d-flex justify-content-center gap-1">
            <button type="button" class="btn btn-sm btn-outline-warning border-0 text-warning" data-bs-toggle="modal" data-bs-target="#editPlayerModal{{ $player->id }}">
                <i class="fa-solid fa-pen-to-square" style="font-size: 1.1rem;"></i>
            </button>

            <form action="{{ route('admin.roster.destroy', $player->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pemain ini?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger border-0 text-danger">
                    <i class="fa-solid fa-trash" style="font-size: 1.1rem;"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
<div class="modal fade" id="editPlayerModal{{ $player->id }}" tabindex="-1" aria-hidden="true" style="color: #333;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-pen me-2"></i>Edit Data Pemain</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.roster.update', $player->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $player->name }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label class="form-label fw-bold">Posisi</label>
                            <input type="text" name="position" class="form-control" value="{{ $player->position }}" required>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label fw-bold">No Punggung</label>
                            <input type="number" name="number" class="form-control" value="{{ $player->number }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Cabang Olahraga</label>
                        <select name="team_category" class="form-select" required>
                            <option value="basket" {{ $player->team_category == 'basket' ? 'selected' : '' }}>Basket</option>
                            <option value="futsal" {{ $player->team_category == 'futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="bulutangkis" {{ $player->team_category == 'bulutangkis' ? 'selected' : '' }}>Bulu Tangkis</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Pemain</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img src="{{ asset('storage/'.$player->photo) }}" class="rounded border" width="50" height="50" style="object-fit: cover;">
                            <small class="text-muted">Foto saat ini</small>
                        </div>
                        <input type="file" name="photo" class="form-control">
                        <div class="form-text text-muted">*Biarkan kosong jika tidak ingin mengganti foto.</div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning text-white fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div> </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>