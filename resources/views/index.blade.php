<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Landing Page </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* body {
            padding-top: 56px;
        } */

        /* @media (min-width: 992px) {
            body {
                padding-top: 70px;
            }
        } */

        .navbar {
            margin-bottom: 0;
        }

        .hero-section {
            margin-top: 0;
            min-height: 100vh;
            height: auto;
            background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('resources\asset\nwh1.jpeg');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            align-items: center;
        }

        .navbar-logo {
            width: 60px;          /* ukuran logo */
            height: auto;
            object-fit: contain;
        }

        @media (max-width: 576px) {
            .navbar-logo {
                width: 32px;      /* lebih kecil di mobile */
            }
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .wa-link {
            color: black;
            text-decoration: none;
            transition: o.35;
        }

        .wa-link:hover{
            color: aqua;
            text-decoration: underline;
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

       

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container-fluid px-4">
            <a href="#" class="navbar-brand d-flex align-items-center gap-2 fw-bold">
                <img src="resources\asset\LOGO NWH.png" alt="NWH Logo" class="navbar-logo">
                <span>Solution</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="#home" class="nav-link"> Home </a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link"> About </a>
                    </li>
                    <li class="nav-item">
                        <a href="#contact" class="nav-link"> Contact </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div class="container-fluid px-3 text-center">
            <h1 class="fw-bold display-4"> NWH Solution </h1>
            <p class="lead mt-3">
                Platform sewa gudang multi-tenant berbasis palet dengan transparasi penuh. 
                Simpan barang Anda dalam satuan palet, pantau stok melalui dashboard, dan nikmati pengelolaan penyimpanan yang aman dan terstruktur
            </p>
            <a class="btn btn-light btn-lg mt-4" href="login.html"> Login </a>

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