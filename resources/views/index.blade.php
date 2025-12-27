<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWH Solutions | The best Storage Solution </title>

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
}

.navbar {
    background-color: #5A7ACD;
    width: 100%;
    position: fixed;
    top: 0;
    z-index: 99999;
    padding: 20px;
}

.navbar-brand span {
    font-size: 1.1rem;
}

.navbar-logo {
    width: 60px;
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

.navbar-auth {
    display: flex;
    align-items: center;
}

.navigasi-menu-mobile {
    display: none;
}
.hero-section {
    min-height: 100vh;
    padding: 3rem 1rem;
    background: linear-gradient(
        rgba(0, 0, 0, 0.60),
        rgba(0, 0, 0, 0.60)
    ), url('/asset/nwh1.jpeg');
    background-size: cover;
    background-position: center;
    color: #ffffff;
    display: flex;
    align-items: center;
    text-align: center;
}

.hero-section h1 {
    font-weight: 700;
    font-size: clamp(2rem, 5vw, 3.5rem);
}

.hero-section p {
    font-size: clamp(0.95rem, 2.5vw, 1.25rem);
    max-width: 720px;
    margin: 1rem auto 0;
    line-height: 1.6;
}

#about h2 {
    margin-bottom: 1rem;
}

#about p {
    line-height: 1.7;
    color: #333;
}

.card {
    border: none;
    border-radius: 15px;
}

#contact .card {
    min-width: 260px;
    max-width: 320px;
}

.wa-link {
    color: #000;
    text-decoration: none;
    transition: color 0.35s ease;
}

.wa-link:hover {
    color: #0dcaf0;
    text-decoration: underline;
}

.footer {
    background-color: #111;
    padding: 4rem 2rem 2rem;
    margin-top: 5rem;
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
}

.footer-description {
    font-size: 0.875rem;
    line-height: 1.6;
    color: #ccc;
}

.footer-column h3 {
    font-size: 1.125rem;
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
    font-size: 0.875rem;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #0dcaf0;
}

.contact-info {
    display: flex;
    gap: 0.5rem;
    font-size: 0.875rem;
    margin-bottom: 1rem;
    color: #ccc;
}

.contact-info i {
    color: #0dcaf0;
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
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-icon:hover {
    background-color: #0dcaf0;
    color: #000;
}

.copyright {
    text-align: center;
    font-size: 0.875rem;
    color: #aaa;
    border-top: 1px solid #333;
    padding-top: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 992px) {
    .footer-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    #about h2 {
        text-align: center;
    }

    #about p {
        text-align: justify;
    }

    .navigasi-menu {
        display: none;
    }

    /* Menu mobile muncul */
    .navigasi-menu-mobile {
        display: flex;
        width: 100%;
        justify-content: center;
        gap: 1.25rem;
        padding: 10px 0;
        background-color: #5A7ACD;
    }

    .navigasi-menu-mobile a {
        color: #fff;
        font-weight: 500;
        text-decoration: none;
    }

    .navbar-auth {
        margin-left: auto;
    }
}

@media (max-width: 576px) {
    body {
        padding-top: 56px;
    }

    .footer-container {
        grid-template-columns: 1fr;
        text-align: center;
    }

}


    </style>
</head>

<body>
<nav class="navbar navbar-dark">
    <div class="container-fluid px-4 navbar-horizontal">

        <!-- Brand -->
        <a href="#" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
            <img src="{{ asset('asset/LOGO NWH.png') }}" class="navbar-logo">
            <span>NWH Solution</span>
        </a>

        <!-- MENU DESKTOP -->
        <div class="navigasi-menu">
            <ul class="navbar-menu-horizontal">
                <li><a href="#home" class="nav-link">Home</a></li>
                <li><a href="#about" class="nav-link">About</a></li>
                <li><a href="#contact" class="nav-link">Contact</a></li>
            </ul>
        </div>

        <!-- LOGIN -->
        <div class="navbar-auth">
            <a href="{{ url('/login') }}" class="btn btn-light btn-login">Login</a>
        </div>

    </div>

    <!-- MENU MOBILE (TURUN KE BAWAH) -->
    <div class="navigasi-menu-mobile">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
    </div>
</nav>

    <section id="home" class="hero-section">
        <div class="container-fluid px-3 text-center">
            <h1 class="fw-bold display-4"> NWH Solution </h1>
            <p class="lead mt-3">
                Platform sewa gudang multi-tenant berbasis palet dengan transparasi penuh.
                Simpan barang Anda dalam satuan palet, pantau stok melalui dashboard, dan nikmati pengelolaan penyimpanan yang aman dan terstruktur
            </p>
            <a class="btn btn-light btn-lg mt-4" href="{{ url('/login') }}"> Login </a>

        </div>
    </section>

    <section id="about" class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3">
                    <h2 class="fw-bold"> Tentang Kami </h2>
                    <p>
                       Masih terjebak dengan manajemen gudang yang lambat dan tidak akurat? Saatnya beralih ke New Warehouse Solution. Kami menjawab tantangan logistik modern dengan menggabungkan infrastruktur cerdas dan lokasi strategis yang memudahkan distribusi. Kami tidak hanya menjaga barang Anda tetap aman, tapi kami memastikan setiap inci ruang yang Anda sewa berkontribusi langsung pada efisiensi biaya dan kecepatan operasional Anda
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d" class="img-fluid rounded" alt="Gudang">
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-secondary text-while text-center py-5">
        <div class="container">
            <h2 class="fw-bold"> Contact Us </h2>
            <p>Hubungi kami lebih lanjut</p>
        </div>

        <div class="d-flex gap-3 overflow-auto pb-3 justify-content-center">
            <div class="mb-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title fw-bold">WhatsApp</h5>
                        <p class="card-text">
                            <a href="https://wa.me/6281329388387" target="_blank" class="wa-link">
                                +62 813-2938-8387 (M. Arief)
                            </a>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </section>


    <footer class="footer bg-dark text-white" id="contact">
        <div class="footer-container">
            <div class="footer-column">
                <div class="footer-logo">
                    <i class="fas fa-warehouse"></i>
                    <span> NWH Solution </span>
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
            © 2025 NWH. Digital Logistics Excellence.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
