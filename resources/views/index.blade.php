<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWH Solutions | The best Storage Solution FOr New Business</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            padding-top: 64px;
            overflow-x: hidden;
        }

        /* ========== NAVBAR ========== */
        .navbar {
            background: linear-gradient(135deg, #4F6FD8, #5A7ACD);
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 99999;
            padding: 14px 0;
            transition: all 0.3s ease;
            padding: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand span {
            font-size: 1.1rem;
            letter-spacing: 0.3px;
            color: white;
        }

        .navbar-logo {
            width: 68px;
            height: auto;
            object-fit: contain;
        }

        .navbar-horizontal {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navigasi-menu {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .navbar-menu-horizontal {
            display: flex;
            gap: 1.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            color: #fff;
            font-weight: 500;
            text-decoration: none;
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
            position: relative;
            padding: 4px 0;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #fff !important;
            font-weight: 600 !important;
        }

        .navbar-menu-horizontal li a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background-color: #fff;
            transition: width 0.3s ease;
        }

        .navbar-menu-horizontal li a:hover::after {
            width: 100%;
        }

        .nav-link.active {
            font-weight: 700 !important;
        }

        .nav-link.active::after {
            width: 100% !important;
        }

        .btn-login {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.6);
            background-color: #ffffff;
            color: #4F6FD8;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-login i {
            font-size: 0.95rem;
        }

        .btn-login:hover {
            background-color: #4F6FD8;
            color: #ffffff;
            transform: translateY(-1px);
            border-color: #ffffff;
        }

        .navigasi-menu-mobile {
            display: none;
            width: 100%;
            justify-content: center;
            gap: 1rem;
            background-color: rgba(79, 111, 216, 0.98);
            padding: 10px;
        }

        .navigasi-menu-mobile a {
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            font-size: 0.9rem;
            position: relative;
        }

        .navigasi-menu-mobile a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -4px;
            width: 0;
            height: 2px;
            background-color: #fff;
            transition: width 0.3s ease;
        }

        .navigasi-menu-mobile a:hover::after {
            width: 100%;
        }

        .navigasi-menu-mobile a.active {
            font-weight: 700;
        }

        .navigasi-menu-mobile a.active::after {
            width: 100%;
        }

        /* ========== SECTIONS (FULL SCREEN) ========== */
        .section-fullscreen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 4rem 1rem;
        }

        /* ========== HERO SECTION ========== */
        .hero-section {
            background: linear-gradient(
                rgba(0, 0, 0, 0.70),
                rgba(0, 0, 0, 0.70)
            ), url('../asset/nwh1.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #ffffff;
            text-align: center;
        }

        .hero-section h1 {
            font-weight: 800;
            font-size: clamp(2.5rem, 6vw, 4rem);
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .hero-section p {
            font-size: clamp(1rem, 2.5vw, 1.35rem);
            max-width: 800px;
            margin: 1rem auto 2rem;
            line-height: 1.7;
            opacity: 0.9;
        }

        .hero-section .btn {
            padding: 12px 36px;
            font-size: 1.1rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .hero-section .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* ========== ABOUT SECTION ========== */
        .about-section {
            background: linear-gradient(170deg, #1C4D8D 50%, #BDE8F5 100%);
            color: #333;
        }

        .about-section h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #fff;
            font-size: clamp(2rem, 4vw, 2.8rem);
        }

        .about-section p {
            line-height: 1.8;
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .about-section .img-fluid {
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .about-section .img-fluid:hover {
            transform: scale(1.02);
        }

        /* ========== SERVICES SECTION ========== */
        .services-section {
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
            color: #333;
        }

        .services-section h2 {
            font-weight: 700;
            margin-bottom: 3rem;
            color: #4F6FD8;
            font-size: clamp(2rem, 4vw, 2.8rem);
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(79, 111, 216, 0.15);
        }

        .card-body {
            padding: 2rem;
        }

        .card h5 {
            font-weight: 700;
            color: #4F6FD8;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        /* ========== FAQ SECTION ========== */
        .faq-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #333;
        }

        .faq-section h2 {
            font-weight: 700;
            margin-bottom: 3rem;
            color: #4F6FD8;
            font-size: clamp(2rem, 4vw, 2.8rem);
            text-align: center;
        }

        .accordion-item {
            border: none;
            border-radius: 10px !important;
            margin-bottom: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .accordion-button {
            border-radius: 10px !important;
            font-weight: 600;
            color: #4F6FD8;
            padding: 1.25rem;
            border: 1px solid #e9ecef;
        }

        .accordion-button:not(.collapsed) {
            background-color: #4F6FD8;
            color: white;
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: #4F6FD8;
        }

        .accordion-body {
            padding: 1.25rem;
            color: #555;
            line-height: 1.6;
        }

        /* ========== CTA SECTION ========== */
        .cta-section {
            background: linear-gradient(135deg, #2c3e50 0%, #4F6FD8 100%);
            color: #ffffff;
        }

        .cta-section h2 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: clamp(2rem, 4vw, 2.8rem);
        }

        .cta-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 3rem 2rem;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .btn-consultation {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background-color: #25D366;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            padding: 18px 36px;
            border-radius: 50px;
            border: none;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-consultation:hover {
            background-color: #1da851;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
        }

        .cta-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .feature-item i {
            color: #25D366;
        }

        /* ========== FOOTER ========== */
        .footer {
            background-color: #111;
            padding: 4rem 2rem 2rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto 3rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-description {
            font-size: 0.95rem;
            line-height: 1.6;
            color: #ccc;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: #fff;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #ccc;
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #0dcaf0;
        }

        .contact-info {
            display: flex;
            gap: 0.75rem;
            font-size: 0.95rem;
            margin-bottom: 1.2rem;
            color: #ccc;
            align-items: flex-start;
        }

        .contact-info i {
            color: #0dcaf0;
            margin-top: 0.2rem;
            min-width: 20px;
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
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background-color: #0dcaf0;
            color: #000;
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            font-size: 0.9rem;
            color: #aaa;
            border-top: 1px solid #333;
            padding-top: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.footer-logo-img {
    height: 40px;
    width: auto;
    object-fit: contain;
}


        /* ================= RESPONSIVE ================= */

        @media (max-width: 992px) {
            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .section-fullscreen {
                padding: 3rem 1rem;
            }

            .cta-content {
                padding: 2.5rem 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 5px;
            }

            .title {
                margin-top: 10px;
            }

            .navigasi-menu {
                display: none;
            }

            .navigasi-menu-mobile {
                display: flex;
            }

            .hero-section {
                background-attachment: scroll;
            }

            .hero-section h1 {
                font-size: clamp(2rem, 5vw, 3rem);
            }

            .about-section h2,
            .services-section h2,
            .faq-section h2,
            .cta-section h2 {
                text-align: center;
            }

            .about-section p {
                text-align: justify;
            }

            .footer-container {
                gap: 2rem;
            }

            .cta-features {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .btn-consultation {
                padding: 15px 30px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding-top: 56px;
            }

            .navbar {
                padding: 5px 0;
            }

            .navbar-logo {
                width: 48px;
            }

            .navbar-brand span {
                font-size: 1rem;
            }

            .btn-login {
                padding: 6px 12px;
            }

            .btn-login .login-text {
                display: none;
            }

            .btn-login i {
                font-size: 1rem;
                margin: 0;
            }

            .navigasi-menu-mobile {
                font-size: 0.85rem;
                gap: 1rem;
            }

            .section-fullscreen {
                padding: 2rem 1rem;
                min-height: 90vh;
            }

            .hero-section h1 {
                font-size: 2.2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .cta-content {
                padding: 2rem 1rem;
            }

            .btn-consultation {
                padding: 12px 24px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .navbar-logo {
                width: 42px;
            }

            .navbar-brand span {
                font-size: 0.9rem;
            }

            .navigasi-menu-mobile {
                font-size: 0.8rem;
                gap: 0.75rem;
                padding: 10px 0;
            }

            .hero-section .btn {
                padding: 10px 30px;
                font-size: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-dark">
    <div class="container-fluid px-4 navbar-horizontal">
        <!-- Brand -->
        <a href="#" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
            <img src="{{ asset('asset/LOGO NWH.png') }}" class="navbar-logo" alt="NWH Logo">
            <span>NWH Solution</span>
        </a>

        <!-- MENU DESKTOP -->
        <div class="navigasi-menu">
            <ul class="navbar-menu-horizontal">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#services" class="nav-link">Service</a></li>
                <li><a href="#faq" class="nav-link">FAQ</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
        </div>

        <!-- LOGIN -->
        <a href="{{ url('/login') }}" class="btn btn-login">
            <i class="fa-solid fa-user"></i>
            <span class="login-text">Login</span>
        </a>
    </div>

    <!-- MENU MOBILE -->
    <div class="navigasi-menu-mobile">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Service</a>
        <a href="#faq">FAQ</a>
        <a href="#contact">Contact</a>
    </div>
</nav>

<!-- HERO SECTION -->
<section id="home" class="section-fullscreen hero-section">
    <div class="container-fluid px-3 text-center">
        <h1 class="fw-bold display-5">Sistem Manajemen Gudang Digital</h1>

        <p class="lead mt-3">
            Kelola penyimpanan barang berbasis palet secara terpusat.
            Pantau status barang, durasi penyimpanan, dan pengeluaran barang
            melalui satu dashboard yang aman dan terstruktur.
        </p>

        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
            <a class="btn btn-light btn-lg d-flex align-items-center gap-2"
               href="{{ url('/login') }}">
                <i class="fa-solid fa-box-open"></i>
                <span>Coba Sekarang</span>
            </a>

            <a class="btn btn-outline-light btn-lg d-flex align-items-center gap-2"
               href="#contact">
                <i class="fa-solid fa-headset"></i>
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section id="about" class="section-fullscreen about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h2 class="fw-bold">Tentang NWH Solution</h2>
                <p>
                    NWH Solution merupakan sistem manajemen gudang yang dirancang
                    untuk membantu perusahaan dalam mengelola penyimpanan barang
                    secara lebih tertib, aman, dan transparan.
                </p>
                <p>
                    Sistem ini memungkinkan perusahaan melakukan pemesanan
                    penyimpanan, memantau status barang, serta mengatur
                    pengeluaran barang sebagian melalui satu dashboard terpusat.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                     class="img-fluid rounded shadow"
                     alt="Modern Warehouse">
            </div>
        </div>
    </div>
</section>

<!-- SERVICES SECTION -->
<section id="services" class="section-fullscreen services-section">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Fitur Utama Sistem</h2>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-clipboard-list fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Manajemen Pesanan</h5>
                        <p>
                            Buat dan kelola pesanan penyimpanan barang berbasis palet
                            secara terstruktur dengan antarmuka yang mudah digunakan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-chart-line fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Monitoring Barang</h5>
                        <p>
                            Pantau status barang secara real-time mulai dari pengiriman, penyimpanan,
                            hingga pengeluaran barang dengan dashboard interaktif.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-box-open fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Pengambilan Sebagian</h5>
                        <p>
                            Ajukan permintaan pengeluaran sebagian barang tanpa
                            mengganggu data penyimpanan utama dan sistem inventaris.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section id="faq" class="section-fullscreen faq-section">
    <div class="container">
        <h2 class="fw-bold">Pertanyaan yang Sering Diajukan</h2>

        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                        Apa itu NWH Solution?
                    </button>
                </h3>
                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        NWH Solution adalah platform manajemen gudang berbasis digital yang menyediakan solusi penyimpanan barang dengan sistem palet. Platform ini dirancang untuk memberikan transparansi penuh dan kendali digital atas inventaris bisnis Anda.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                        Bagaimana cara memulai menggunakan layanan ini?
                    </button>
                </h3>
                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Anda dapat menghubungi tim kami melalui tombol konsultasi di bawah untuk mendiskusikan kebutuhan penyimpanan Anda. Setelah itu, kami akan membantu proses pendaftaran dan pengaturan akun untuk memulai penggunaan platform.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                        Apakah ada biaya pendaftaran atau setup?
                    </button>
                </h3>
                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Tidak ada biaya pendaftaran atau setup. Anda hanya membayar sesuai dengan jumlah palet yang disewa dan durasi penyimpanan. Semua biaya transparan dan dapat dilihat di dashboard Anda.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                        Bagaimana sistem keamanan gudang?
                    </button>
                </h3>
                <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Gudang kami dilengkapi dengan sistem keamanan 24/7 termasuk CCTV, akses kontrol, pemadam kebakaran, dan tim keamanan profesional. Semua barang dijamin dengan asuransi untuk memberikan perlindungan maksimal.
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h3 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                        Apakah bisa mengambil sebagian barang saja?
                    </button>
                </h3>
                <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Ya, platform kami mendukung pengambilan sebagian barang (partial withdrawal). Anda dapat mengajukan permintaan pengambilan sebagian melalui dashboard dan barang akan disiapkan sesuai jadwal yang Anda tentukan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section id="contact" class="section-fullscreen cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="fw-bold">Konsultasi Gratis</h2>
            <p>
                Mulai optimalkan manajemen gudang Anda hari ini. Tim ahli kami siap membantu Anda menemukan solusi penyimpanan yang tepat untuk bisnis Anda.
            </p>

            <a href="https://wa.me/6281329388387"
               target="_blank"
               class="btn-consultation">
                <i class="fab fa-whatsapp fa-2x"></i>
                <span>Konsultasi via WhatsApp</span>
            </a>

            <div class="cta-features">
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Respon dalam 5 menit</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Konsultasi gratis</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Analisis kebutuhan</span>
                </div>
                <div class="feature-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Demo platform</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer bg-dark text-white">
    <div class="footer-container">
        <div class="footer-column">
    <div class="footer-logo">
        <img src="{{ asset('asset/LOGO NWH.png') }}" alt="NWH Solution Logo" class="footer-logo-img">
        <span>NWH Solution</span>
    </div>
    <p class="footer-description">
        Platform sewa gudang multi-tenant pertama di Indonesia yang memberikan
        transparansi penuh dan kendali digital atas inventaris bisnis Anda.
    </p>
</div>

        <div class="footer-column">
            <h3>Tautan Cepat</h3>
            <ul class="footer-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#services">Layanan</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Kontak</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Kontak</h3>
            <div class="contact-info">
                <i class="fas fa-envelope"></i>
                <span>info@nwhsolution.co.id</span>
            </div>
            <div class="contact-info">
                <i class="fas fa-map-marker-alt"></i>
                <span>Jl. Logistik No. 123, Jakarta Pusat 10110</span>
            </div>
            <div class="contact-info">
                <i class="fas fa-phone-alt"></i>
                <span>+62 813-2938-8387 (WhatsApp)</span>
            </div>
        </div>

        <div class="footer-column">
            <h3>Social Media</h3>
            <p class="footer-description">Ikuti perkembangan terbaru kami di media sosial.</p>

            <div class="social-icons">
                <a href="#" class="social-icon" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="#" class="social-icon" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-icon" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-icon" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="copyright">
        © 2025 NWH Solution. Digital Logistics Excellence.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const navbar = document.querySelector('.navbar');

    function handleNavbarScroll() {
        if (window.scrollY > 10) {
            navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            navbar.style.padding = '5px 0';
        } else {
            navbar.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            navbar.style.padding = '10px 0';
        }
    }

    // Run on scroll
    window.addEventListener('scroll', handleNavbarScroll);

    // Run immediately on page load (INI KUNCINYA)
    document.addEventListener('DOMContentLoaded', handleNavbarScroll);

    window.addEventListener('scroll', () => {
        // Active navigation highlighting
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link, .navigasi-menu-mobile a');

        let currentSection = '';

        sections.forEach(section => {
            const sectionTop = section.offsetTop - 100;
            const sectionHeight = section.clientHeight;

            if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                currentSection = section.getAttribute('id');
            }
        });

        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === `#${currentSection}`) {
                link.classList.add('active');
            }
        });
    });

    // Mobile menu scroll behavior
    document.querySelectorAll('.nav-link, .navigasi-menu-mobile a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 55,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Initialize first FAQ as open
    document.addEventListener('DOMContentLoaded', function() {
        const firstFaq = document.querySelector('#faq1');
        if (firstFaq) {
            firstFaq.classList.add('show');
        }
    });
</script>
</body>
</html>
