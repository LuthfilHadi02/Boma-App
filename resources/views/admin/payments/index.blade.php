<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin Panel - Transaksi & Refund</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <div class="d-flex">
        
        <div class="boma-sidebar p-3 text-white" style="min-height: 100vh; min-width: 260px;">
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
                    <a href="{{ route('admin.payments.index') }}" class="nav-link text-white {{ Request::is('admin/payments*') ? 'active' : '' }}">
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

        <div class="flex-grow-1 p-4" style="background-color: #f8f9fa; min-height: 100vh;">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-3 pb-0 border-0">
                    <h5 class="fw-bold text-dark mb-1"><i class="fa-solid fa-money-bill-transfer me-2 text-primary"></i>Manajemen Transaksi & Refund</h5>
                    <p class="text-muted small mb-3">Pantau arus kas masuk dari booking lapangan serta kelola permohonan refund pengguna.</p>
                    
                    <ul class="nav nav-tabs border-bottom-0" id="transactionTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold text-secondary" id="pembayaran-tab" data-bs-toggle="tab" data-bs-target="#pembayaran-pane" type="button" role="tab" aria-controls="pembayaran-pane" aria-selected="true">
                                <i class="fa-solid fa-wallet me-1 text-success"></i> Riwayat Pembayaran
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold text-secondary" id="refund-tab" data-bs-toggle="tab" data-bs-target="#refund-pane" type="button" role="tab" aria-controls="refund-pane" aria-selected="false">
                                <i class="fa-solid fa-hand-holding-dollar me-1 text-danger"></i> Pengajuan Refund 
                                @if($refunds->where('status', 'pending')->count() > 0)
                                    <span class="badge bg-danger ms-1">{{ $refunds->where('status', 'pending')->count() }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="transactionTabContent">
                        
                        <div class="tab-pane fade show active" id="pembayaran-pane" role="tabpanel" aria-labelledby="pembayaran-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary">
                                        <tr>
                                            <th class="ps-4">ID PAYMENT</th>
                                            <th>NAMA USER</th>
                                            <th>TOTAL BAYAR</th>
                                            <th>STATUS</th>
                                            <th>TANGGAL TRANSAKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $payment)
                                        <tr>
                                            <td class="ps-4 fw-bold text-secondary">#PAY-{{ $payment->id }}</td>
                                            <td><span class="fw-bold text-dark">{{ $payment->booking->user->name ?? 'User N/A' }}</span></td>
                                            <td class="fw-bold text-dark">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                            <td>
                                                @if($payment->status == 'paid' || $payment->status == 'success')
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 text-capitalize">Paid</span>
                                                @elseif($payment->status == 'refunded')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 text-capitalize">Refunded</span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 text-capitalize">{{ $payment->status }}</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $payment->created_at->format('d M Y, H:i') }} WIB</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-receipt mb-2" style="font-size: 2rem;"></i>
                                                <p class="mb-0">Belum ada riwayat pembayaran masuk, bro.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="refund-pane" role="tabpanel" aria-labelledby="refund-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light text-secondary">
                                        <tr>
                                            <th class="ps-4">ID TRANSAKSI</th>
                                            <th>NAMA USER</th>
                                            <th>NOMINAL REFUND</th>
                                            <th>ALASAN</th>
                                            <th>STATUS</th>
                                            <th class="text-center" style="width: 220px;">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($refunds as $refund)
                                        <tr>
                                            <td class="ps-4 fw-bold text-secondary">#PAY-{{ $refund->payment_id }}</td>
                                            <td class="fw-bold text-dark">{{ $refund->payment->booking->user->name ?? 'N/A' }}</td>
                                            <td class="fw-bold text-danger">Rp {{ number_format($refund->amount, 0, ',', '.') }}</td>
                                            <td><span class="text-muted d-inline-block text-truncate" style="max-width: 200px;">{{ $refund->reason }}</span></td>
                                            <td>
                                                @if($refund->status == 'pending')
                                                    <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1 text-capitalize">Pending</span>
                                                @elseif($refund->status == 'approved')
                                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 text-capitalize">Approved</span>
                                                @else
                                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 text-capitalize">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($refund->status == 'pending')
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="{{ route('admin.refunds.approve', $refund->id) }}" method="POST" onsubmit="return confirm('Setujui refund ini?');">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success fw-bold px-3">Terima</button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-outline-danger fw-bold px-3" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $refund->id }}">Tolak</button>
                                                </div>

                                                <div class="modal fade" id="rejectModal{{ $refund->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold text-dark">Alasan Penolakan Refund</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.refunds.reject', $refund->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body text-start">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold text-secondary">Tulis alasan penolakan:</label>
                                                                        <textarea name="admin_note" class="form-control" rows="3" placeholder="Contoh: Pembatalan lewat batas waktu maksimal H-1." required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-danger fw-bold">Kirim Penolakan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                    <span class="text-muted small">Selesai di-review</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">
                                                <i class="fa-solid fa-face-smile mb-2" style="font-size: 2rem;"></i>
                                                <p class="mb-0">Bersih! Tidak ada permintaan pengajuan refund saat ini.</p>
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
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>