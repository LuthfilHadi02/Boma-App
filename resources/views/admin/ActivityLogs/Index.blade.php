<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Log Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="d-flex">
    @include('admin.partials.sidebar')

    <div class="boma-main-content flex-grow-1 p-4">
        <div class="mb-4">
            <h4 class="fw-bold mb-0">Log Aktivitas</h4>
            <small class="text-muted">Audit trail semua aksi admin dan mitra di sistem</small>
        </div>

        {{-- Filter --}}
        <div class="boma-card p-3 mb-4">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Aksi</label>
                    <select name="action" class="form-select form-select-sm">
                        <option value="">Semua Aksi</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Model</label>
                    <select name="model" class="form-select form-select-sm">
                        <option value="">Semua Model</option>
                        @foreach($models as $model)
                            <option value="{{ $model }}" {{ request('model') === $model ? 'selected' : '' }}>{{ $model }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Tanggal</label>
                    <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-sm w-100" style="background:#006557;color:white;">Filter</button>
                </div>
                <div class="col-md-1">
                    <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        <div class="boma-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-3 py-3">Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Model</th>
                            <th>ID</th>
                            <th>Deskripsi</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="px-3">
                                <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y H:i') }}</small>
                            </td>
                            <td>
                                @if($log->user)
                                    <div class="fw-semibold small">{{ $log->user->name }}</div>
                                    <small class="text-muted">{{ $log->user->role }}</small>
                                @else
                                    <span class="text-muted small">Sistem</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $badgeColor = match($log->action) {
                                        'create'  => 'bg-success',
                                        'update'  => 'bg-warning text-dark',
                                        'delete'  => 'bg-danger',
                                        'approve' => 'bg-info text-dark',
                                        'reject'  => 'bg-secondary',
                                        default   => 'bg-light text-dark border',
                                    };
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ ucfirst($log->action) }}</span>
                            </td>
                            <td><code class="small">{{ $log->model }}</code></td>
                            <td><small class="text-muted">#{{ $log->model_id }}</small></td>
                            <td><small>{{ $log->description ?? '—' }}</small></td>
                            <td><small class="text-muted font-monospace">{{ $log->ip_address }}</small></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-history fa-2x mb-2 d-block opacity-25"></i>
                                Belum ada log aktivitas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3">{{ $logs->links() }}</div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>