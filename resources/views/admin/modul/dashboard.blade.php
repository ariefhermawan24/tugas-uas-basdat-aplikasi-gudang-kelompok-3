@php
    $totalOrders = max($totalOrders ?? 0, 1);

    $duePercent     = round(($dueCount / $totalOrders) * 100, 2);
    $expiredPercent = round(($expiredCount / $totalOrders) * 100, 2);
    $activePercent = round(($activeCount / $totalOrders) * 100, 2);
@endphp

<h1 class="dashboard-title">Dashboard</h1>
<p class="dashboard-subtitle">Selamat datang kembali, {{ Auth::user()->name }}. Berikut ringkasan aktivitas gudang hari ini.</p>

<!-- Statistik Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-4 fade-in">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h6>Total Barang</h6>
                <h3>{{ number_format($totalItems) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4 fade-in" style="animation-delay: 0.1s">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <h6>Barang Masuk</h6>
                <h3>{{ number_format($incomingToday) }}</h3>
                <p class="text-muted small mt-2">hari ini</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 fade-in" style="animation-delay: 0.2s">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <h6>Barang Keluar</h6>
                <h3>{{ number_format($outgoingToday) }}</h3>
                <p class="text-muted small mt-2">hari ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Request Summary -->
<div class="row g-4 mb-5">

    <!-- Validate Order Request -->
    <div class="col-lg-4">
        <div class="card dashboard-card-highlight success">
            <div class="card-body text-center">
                <div class="stats-icon text-success">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h6>Validate Order Requests</h6>
                <h3>{{ $validateRequests }}</h3>
                <p class="text-muted small mt-2">
                    Menunggu validasi admin
                </p>
            </div>
        </div>
    </div>

    <!-- Renew Order Request -->
    <div class="col-lg-4">
        <div class="card dashboard-card-highlight warning">
            <div class="card-body text-center">
                <div class="stats-icon text-warning">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h6>Renew Order Requests</h6>
                <h3>{{ $renewRequests }}</h3>
                <p class="text-muted small mt-2">
                    Permintaan perpanjangan aktif
                </p>
            </div>
        </div>
    </div>
    <!-- Order Status -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Order Status</h5>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Active</span>
                        <span>{{ $activeCount }}</span>
                    </div>
                    <div class="progress" style="height:8px; --w: {{ $activePercent }}%">
                        <div class="progress-bar bg-primary" style="width: var(--w)"></div>
                    </div>
                </div>

                {{-- DUE --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Due</span>
                        <span>{{ $dueCount }}</span>
                    </div>
                    <div class="progress" style="height:8px; --w: {{ $duePercent }}%">
                        <div class="progress-bar bg-warning" style="width: var(--w)"></div>
                    </div>
                </div>

                {{-- EXPIRED --}}
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Expired</span>
                        <span>{{ $expiredCount }}</span>
                    </div>
                    <div class="progress" style="height:8px; --w: {{ $expiredPercent }}%">
                        <div class="progress-bar bg-danger" style="width: var(--w)"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
