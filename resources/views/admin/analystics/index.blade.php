<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOMA Admin - Laporan & Analitik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="d-flex">
    @include('admin.partials.sidebar')

    <div class="boma-main-content flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Laporan & Analitik</h4>
                <small class="text-muted">Tren booking, pendapatan, dan performa fasilitas</small>
            </div>
            <a href="{{ route('admin.analytics.export-pdf') }}?month={{ $month }}&year={{ $year }}"
               class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf me-1"></i> Export PDF Bulan Ini
            </a>
        </div>

        {{-- Stats Bulan Ini --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="boma-card p-4 border-start border-4" style="border-color:#006557 !important;">
                    <div class="text-muted small mb-1">Pendapatan Bulan Ini</div>
                    <div class="fs-4 fw-bold" style="color:#006557;">Rp {{ number_format($thisMonth['pendapatan'], 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="boma-card p-4 border-start border-primary border-4">
                    <div class="text-muted small mb-1">Total Booking</div>
                    <div class="fs-4 fw-bold text-primary">{{ $thisMonth['booking'] }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="boma-card p-4 border-start border-info border-4">
                    <div class="text-muted small mb-1">User Baru</div>
                    <div class="fs-4 fw-bold text-info">{{ $thisMonth['user_baru'] }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            {{-- Grafik Pendapatan 12 Bulan --}}
            <div class="col-md-8">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3">Pendapatan 12 Bulan Terakhir</h6>
                    <canvas id="chartPendapatan" height="100"></canvas>
                </div>
            </div>

            {{-- Booking Per Olahraga --}}
            <div class="col-md-4">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3">Booking per Olahraga</h6>
                    <canvas id="chartOlahraga" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- Lapangan Tersibuk --}}
            <div class="col-md-6">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-trophy text-warning me-2"></i>Lapangan Tersibuk</h6>
                    <div class="list-group list-group-flush">
                        @foreach($lapanganTersibuk as $i => $facility)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill" style="background:#006557;min-width:24px;">{{ $i+1 }}</span>
                                <div>
                                    <div class="fw-semibold small">{{ $facility->name }}</div>
                                    <small class="text-muted">{{ ucfirst($facility->type) }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $facility->bookings_count }} booking</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Grafik User Baru --}}
            <div class="col-md-6">
                <div class="boma-card p-4">
                    <h6 class="fw-bold mb-3">User Baru (6 Bulan)</h6>
                    <canvas id="chartUser" height="160"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const pendapatanData = @json($pendapatanBulanan);
const olahragaData   = @json($bookingPerOlahraga);
const userData       = @json($userBulanan);

// Chart Pendapatan
new Chart(document.getElementById('chartPendapatan'), {
    type: 'bar',
    data: {
        labels: pendapatanData.map(d => d.label),
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: pendapatanData.map(d => d.amount),
            backgroundColor: 'rgba(0,101,87,0.7)',
            borderColor: '#006557',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

// Chart Olahraga (Doughnut)
new Chart(document.getElementById('chartOlahraga'), {
    type: 'doughnut',
    data: {
        labels: Object.keys(olahragaData),
        datasets: [{ data: Object.values(olahragaData), backgroundColor: ['#006557','#3b82f6','#f59e0b','#ef4444'], borderWidth: 0 }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

// Chart User Baru
new Chart(document.getElementById('chartUser'), {
    type: 'line',
    data: {
        labels: userData.map(d => d.label),
        datasets: [{
            label: 'User Baru',
            data: userData.map(d => d.count),
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            tension: 0.3, fill: true,
        }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
</body>
</html>