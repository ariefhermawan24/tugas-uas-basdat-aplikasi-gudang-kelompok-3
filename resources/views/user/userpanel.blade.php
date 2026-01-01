<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Gudang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<style>
    body {
        background-color: #f4f6f9;
        min-height: 100vh;
    }

    /* SIDEBAR */
    .sidebar {
        min-height: 100vh;
        background: #1f2937;
        /* dark slate */
    }

    .sidebar .nav-link {
        color: #cbd5e1;
        border-radius: 6px;
        padding: 10px 14px;
    }

    .sidebar .nav-link:hover {
        background: #6c7f9c44;
        color: #ffffff;
    }

    .sidebar .nav-link.active {
        background: #343a49;
        color: white;
    }

    /* CONTENT */
    main {
        background: #ffffffc3;
    }
</style>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <nav class="col-md-3 col-lg-2 sidebar p-3">
                <h5 class="text-white mb-4">NWH Solution</h5>

                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="databarang.html">Data Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Stok Gudang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barangmasuk.html">Barang Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="barangkeluar.html">Barang Keluar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pengaturan</a>
                    </li>
                </ul>
            </nav>

            <!-- CONTENT -->
            <main class="col-md-9 col-lg-10 px-4 py-4">
                <h2>Dashboard</h2>
                <p>Selamat datang di sistem manajemen gudang.</p>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Total Barang</h6>
                                <h3>1.250</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Barang Masuk</h6>
                                <h3>320</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Barang Keluar</h6>
                                <h3>275</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <h1>USER</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">
                        Logout
                    </button>
                </form>
            </main>

        </div>
    </div>

</body>

</html>
