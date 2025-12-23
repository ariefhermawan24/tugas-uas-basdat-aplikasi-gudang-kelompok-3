<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gudang Amanah - Digital Logistics Excellence</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-primary: #0F172A;
            --bg-secondary: #1E293B;
            --bg-dark: #020617;
            --text-primary: #F8FAFC;
            --text-secondary: #94A3B8;
            --accent: #38BDF8;
            --border: #334155;
            --card-bg: #1E293B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .gradient-bg {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            pointer-events: none;
        }

        .gradient-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(250px);
            opacity: 0.15;
        }

        .circle-1 {
            background-color: var(--accent);
            width: 600px;
            height: 600px;
            top: -300px;
            right: -200px;
        }

        .circle-2 {
            background-color: #3b0764;
            width: 500px;
            height: 500px;
            bottom: -250px;
            left: -150px;
        }

        /* Navbar - Desktop Layout */
        .navbar {
            background-color: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-primary);
            text-decoration: none;
        }

        .logo-icon {
            color: var(--accent);
            font-size: 1.8rem;
        }

        .nav-links-container {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 1rem;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .login-btn {
            background: transparent;
            border: 1px solid var(--accent);
            color: var(--accent);
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .login-btn:hover {
            background-color: rgba(56, 189, 248, 0.1);
        }

        /* Responsive Navigation - Horizontal di bawah (tampil otomatis di mobile) */
        .responsive-nav {
            display: none;
            border-top: 1px solid rgba(51, 65, 85, 0.5);
            padding: 0.75rem 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* Firefox */
        }

        .responsive-nav::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Edge */
        }

        .responsive-nav-links {
            display: flex;
            list-style: none;
            gap: 1rem;
            min-width: max-content;
            justify-content: center;
            padding: 0 0.5rem;
        }

        .responsive-nav-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.4rem 0.8rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .responsive-nav-links a:hover {
            color: var(--accent);
            background-color: rgba(56, 189, 248, 0.1);
        }

        /* Hero Section */
        .hero {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 2rem;
            display: flex;
            align-items: center;
            gap: 4rem;
        }

        .hero-content {
            flex: 1;
        }

        .hero h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero h1 span {
            color: var(--accent);
        }

        .hero p {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .cta-button {
            background-color: var(--accent);
            color: var(--bg-primary);
            border: none;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(56, 189, 248, 0.2);
        }

        .dashboard-mockup {
            flex: 1;
            background-color: var(--bg-secondary);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .dashboard-title {
            font-weight: 600;
            color: var(--text-primary);
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background-color: rgba(30, 41, 59, 0.7);
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border);
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .chart-placeholder {
            height: 150px;
            background-color: rgba(30, 41, 59, 0.7);
            border-radius: 0.5rem;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        /* Trust Signals */
        .trust-section {
            background-color: var(--bg-dark);
            padding: 3rem 2rem;
        }

        .trust-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .trust-title {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 2rem;
            letter-spacing: 0.05em;
        }

        .trust-logos {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2.5rem;
            margin-bottom: 1.5rem;
            filter: grayscale(1) brightness(2);
            opacity: 0.7;
        }

        .logo-item {
            font-size: 2rem;
            color: var(--text-primary);
            opacity: 0.8;
        }

        .trust-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Value Proposition */
        .value-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        .section-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 3rem;
        }

        .value-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .value-card {
            background-color: var(--card-bg);
            border-radius: 1rem;
            padding: 2rem;
            border: 1px solid var(--border);
            transition: transform 0.3s ease;
        }

        .value-card:hover {
            transform: translateY(-5px);
        }

        .value-icon {
            background-color: rgba(56, 189, 248, 0.1);
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--accent);
            font-size: 1.5rem;
        }

        .value-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .value-card p {
            color: var(--text-secondary);
        }

        /* How It Works */
        .how-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 5rem 2rem;
        }

        .steps-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-top: 3rem;
        }

        .steps-container::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 10%;
            right: 10%;
            height: 2px;
            background-color: var(--border);
            background-image: linear-gradient(to right, var(--border) 50%, transparent 50%);
            background-size: 20px 2px;
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            background-color: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            width: 22%;
            text-align: center;
            border: 1px solid var(--border);
        }

        .step-number {
            background-color: var(--accent);
            color: var(--bg-primary);
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 1rem;
        }

        .step h3 {
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }

        .step p {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(to right, #0F172A, #1E293B);
            padding: 5rem 2rem;
            margin: 0 2rem;
            border-radius: 1rem;
            text-align: center;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-section h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
        }

        .cta-section p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-button-large {
            background-color: var(--accent);
            color: var(--bg-primary);
            border: none;
            padding: 1.25rem 3rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .cta-button-large:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(56, 189, 248, 0.3);
        }

        /* Footer */
        .footer {
            background-color: var(--bg-dark);
            padding: 4rem 2rem 2rem;
            margin-top: 5rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .footer-description {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .footer-column h3 {
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.875rem;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .contact-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .contact-info i {
            color: var(--accent);
            margin-top: 0.2rem;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-icon {
            width: 2.5rem;
            height: 2.5rem;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: var(--accent);
            color: var(--bg-primary);
        }

        .copyright {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Responsive Design */
        @media (max-width: 1135px) {
            .hero {
                flex-direction: column;
                text-align: center;
                gap: 3rem;
            }

            .hero h1 {
                font-size: 2.75rem;
            }

            .steps-container {
                flex-wrap: wrap;
                gap: 2rem;
                justify-content: center;
            }

            .steps-container::before {
                display: none;
            }

            .step {
                width: 45%;
                margin-bottom: 1rem;
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-mockup {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
            }

            .cta-button {
                justify-self: center;
            }

            .hero-content p {
                justify-self: center;
            }
        }

        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }

            .responsive-nav {
                display: block;
            }

            .login-btn span {
                display: inline-block;
            }

            .hero h1 {
                font-size: 2.25rem;
            }

            .step {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 3rem 1.5rem;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .value-cards {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cta-section {
                margin: 0;
                border-radius: 0;
                padding: 3rem 1.5rem;
            }

            .cta-section h2 {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .trust-logos {
                gap: 1.5rem;
            }

            .logo-item {
                font-size: 1.5rem;
            }

            .responsive-nav-links {
                gap: 0.75rem;
            }

            .responsive-nav-links a {
                font-size: 0.85rem;
                padding: 0.35rem 0.7rem;
            }
        }

        @media (max-width: 500px) {
            .nav-container {
                padding: 0 1rem;
            }

            .nav-main {
                padding: 0.75rem 0;
            }

            .logo {
                font-size: 1.25rem;
            }

            .logo-icon {
                font-size: 1.5rem;
            }

            .login-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }

            .login-btn span {
                display: inline-block;
            }

            .hero {
                padding: 2rem 1rem;
            }

            .hero h1 {
                font-size: 1.75rem;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
            }

            .cta-button-large {
                padding: 1rem 1.5rem;
                font-size: 1rem;
                width: 100%;
                justify-content: center;
            }

            .trust-logos {
                gap: 1rem;
            }

            .logo-item {
                font-size: 1.25rem;
            }

            .responsive-nav {
                padding: 0.5rem 0;
            }

            .responsive-nav-links {
                gap: 0.5rem;
            }

            .responsive-nav-links a {
                font-size: 0.8rem;
                padding: 0.3rem 0.6rem;
            }

            .social-icons {
                justify-content: center;
            }
        }

        @media (max-width: 400px) {
            .login-btn span {
                display: none;
            }

            .login-btn {
                padding: 0.5rem;
                width: 2.5rem;
                height: 2.5rem;
                justify-content: center;
            }

            .responsive-nav-links {
                gap: 0.3rem;
            }

            .responsive-nav-links a {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }

            .social-icons {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Background Gradients -->
    <div class="gradient-bg">
        <div class="gradient-circle circle-1"></div>
        <div class="gradient-circle circle-2"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-main">
                <a href="#" class="logo">
                    <i class="fas fa-warehouse logo-icon"></i>
                    <span>GUDANG AMANAH</span>
                </a>

                <div class="nav-links-container">
                    <ul class="nav-links">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#features">Fasilitas</a></li>
                        <li><a href="#pricing">Harga</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>

                    <a href="#" class="login-btn">
                        <i class="fas fa-user"></i>
                        <span>Masuk</span>
                    </a>
                </div>
            </div>

            <!-- Responsive Navigation - Horizontal di bawah (muncul otomatis di mobile) -->
            <div class="responsive-nav">
                <ul class="responsive-nav-links">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fasilitas</a></li>
                    <li><a href="#pricing">Harga</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Kelola Stok dengan <span>Keamanan Maksimal</span> & <span>Sistem Digital</span></h1>
            <p>
                Platform sewa gudang multi-tenant berbasis palet dengan transparansi penuh.
                Simpan barang Anda dalam satuan palet, pantau stok melalui dashboard,
                dan nikmati pengelolaan penyimpanan yang aman dan terstruktur.
            </p>
            <button class="cta-button">
                <span>Mulai Sewa Gudang</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <div class="dashboard-mockup">
            <div class="dashboard-header">
                <div class="dashboard-title">Dashboard Inventaris</div>
                <div style="color: var(--accent); font-size: 0.875rem;">
                    <i class="fas fa-circle" style="color: #10b981; font-size: 0.5rem;"></i> Live
                </div>
            </div>

            <div class="dashboard-stats grid-3">
                <div class="stat-card">
                    <div class="stat-value">1,248</div>
                    <div class="stat-label">Item Tersimpan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">85%</div>
                    <div class="stat-label">Kapasitas Terisi</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">36</div>
                    <div class="stat-label">Palet Digunakan</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">100%</div>
                    <div class="stat-label">Akurasi Stok</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Tenant Aktif</div>
                </div>

                <div class="stat-card">
                    <div class="stat-value">24 Jam</div>
                    <div class="stat-label">Monitoring Sistem</div>
                </div>
            </div>
        </div>

    </section>

    <!-- Trust Signals -->
    <section class="trust-section">
        <div class="trust-container">
            <div class="trust-title">TELAH DIPERCAYA OLEH</div>

            <div class="trust-logos">
                <div class="logo-item">
                    <i class="fas fa-building"></i>
                </div>
                <div class="logo-item">
                    <i class="fas fa-store"></i>
                </div>
                <div class="logo-item">
                    <i class="fas fa-industry"></i>
                </div>
                <div class="logo-item">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="logo-item">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="logo-item">
                    <i class="fas fa-warehouse"></i>
                </div>
            </div>

            <p class="trust-text">Telah dipercaya oleh 50+ perusahaan nasional dan UMKM.</p>
        </div>
    </section>

    <!-- Value Proposition -->
    <section class="value-section" id="features">
        <h2 class="section-title">Kenapa Harus Kami?</h2>

        <div class="value-cards">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-th"></i>
                </div>
                <h3>Multi-Tenant System</h3>
                <p>Satu akun untuk kendali penuh atas semua barang yang Anda titipkan di cabang kami.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Real-Time Tracking</h3>
                <p>Pantau status barang masuk dan keluar secara detik demi detik dari smartphone Anda.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-expand-alt"></i>
                </div>
                <h3>Skalabilitas Fleksibel</h3>
                <p>Butuh tambahan 10 palet bulan depan? Tambah kapasitas hanya dengan sekali klik.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Keamanan Berlapis</h3>
                <p>CCTV 24/7, asuransi penuh, dan sistem verifikasi barang yang ketat.</p>
            </div>

            <!-- Tambahan 2 Value Proposition Baru -->
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-database"></i>
                </div>
                <h3>Manajemen Data Terpusat</h3>
                <p>Seluruh data penyimpanan barang tersimpan rapi dalam satu sistem terpusat.</p>
            </div>

            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Dukungan 24/7</h3>
                <p>Tim customer service siap membantu Anda kapan saja melalui chat, telepon, atau email.</p>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-section">
        <h2 class="section-title">Langkah Mudah</h2>

        <div class="steps-container">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Daftar Akun</h3>
                <p>Buat akun perusahaan untuk mengelola penyimpanan barang secara digital.</p>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h3>Tentukan Jumlah Palet</h3>
                <p>Pilih jumlah palet yang dibutuhkan sesuai kapasitas penyimpanan barang.</p>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <h3>Serah Terima Barang</h3>
                <p>Kirim barang ke gudang kami dan data barang akan dicatat ke dalam sistem.</p>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <h3>Pantau Stok</h3>
                <p>Monitor jumlah dan status stok barang melalui dashboard kapan saja.</p>
            </div>

        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <h2>Siap Mengelola Penyimpanan Barang dengan Lebih Efisien?</h2>
            <p>
                Tim kami siap membantu Anda menentukan kebutuhan penyimpanan berbasis palet
                sesuai kapasitas dan skala bisnis Anda.
            </p>
            <button class="cta-button-large">
                <i class="fas fa-headset"></i>
                <span>Konsultasi Penyimpanan</span>
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-container">
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-warehouse"></i>
                    <span>GUDANG AMANAH</span>
                </div>
                <p class="footer-description">Platform sewa gudang multi-tenant pertama di Indonesia yang memberikan
                    transparansi penuh dan kendali digital atas inventaris bisnis Anda.</p>
            </div>

            <div class="footer-column">
                <h3>Tautan Cepat</h3>
                <ul class="footer-links">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#features">Fasilitas</a></li>
                    <li><a href="#pricing">Harga</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Kontak</h3>
                <div class="contact-info">
                    <i class="fas fa-envelope"></i>
                    <span>info@gudangamanah.co.id</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Logistik No. 123, Jakarta Pusat 10110</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone-alt"></i>
                    <span>+62 21 1234 5678 (WhatsApp)</span>
                </div>
            </div>

            <div class="footer-column">
                <h3>Social Media</h3>
                <p class="footer-description">Ikuti perkembangan terbaru kami di media sosial.</p>

                <div class="social-icons">
                    <a href="#" class="social-icon">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="copyright">
            © 2025 Gudang Amanah. Digital Logistics Excellence.
        </div>
    </footer>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add hover effect to value cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe value cards
        document.querySelectorAll('.value-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });

        // Observe steps
        document.querySelectorAll('.step').forEach(step => {
            step.style.opacity = '0';
            step.style.transform = 'translateY(20px)';
            step.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(step);
        });

        // Animate steps sequentially
        const steps = document.querySelectorAll('.step');
        steps.forEach((step, index) => {
            step.style.transitionDelay = `${index * 0.1}s`;
        });

        // Add active state to nav links on scroll
        const sections = document.querySelectorAll('section[id]');

        function highlightNavLink() {
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 120;
                const sectionId = section.getAttribute('id');
                const navLink = document.querySelector(`.nav-links a[href="#${sectionId}"]`);
                const respNavLink = document.querySelector(`.responsive-nav-links a[href="#${sectionId}"]`);

                if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                    if (navLink) navLink.style.color = 'var(--accent)';
                    if (respNavLink) respNavLink.style.color = 'var(--accent)';
                } else {
                    if (navLink) navLink.style.color = '';
                    if (respNavLink) respNavLink.style.color = '';
                }
            });
        }

        window.addEventListener('scroll', highlightNavLink);
    </script>
</body>

</html>
