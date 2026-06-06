<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Notifikasi Push</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="d-flex">
    @include('admin.partials.sidebar')

    <div class="boma-main-content flex-grow-1 p-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-0">Notifikasi Broadcast</h4>
            <small class="text-muted">Kirim notifikasi massal ke pengguna</small>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row g-4">
            {{-- Form Kirim --}}
            <div class="col-md-5">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-paper-plane me-2 text-success"></i>Kirim Notifikasi</h6>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="boma-card p-3 text-center border">
                                <div class="fs-4 fw-bold text-primary">{{ $userCount }}</div>
                                <small class="text-muted">User</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="boma-card p-3 text-center border">
                                <div class="fs-4 fw-bold text-warning">{{ $mitraCount }}</div>
                                <small class="text-muted">Mitra</small>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.notifications.broadcast') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Target Penerima</label>
                            <select name="target" class="form-select">
                                <option value="all">Semua Pengguna ({{ $userCount + $mitraCount }} orang)</option>
                                <option value="user">User Saja ({{ $userCount }} orang)</option>
                                <option value="mitra">Mitra Saja ({{ $mitraCount }} orang)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul Notifikasi</label>
                            <input type="text" name="title" class="form-control" placeholder="cth: Promo Akhir Pekan 🎉" required maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Isi Pesan</label>
                            <textarea name="message" class="form-control" rows="4" required placeholder="Tulis pesan notifikasi..."></textarea>
                        </div>
                        <button type="submit" class="btn w-100 text-white" style="background:#006557;" onclick="return confirm('Kirim notifikasi ke semua target?')">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Notifikasi
                        </button>
                    </form>
                </div>
            </div>

            {{-- Riwayat Broadcast --}}
            <div class="col-md-7">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-history me-2 text-muted"></i>Riwayat Broadcast Terbaru</h6>
                    <div class="list-group list-group-flush">
                        @forelse($recentBroadcasts as $notif)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between">
                                <div class="fw-semibold small">{{ $notif->title }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</small>
                            </div>
                            <p class="mb-0 text-muted small">{{ Str::limit($notif->message, 80) }}</p>
                        </div>
                        @empty
                        <p class="text-muted text-center py-4">Belum ada broadcast dikirim.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>