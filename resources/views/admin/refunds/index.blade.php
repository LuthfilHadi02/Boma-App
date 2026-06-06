<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Manajemen Refund</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="d-flex">
    @include('admin.partials.sidebar')

    <div class="boma-main-content flex-grow-1 p-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-0">Manajemen Refund</h4>
            <small class="text-muted">Review dan proses semua pengajuan refund dari user</small>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        {{-- Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="boma-card p-3 border-start border-warning border-4">
                    <div class="text-muted small">Pending</div>
                    <div class="fs-4 fw-bold text-warning">{{ $stats['pending'] }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="boma-card p-3 border-start border-success border-4">
                    <div class="text-muted small">Disetujui</div>
                    <div class="fs-4 fw-bold text-success">{{ $stats['approved'] }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="boma-card p-3 border-start border-danger border-4">
                    <div class="text-muted small">Ditolak</div>
                    <div class="fs-4 fw-bold text-danger">{{ $stats['rejected'] }}</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="boma-card p-3 border-start border-info border-4">
                    <div class="text-muted small">Diproses</div>
                    <div class="fs-4 fw-bold text-info">{{ $stats['processed'] }}</div>
                </div>
            </div>
        </div>

        {{-- Filter --}}
        <div class="boma-card p-3 mb-4">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                        <option value="approved"  {{ request('status') === 'approved'  ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected"  {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                        <option value="processed" {{ request('status') === 'processed' ? 'selected' : '' }}>Diproses</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm w-100" style="background:#006557;color:white;">Filter</button>
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
                            <th>User</th>
                            <th>Fasilitas</th>
                            <th>Tanggal Booking</th>
                            <th>Jumlah Refund</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refunds as $refund)
                        <tr>
                            <td class="px-3 text-muted small">{{ $refunds->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold">{{ $refund->booking->user->name ?? '-' }}</div>
                                <small class="text-muted">{{ $refund->booking->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $refund->booking->facility->name ?? '-' }}</td>
                            <td>{{ optional($refund->booking)->booking_date }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($refund->amount, 0, ',', '.') }}</td>
                            <td><small class="text-muted">{{ Str::limit($refund->reason, 50) }}</small></td>
                            <td>
                                @switch($refund->status)
                                    @case('pending')   <span class="badge bg-warning text-dark">Pending</span> @break
                                    @case('approved')  <span class="badge bg-success">Disetujui</span> @break
                                    @case('rejected')  <span class="badge bg-danger">Ditolak</span> @break
                                    @case('processed') <span class="badge bg-info">Diproses</span> @break
                                @endswitch
                            </td>
                            <td class="text-center">
                                @if($refund->status === 'pending')
                                <div class="d-flex gap-1 justify-content-center">
                                    <form method="POST" action="{{ route('admin.refunds.approve', $refund) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-success" onclick="return confirm('Setujui refund ini?')">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <button class="btn btn-xs btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $refund->id }}">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                                @elseif($refund->status === 'approved')
                                <form method="POST" action="{{ route('admin.refunds.processed', $refund) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-xs btn-info text-white" onclick="return confirm('Tandai sudah diproses?')">
                                        <i class="fas fa-paper-plane"></i> Dana Dikirim
                                    </button>
                                </form>
                                @else
                                <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal Reject --}}
                        <div class="modal fade" id="rejectModal{{ $refund->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tolak Refund</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.refunds.reject', $refund) }}">
                                        @csrf
                                        <div class="modal-body">
                                            <label class="form-label fw-semibold">Alasan Penolakan</label>
                                            <textarea name="admin_note" class="form-control" rows="3" required placeholder="Tulis alasan penolakan refund..."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Refund</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-receipt fa-2x mb-2 d-block opacity-25"></i>
                                Belum ada pengajuan refund.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3">{{ $refunds->links() }}</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;}</style>
</body>
</html>