<h1 class="dashboard-title">Dashboard</h1>
<p class="dashboard-subtitle">Selamat datang kembali, Ahmad. Berikut ringkasan aktivitas gudang hari ini.</p>

<!-- Statistik Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-4 fade-in">
        <div class="card dashboard-card-highlight">
            <div class="card-body text-center">
                <div class="stats-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h6>Total Barang</h6>
                <h3>1,250</h3>
                <p class="text-muted small mt-2">+5.2% dari bulan lalu</p>
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
                <h3>320</h3>
                <p class="text-muted small mt-2">+12 item hari ini</p>
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
                <h3>275</h3>
                <p class="text-muted small mt-2">+8 item hari ini</p>
            </div>
        </div>
    </div>
</div>

<!-- Informasi Tambahan -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card dashboard-card-highlight success h-100">
            <div class="card-body text-center">
                <div class="stats-icon text-success">
                    <i class="fas fa-clipboard-check"></i>
                </div>

                <h6>Menunggu Validasi</h6>
                <h3>2</h3>

                <p class="text-muted small mt-2">
                    Order baru sedang diproses admin
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card dashboard-card-highlight warning h-100">
            <div class="card-body text-center">
                <div class="stats-icon text-warning">
                    <i class="fas fa-sync-alt"></i>
                </div>

                <h6>Renew Sedang Diajukan</h6>
                <h3>1</h3>

                <p class="text-muted small mt-2">
                    Menunggu persetujuan perpanjangan
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Order Status</h5>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Aktif</span>
                        <span>42</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Due</span>
                        <span>18</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 25%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Expired</span>
                        <span>120</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>