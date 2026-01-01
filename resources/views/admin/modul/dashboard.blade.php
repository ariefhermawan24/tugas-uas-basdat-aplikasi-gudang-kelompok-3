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
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Aktivitas Terbaru</h5>
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-box text-primary me-2"></i>
                            <span>Barang "Komponen Elektronik" telah diterima</span>
                        </div>
                        <small class="text-muted">10 menit lalu</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-shipping-fast text-success me-2"></i>
                            <span>Order #ORD-7890 telah dikirim</span>
                        </div>
                        <small class="text-muted">1 jam lalu</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <span>Stok "Baterai AA" hampir habis</span>
                        </div>
                        <small class="text-muted">3 jam lalu</small>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div>
                            <i class="fas fa-user-check text-info me-2"></i>
                            <span>Satpam shift malam telah check-in</span>
                        </div>
                        <small class="text-muted">5 jam lalu</small>
                    </div>
                </div>
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
                        <span>Selesai</span>
                        <span>120</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>