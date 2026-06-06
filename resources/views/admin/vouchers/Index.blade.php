<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Voucher & Diskon</title>
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
                <h4 class="fw-bold mb-0">Voucher & Diskon</h4>
                <small class="text-muted">Kelola kode promo dan diskon booking</small>
            </div>
            <button class="btn btn-sm text-white" style="background:#006557;" data-bs-toggle="modal" data-bs-target="#createVoucherModal">
                <i class="fas fa-plus me-1"></i> Buat Voucher Baru
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="boma-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc;">
                        <tr>
                            <th class="px-3 py-3">Kode</th>
                            <th>Tipe Diskon</th>
                            <th>Nilai</th>
                            <th>Min. Order</th>
                            <th>Penggunaan</th>
                            <th>Kadaluarsa</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($vouchers as $voucher)
                        <tr>
                            <td class="px-3">
                                <code class="bg-light px-2 py-1 rounded fw-bold">{{ $voucher->code }}</code>
                            </td>
                            <td>
                                @if($voucher->discount_type === 'percentage')
                                    <span class="badge bg-info text-dark">Persentase</span>
                                @else
                                    <span class="badge bg-primary">Fixed</span>
                                @endif
                            </td>
                            <td class="fw-bold">
                                @if($voucher->discount_type === 'percentage')
                                    {{ $voucher->discount_value }}%
                                @else
                                    Rp {{ number_format($voucher->discount_value, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>Rp {{ number_format($voucher->min_booking_amount, 0, ',', '.') }}</td>
                            <td>
                                {{ $voucher->used_count }}
                                @if($voucher->max_uses)
                                    / {{ $voucher->max_uses }}
                                @else
                                    / ∞
                                @endif
                            </td>
                            <td>
                                @if($voucher->expires_at)
                                    <small class="{{ $voucher->expires_at->isPast() ? 'text-danger' : 'text-muted' }}">
                                        {{ $voucher->expires_at->format('d M Y') }}
                                    </small>
                                @else
                                    <small class="text-muted">Tidak ada</small>
                                @endif
                            </td>
                            <td>
                                @if($voucher->isValid())
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <form method="POST" action="{{ route('admin.vouchers.toggle', $voucher) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-xs {{ $voucher->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                            <i class="fas fa-{{ $voucher->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" onsubmit="return confirm('Hapus voucher ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="fas fa-ticket-alt fa-2x mb-2 d-block opacity-25"></i>
                                Belum ada voucher.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3">{{ $vouchers->links() }}</div>
        </div>
    </div>
</div>

{{-- Modal Buat Voucher --}}
<div class="modal fade" id="createVoucherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Voucher Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.vouchers.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kode Voucher <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control text-uppercase" placeholder="BOMA20" required style="text-transform:uppercase;">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Tipe Diskon</label>
                            <select name="discount_type" class="form-select" id="discountType">
                                <option value="percentage">Persentase (%)</option>
                                <option value="fixed">Fixed (Rp)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Nilai Diskon</label>
                            <input type="number" name="discount_value" class="form-control" placeholder="20" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Minimum Order (Rp)</label>
                            <input type="number" name="min_booking_amount" class="form-control" placeholder="0" min="0">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Maks. Penggunaan</label>
                            <input type="number" name="max_uses" class="form-control" placeholder="Tidak terbatas" min="1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kadaluarsa</label>
                        <input type="date" name="expires_at" class="form-control" min="{{ now()->addDay()->format('Y-m-d') }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background:#006557;">Buat Voucher</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>.btn-xs{padding:.2rem .5rem;font-size:.75rem;}</style>
</body>
</html>