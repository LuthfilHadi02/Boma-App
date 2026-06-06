<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="d-flex">
    @include('admin.partials.sidebar')

    <div class="boma-main-content flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
                <small class="text-muted">Kelola semua akun user, mitra, dan admin</small>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        {{-- Filter --}}
        <div class="boma-card p-3 mb-4">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold">Cari Nama / Email</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
                        <option value="user"  {{ request('role') == 'user'  ? 'selected' : '' }}>User</option>
                        <option value="mitra" {{ request('role') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm w-100" style="background:#006557;color:white;">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="boma-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-3 py-3">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Prodi</th>
                            <th>Terdaftar</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="px-3 text-muted small">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->phone ?? '-' }}</small>
                            </td>
                            <td><small>{{ $user->email }}</small></td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'mitra')
                                    <span class="badge bg-warning text-dark">Mitra</span>
                                @else
                                    <span class="badge bg-info text-dark">User</span>
                                @endif
                            </td>
                            <td><small>{{ $user->prodi ?? '-' }}</small></td>
                            <td><small>{{ $user->created_at->format('d M Y') }}</small></td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Terverifikasi</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border">Belum Verif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button class="btn btn-xs btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" onsubmit="return confirm('Reset password user ini?')">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-xs btn-outline-warning" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    @if($user->id !== auth()->id() && $user->role !== 'admin')
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                        @csrf @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama</label>
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="user"  {{ $user->role === 'user'  ? 'selected' : '' }}>User</option>
                                                    <option value="mitra" {{ $user->role === 'mitra' ? 'selected' : '' }}>Mitra</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Prodi</label>
                                                <input type="text" name="prodi" class="form-control" value="{{ $user->prodi }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">No. HP</label>
                                                <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-users fa-2x mb-2 d-block opacity-25"></i>
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;}</style>
</body>
</html>