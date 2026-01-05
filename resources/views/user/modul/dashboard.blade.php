@php
    $totalOrders = max($totalOrders ?? 0, 1);

    $duePercent     = round(($dueCount / $totalOrders) * 100, 2);
    $expiredPercent = round(($expiredCount / $totalOrders) * 100, 2);
    $activePercent = round(($activeCount / $totalOrders) * 100, 2);
@endphp

<h1 class="dashboard-title">Dashboard</h1>
<p class="dashboard-subtitle">
    Selamat datang kembali, {{ Auth::user()->name }}.
    Berikut ringkasan aktivitas gudang hari ini.
</p>

{{-- ===================== --}}
{{-- STATISTIK UTAMA --}}
{{-- ===================== --}}
<div class="row g-4 mb-5">

    {{-- TOTAL BARANG --}}
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

    {{-- BARANG MASUK --}}
    <div class="col-md-4 fade-in" style="animation-delay: .1s">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
                <h6>Barang Masuk</h6>
                <h3>{{ number_format($incomingToday) }}</h3>
                <p class="text-muted small mt-2">Hari ini</p>
            </div>
        </div>
    </div>

    {{-- BARANG KELUAR --}}
    <div class="col-md-4 fade-in" style="animation-delay: .2s">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
                <h6>Barang Keluar</h6>
                <h3>{{ number_format($outgoingToday) }}</h3>
                <p class="text-muted small mt-2">Hari ini</p>
            </div>
        </div>
    </div>

</div>

{{-- ===================== --}}
{{-- INFORMASI TAMBAHAN --}}
{{-- ===================== --}}
<div class="row g-4 mb-5">

    {{-- VALIDASI --}}
    <div class="col-lg-4">
        <div class="card dashboard-card-highlight success h-100">
            <div class="card-body text-center">
                <div class="stats-icon text-success">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h6>Menunggu Validasi</h6>
                <h3>{{ $waitingValidation }}</h3>
                <p class="text-muted small mt-2">
                    Order sedang diproses admin
                </p>
            </div>
        </div>
    </div>

    {{-- RENEW --}}
    <div class="col-lg-4">
        <div class="card dashboard-card-highlight warning h-100">
            <div class="card-body text-center">
                <div class="stats-icon text-warning">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h6>Renew Diajukan</h6>
                <h3>{{ $renewRequests }}</h3>
                <p class="text-muted small mt-2">
                    Menunggu persetujuan perpanjangan
                </p>
            </div>
        </div>
    </div>

    {{-- STATUS ORDER --}}
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
