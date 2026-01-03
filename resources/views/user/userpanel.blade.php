<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin Panel</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-color: #1f2937;
            --secondary-color: #3b82f6;
            --light-color: #f8f9fa;
            --dark-color: #1f2937;
            --sidebar-width: 260px;
            --navbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* NAVBAR STYLES */
        .top-navbar {
            height: var(--navbar-height);
            background-color: #1f2a3a;
            color: #ffffff;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .navbar-brand,
        .navbar-brand i {
            color: #ffffff !important;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-right: 20px;
            cursor: pointer;
            display: none;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;

            font-weight: 600;
            font-size: 1.4rem;
        }

        .navbar-brand i {
            font-size: 1.2rem;
        }

        .navbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-bell {
            position: relative;
            cursor: pointer;
            font-size: 1.5rem;
            /* dari 1.2rem */
            color: #fff;
        }

        /* Badge */
        .notif-badge {
            position: absolute;
            top: -4px;
            right: -6px;
            background: #ef4444;
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 999px;
            display: none;
        }

        .notification-bell {
            transition: transform 0.2s ease, color 0.2s ease;
        }

        .notification-bell:hover {
            transform: scale(1.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            background-color: #4f6fd8;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;

            transition:
                background-color 0.25s ease,
                box-shadow 0.25s ease,
                transform 0.2s ease;
        }

        .user-avatar:hover {
            background-color: #3b5bcc;
            /* sedikit lebih gelap */
            box-shadow: 0 6px 16px rgba(79, 111, 216, 0.35);
            transform: translateY(-2px);
        }

        .user-avatar i {
            font-size: 1.1rem;
            transition: transform 0.2s ease;
        }

        .user-avatar:hover i {
            transform: scale(1.1);
        }

        .user-menu {
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: 52px;
            right: 0;

            width: 220px;
            background: #253449;
            /* navy soft */
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);

            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px);
            transition: all 0.25s ease;

            z-index: 2000;
        }

        .user-menu.active .user-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* User Info */
        .user-info {
            padding: 12px 16px;
            border-bottom: 1px solid #334155;
        }

        .user-info strong {
            display: block;
            font-size: 0.95rem;
            color: #f8fafc;
        }

        .user-info small {
            font-size: 0.8rem;
            color: #cbd5e1;
        }

        /* Dropdown Items */
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 10px 16px;
            font-size: 0.9rem;
            text-decoration: none;

            color: #e2e8f0;
            transition: background 0.2s ease, padding-left 0.2s ease;
        }

        .dropdown-item i {
            color: #94a3b8;
        }

        .dropdown-item:hover {
            background: #2e405c;
            padding-left: 20px;
        }

        .dropdown-item:hover i {
            color: #ffffff;
        }

        /* Divider */
        .dropdown-divider {
            height: 1px;
            background: #334155;
            margin: 6px 0;
        }

        /* Logout */
        .dropdown-item.logout {
            color: #f87171;
        }

        .dropdown-item.logout i {
            color: #f87171;
        }

        .dropdown-item.logout:hover {
            background: rgba(248, 113, 113, 0.15);
        }

        /* SIDEBAR STYLES - Desktop */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--primary-color);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1100;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .company-logo {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .company-info h5 {
            color: white;
            font-weight: 600;
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .company-info p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            width: calc(100% - 40px);
            margin: 20px auto;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .nav-link {
            color: #cbd5e1 !important;
            border-radius: 6px;
            padding: 12px 20px;
            margin: 0 10px 5px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }

        .nav-link:hover,
        .nav-link:focus {
            background: rgba(108, 127, 156, 0.3);
            color: white !important;
            transform: translateX(3px);
        }

        /* Animasi hover effect */
        .nav-link::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.1),
                    transparent);
            transition: left 0.6s ease;
        }

        .nav-link:hover::after {
            left: 100%;
        }

        .nav-link.active {
            background: var(--secondary-color);
            color: white !important;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
            animation: activePulse 0.6s ease-out;
        }

        /* Dashboard aktif state */
        .nav-link.dashboard-active {
            background: var(--secondary-color);
            color: white !important;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
            animation: activePulse 0.6s ease-out;
        }

        .nav-link.dashboard-active i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes activePulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 4px 8px rgba(59, 130, 246, 0.2);
            }
        }

        /* PERBAIKAN SUBMENU: Lebar sama dengan menu utama dengan animasi smooth */
        .submenu {
            padding-left: 0;
            margin-top: 5px;
            width: 100%;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.3s ease,
                transform 0.3s ease;
            opacity: 0;
            transform: translateY(-10px);
        }

        .submenu.show {
            max-height: 500px;
            /* Nilai cukup besar untuk menampung semua item */
            opacity: 1;
            transform: translateY(0);
        }

        .submenu .nav-link {
            padding: 10px 20px 10px 52px;
            margin: 0 10px 2px;
            font-size: 0.9rem;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: calc(100% - 20px);
            opacity: 0;
            transform: translateX(-10px);
            transition-delay: calc(var(--index) * 0.05s);
        }

        .submenu.show .nav-link {
            opacity: 1;
            transform: translateX(0);
        }

        /* Efek menjorok ke depan saat hover */
        .submenu .nav-link:hover,
        .submenu .nav-link.active {
            background: rgba(108, 127, 156, 0.4);
            transform: translateX(5px) !important;
            /* Efek menjorok ke depan */
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Ikon untuk submenu */
        .submenu .nav-link i {
            font-size: 0.85rem;
            width: 20px;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .submenu .nav-link:hover i,
        .submenu .nav-link.active i {
            color: white;
            transform: scale(1.1);
        }

        .menu-item {
            position: relative;
        }

        /* PERBAIKAN: PANAH MENGHADAP KE BAWAH DAN POSISI TETAP */
        .menu-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%) rotate(0deg) !important;
            /* Default: menghadap ke kanan */
            color: rgba(255, 255, 255, 0.7);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                color 0.3s ease;
            width: 16px;
            height: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            /* Mencegah interaksi langsung dengan panah */
        }

        /* Panah menghadap ke bawah saat aktif */
        .menu-toggle.rotated {
            transform: translateY(-50%) rotate(90deg) !important;
            /* 90° = menghadap ke bawah */
            color: white;
        }

        /* Animasi untuk icon menu saat aktif */
        .nav-link.active i,
        .nav-link.dashboard-active i {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link.active i {
            transform: scale(1.1);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 25px;
            transition: margin-left 0.3s ease;
            min-height: calc(100vh - var(--navbar-height));
        }

        .dashboard-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 5px;
            animation: fadeInUp 0.6s ease-out;
        }

        .dashboard-subtitle {
            color: #6c757d;
            margin-bottom: 25px;
            animation: fadeInUp 0.6s ease-out 0.1s both;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.08);
        }

        .card-body {
            padding: 25px;
        }

        .card h6 {
            color: #6c757d;
            font-size: 0.95rem;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .card h3 {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.2rem;
        }

        .stats-icon {
            font-size: 2.5rem;
            color: var(--secondary-color);
            opacity: 0.9;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .card:hover .stats-icon {
            transform: scale(1.1);
        }

        .swal2-container {
            z-index: 99999 !important;
        }

        /* Popup text */
        .swal-logout-popup {
            color: #000;
        }

        /* Judul */
        .swal-logout-title {
            color: #000;
        }

        /* Isi teks */
        .swal-logout-text {
            color: #000;
        }

        /* Tombol Logout (confirm) */
        .swal-logout-confirm {
            background-color: red !important;
            color: #fff !important;
            border: none !important;
        }

        /* Tombol Batal (sebelumnya abu-abu) */
        .swal-logout-cancel {
            background-color: #000 !important;
            color: #fff !important;
            border: none !important;
        }

        .swal-logout-confirm:hover {
            background-color: #ef4444;
        }

        .swal-logout-cancel:hover {
            background-color: #222 !important;
        }

        /* Modal Wrapper */
        .notif-modal {
            position: fixed;
            inset: 0;
            display: none;
            z-index: 3000;
        }

        /* Backdrop */
        .notif-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(10, 15, 30, 0.7);
            backdrop-filter: blur(4px);
        }

        /* Modal Box */
        .notif-container {
            position: relative;
            margin: auto;
            top: 80px;
            max-width: 420px;
            width: 90%;
            height: 520px;
            /* tinggi dikunci */
            background: #0f172a;
            color: #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            animation: slideDown 0.3s ease;
        }

        /* Header tetap */
        .notif-header {
            flex-shrink: 0;
            padding: 14px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #0f172a;
            border-radius: 14px 14px 0 0;
        }

        /* BODY YANG SCROLL */
        .notif-body {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 6px;
            overflow-x: hidden;
        }

        /* Scrollbar Dark Blue */
        .notif-body::-webkit-scrollbar {
            width: 6px;
        }

        .notif-body::-webkit-scrollbar-track {
            background: transparent;
        }

        .notif-body::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.4);
            border-radius: 10px;
        }

        .notif-body::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }

        .notif-header h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            z-index: 1000;
        }

        .notif-close {
            background: none;
            border: none;
            color: #9ca3af;
            font-size: 22px;
            cursor: pointer;
            z-index: 1000;
        }

        .notif-item {
            padding: 20px;
            position: relative;
            overflow: hidden;
            /* penting: agar tidak keluar card */
            padding-bottom: 34px;
            /* ruang untuk indikator */
        }

        .notif-item:hover {
            background: rgba(59, 130, 246, 0.12);
        }

        /* SWIPE RIGHT → READ */
        .notif-item::before {
            content: "✔ Tandai dibaca";
            position: absolute;
            left: 16px;
            bottom: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #22c55e;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* SWIPE LEFT → DELETE */
        .notif-item::after {
            content: "🗑 Hapus";
            position: absolute;
            right: 16px;
            bottom: 8px;
            font-size: 12px;
            font-weight: 500;
            color: #ef4444;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Tampilkan indikator */
        .notif-item.swipe-right::before {
            opacity: 1;
        }

        .notif-item.swipe-left::after {
            opacity: 1;
        }

        .notif-item.swipe-right {
            background: linear-gradient(to right,
                    rgba(34, 197, 94, 0.08),
                    transparent) !important;
        }

        .notif-item.swipe-left {
            background: linear-gradient(to left,
                    rgba(239, 68, 68, 0.08),
                    transparent) !important;
        }

        .notif-item.unread {
            background: rgba(59, 130, 246, 0.08);
        }

        .notif-item.unread:hover {
            background: rgba(59, 130, 246, 0.16);
        }

        .notif-title {
            margin: 0;
            font-weight: 600;
            font-size: 14px;
        }

        .notif-text {
            display: block;
            font-size: 13px;
            color: #cbd5f5;
            margin: 4px 0;
        }

        .notif-item small {
            color: #94a3b8;
        }

        .notif-empty {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;

            color: #ffffff;
            font-size: 14px;
            opacity: 0.85;
            text-align: center;
        }

        /* Animation */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
        }

        /* RESPONSIVE STYLES */
        @media (max-width: 992px) {

            /* SIDEBAR MOBILE - Muncul dari bawah dengan animasi smooth */
            .sidebar {
                transform: translateY(100%);
                width: 100%;
                height: 85vh;
                min-height: auto;
                top: auto;
                bottom: 0;
                left: 0;
                right: 0;
                border-radius: 20px 20px 0 0;
                box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.15);
                transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            }

            .sidebar.show {
                transform: translateY(0);
            }

            .main-content {
                margin-left: 0;
                transition: margin-left 0.3s ease;
            }

            .sidebar-toggle {
                display: block;
                color: white !important;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1099;
                backdrop-filter: blur(3px);
                transition: opacity 0.3s;
            }

            .overlay.show {
                display: block;
                animation: fadeIn 0.3s ease;
            }

            /* Header sidebar mobile */
            .sidebar-header {
                padding: 20px;
                position: relative;
            }

            .mobile-sidebar-handle {
                position: absolute;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                width: 40px;
                height: 4px;
                background-color: rgba(255, 255, 255, 0.3);
                border-radius: 2px;
                transition: transform 0.3s ease;
            }

            .sidebar.show .mobile-sidebar-handle {
                transform: translateX(-50%) scaleX(1.2);
            }

            /* Konten menu mobile */
            .sidebar-menu {
                padding: 15px 0;
                max-height: calc(85vh - 220px) !important;
                overflow-y: auto;
            }

            /* Tombol logout mobile */
            .logout-btn {
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                width: 90%;
                margin: 0;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .logout-btn:hover {
                transform: translateX(-50%) scale(1.02);
            }

            .top-navbar {
                padding: 0 15px;
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {

            .main-content {
                padding: 20px 15px;
            }

            .card h3 {
                font-size: 1.8rem;
            }

            .submenu .nav-link {
                padding-left: 48px;
            }

            /* Sidebar lebih tinggi di perangkat lebih kecil */
            .sidebar {
                height: 90vh;
            }

            .sidebar-menu {
                max-height: calc(90vh - 180px);
            }
        }

        @media (max-width: 576px) {
            .notif-container {
                top: 60px;
                height: 85vh;
                /* adaptif mobile */
                max-width: 95%;
            }
        }

        /* ANIMATIONS */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
            }

            to {
                transform: translateY(0);
            }
        }

        /* PERBAIKAN: Hindari perubahan warna Bootstrap */
        a.nav-link:active,
        a.nav-link:focus {
            color: white !important;
        }

        /* PERBAIKAN: Warna teks submenu */
        .submenu a.nav-link {
            color: #cbd5e1 !important;
        }

        .submenu a.nav-link:hover,
        .submenu a.nav-link:focus,
        .submenu a.nav-link.active {
            color: white !important;
        }

        /* GARIS VERTIKAL UNTUK SUBMENU - DIUBAH DI SINI */
        .submenu .nav-link {
            position: relative;
        }

        .submenu .nav-link::before {
            content: '';
            position: absolute;
            left: 32px;
            top: 50%;
            bottom: 50%;
            width: 1px;
            /* Lebih tipis */
            background-color: rgba(255, 255, 255, 0.15);
            /* Lebih terlihat */
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        /* Garis selalu terlihat, tetapi pendek */
        .submenu.show .nav-link::before {
            top: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.1);
            /* Warna konsisten */
        }

        /* Garis menjadi lebih terang dan berwarna saat hover/active */
        .submenu .nav-link:hover::before,
        .submenu .nav-link.active::before {
            background-color: var(--secondary-color);
            width: 2px;
            /* Sedikit lebih tebal saat aktif */
        }

        /* Scrollbar untuk sidebar menu mobile */
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Animasi untuk card dashboard */
        .dashboard-card-highlight {
            position: relative;
            overflow: hidden;
            animation: cardSlideIn 0.6s ease-out;
        }

        @keyframes cardSlideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dashboard-card-highlight::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--secondary-color);
            border-radius: 12px 0 0 12px;
            transition: width 0.3s ease;
        }

        .dashboard-card-highlight.warning {
            --secondary-color: #f59e0b;
        }

        .dashboard-card-highlight.success {
            --secondary-color: #15803d;
        }

        .dashboard-card-highlight:hover::before {
            width: 6px;
        }

        .sidebar-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            margin: 12px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .profile-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.85);
            font-size: 18px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }


        .profile-info {
            line-height: 1.5;
        }

        .company-name {
            font-size: 16px;
            font-weight: 600;
            color: #e5e7eb;
        }

        .representative-name {
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>

@php
$user = Auth::user();
@endphp

<body data-active-module="{{ $module ?? 'dashboard' }}">
    <!-- Overlay untuk mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Top Navbar -->
    <nav class="top-navbar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="navbar-brand">
            <i class="fas fa-window-restore"></i>
            <span>User Panel</span>
        </div>

        <div class="navbar-right">
            <div class="notification-bell">
                <i class="far fa-bell"></i>
                <span class="notification-badge" id="notifBadge">3</span>
            </div>
            <div class="user-menu">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div class="user-dropdown">
                    <div class="user-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>{{ Auth::user()->email }}</small>
                    </div>

                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#accountDetailModal">
                        <i class="fas fa-id-card"></i>
                        <span>Account Detail</span>
                    </a>

                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key"></i>
                        <span>Ubah Sandi</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <a href="#" class="dropdown-item logout logoutBtn">
                            <i class="fas fa-right-from-bracket"></i>
                            <span>Keluar</span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Handle untuk drag di mobile -->
        <div class="mobile-sidebar-handle"></div>

        <div class="sidebar-header">
            <div class="company-logo">
                <img src="{{ asset('/asset/LOGO NWH.png') }}" alt="NWH Logo">
            </div>
            <div class="company-info">
                <h5>NWH Solution</h5>
            </div>
        </div>

        <div class="sidebar-profile">
            <div class="profile-icon">
                <i class="fas fa-building"></i>
            </div>

            <div class="profile-info">
                <div class="company-name">{{ Auth::user()->company_name }}</div>
                <div class="representative-name">{{ Auth::user()->name }}</div>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <div class="sidebar-menu">
            <div class="menu-item">
                <a class="nav-link dashboard-active {{ ($module ?? 'dashboard') === 'dashboard' ? 'active' : '' }}"
                    href="{{ route('user', 'dashboard') }}"
                    id="dashboardLink">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="menu-item">
                <a class="nav-link menu-parent
        {{ in_array($module ?? '', ['make_order','renew_order','orders_history']) ? 'active' : '' }}"
                    href="#"
                    data-menu="order-management">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Order Management</span>
                    <i class="fas fa-chevron-right menu-toggle"></i>
                </a>

                <div class="submenu">
                    <a class="nav-link submenu-item {{ ($module ?? '') === 'make_order' ? 'active' : '' }}"
                        href="{{ route('user', 'make_order') }}"
                        data-parent="order-management"
                        style="--index:0">
                        <i class="fas fa-plus-circle"></i>
                        <span>Make Order</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'renew_order' ? 'active' : '' }}"
                        href="{{ route('user', 'renew_order') }}"
                        data-parent="order-management"
                        style="--index:1">
                        <i class="fas fa-rotate-right"></i>
                        <span>Renew Order</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'orders_history' ? 'active' : '' }}"
                        href="{{ route('user', 'orders_history') }}"
                        data-parent="order-management"
                        style="--index:2">
                        <i class="fas fa-history"></i>
                        <span>Order History</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <a class="nav-link menu-parent
        {{ in_array($module ?? '', ['orders_details','active_orders','due_orders','expired_orders']) ? 'active' : '' }}"
                    href="#"
                    data-menu="order-monitoring">
                    <i class="fas fa-chart-line"></i>
                    <span>Order Monitoring</span>
                    <i class="fas fa-chevron-right menu-toggle"></i>
                </a>

                <div class="submenu">
                    <a class="nav-link submenu-item {{ ($module ?? '') === 'orders_details' ? 'active' : '' }}"
                        href="{{ route('user', 'orders_details') }}"
                        data-parent="order-monitoring"
                        style="--index:0">
                        <i class="far fa-list-alt"></i>
                        <span>Order Detail</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'active_orders' ? 'active' : '' }}"
                        href="{{ route('user', 'active_orders') }}"
                        data-parent="order-monitoring"
                        style="--index:1">
                        <i class="fas fa-play-circle"></i>
                        <span>Active Order</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'due_orders' ? 'active' : '' }}"
                        href="{{ route('user', 'due_orders') }}"
                        data-parent="order-monitoring"
                        style="--index:2">
                        <i class="far fa-clock"></i>
                        <span>Due Order</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'expired_orders' ? 'active' : '' }}"
                        href="{{ route('user', 'expired_orders') }}"
                        data-parent="order-monitoring"
                        style="--index:3">
                        <i class="fas fa-calendar-times"></i>
                        <span>Expired Order</span>
                    </a>
                </div>
            </div>

            <div class="menu-item">
                <a class="nav-link menu-parent
        {{ in_array($module ?? '', ['goods_in','goods_out']) ? 'active' : '' }}"
                    href="#"
                    data-menu="goods-flow">
                    <i class="fas fa-boxes"></i>
                    <span>Goods Flow</span>
                    <i class="fas fa-chevron-right menu-toggle"></i>
                </a>

                <div class="submenu">
                    <a class="nav-link submenu-item {{ ($module ?? '') === 'goods_in' ? 'active' : '' }}"
                        href="{{ route('user', 'goods_in') }}"
                        data-parent="goods-flow"
                        style="--index:0">
                        <i class="fas fa-arrow-down"></i>
                        <span>Goods In</span>
                    </a>

                    <a class="nav-link submenu-item {{ ($module ?? '') === 'goods_out' ? 'active' : '' }}"
                        href="{{ route('user', 'goods_out') }}"
                        data-parent="goods-flow"
                        style="--index:1">
                        <i class="fas fa-arrow-up"></i>
                        <span>Goods Out</span>
                    </a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn logoutBtn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>

    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @include('user.modul.' . ($module ?? 'dashboard'))
    </main>

    <!-- Modal Notification -->
    <div class="notif-modal" id="notifModal">
        <div class="notif-backdrop"></div>

        <div class="notif-container">
            <div class="notif-header">
                <h5>Notifikasi</h5>
                <button class="notif-close" id="closeNotif">&times;</button>
            </div>

            <div class="notif-body">
                @forelse ($notifications as $notif)
                <div class="notif-item {{ !$notif->is_read ? 'unread' : '' }}"
                    data-id="{{ $notif->id }}">
                    <p class="notif-title">{{ $notif->title }}</p>
                    <span class="notif-text">{{ $notif->message }}</span>
                    <small>{{ $notif->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <div class="notif-empty">
                    Tidak ada notifikasi
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="modal fade" id="accountDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <!-- Header -->
                <div class="modal-header px-4 align-items-center">
                    <div class="me-3">
                        <h5 class="modal-title fw-semibold mb-0">Account Detail</h5>
                        <small class="text-muted d-block">
                            Informasi akun yang sedang login
                        </small>
                    </div>

                    <div class="d-flex align-items-center gap-2 ms-auto">

                        <!-- Desktop -->
                        <button
                            class="btn btn-outline-primary btn-sm d-none d-sm-flex align-items-center"
                            id="btnEditAccount"
                            style="height:32px;">
                            <i class="fas fa-edit me-1"></i><span>Edit</span>
                        </button>

                        <!-- Mobile -->
                        <button
                            class="btn btn-outline-primary btn-sm d-flex d-sm-none align-items-center justify-content-center"
                            id="btnEditAccountMobile"
                            style="height:32px;width:32px;"
                            title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>


                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>


                <!-- Body -->
                <div class="modal-body px-4">

                    <!-- PROFILE HEADER -->
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:60px;height:60px;font-size:22px;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>

                    <!-- VIEW MODE -->
                    <div id="viewMode">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small">User Code</label>
                                <div class="fw-medium">{{ $user->user_code }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Role</label>
                                <div>
                                    <span class="badge bg-primary px-3">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Company</label>
                                <div class="fw-medium">{{ $user->company_name ?? '-' }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Phone</label>
                                <div class="fw-medium">{{ $user->phone }}</div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Status</label>
                                <div>
                                    <span class="badge bg-success px-3">{{ ucfirst($user->status) }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="text-muted small">Joined At</label>
                                <div class="fw-medium">{{ $user->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- EDIT MODE -->
                    <form id="editMode" class="d-none" method="POST" action="{{ route('account.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- ORIGINAL VALUES (PEMBANDING) -->
                        <input type="hidden" id="original_name" value="{{ $user->name }}">
                        <input type="hidden" id="original_email" value="{{ $user->email }}">
                        <input type="hidden" id="original_company_name" value="{{ $user->company_name }}">
                        <input type="hidden" id="original_phone" value="{{ $user->phone }}">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="name"
                                    name="name"
                                    value="{{ $user->name }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="{{ $user->email }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="company_name"
                                    name="company_name"
                                    value="{{ $user->company_name }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    value="{{ $user->phone }}">
                            </div>

                        </div>

                        <div class="text-end mt-4">
                            <button
                                type="submit"
                                id="btnSaveAccount"
                                class="btn btn-primary btn-sm px-4"
                                disabled>
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Ubah Sandi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('account.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Sandi Lama</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sandi Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 99999">

        @if (session('account_success'))
        <div class="toast toast-animate text-bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ session('account_success') }}
                </div>
                <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif

        @if (session('account_error'))
        <div class="toast toast-animate text-bg-danger border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-times-circle me-1"></i>
                    {{ session('account_error') }}
                </div>
                <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        @endif

    </div>


    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const userMenu = document.querySelector('.user-menu');
        const userAvatar = document.querySelector('.user-avatar');
        const bell = document.querySelector('.notification-bell');
        const notif_modal = document.getElementById('notifModal');
        const closeBtn = document.getElementById('closeNotif');
        const badge = document.getElementById('notifBadge');
        const notifItems = document.querySelectorAll('.notif-item');
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');

        const btnDesktop = document.getElementById('btnEditAccount');
        const btnMobile = document.getElementById('btnEditAccountMobile');
        const fields = ['name', 'email', 'company_name', 'phone'];
        const saveBtn = document.getElementById('btnSaveAccount');
        const toastElList = document.querySelectorAll('.toast');
        const activeModule = document.body.dataset.activeModule;

        let activeMenuItem;

        function activateMenuFromServer() {
            if (!activeModule) return;

            // RESET SEMUA DULU
            resetAllActiveStates();

            // ===== DASHBOARD =====
            if (activeModule === 'dashboard') {
                const dashboardLink = document.getElementById('dashboardLink');
                if (dashboardLink) {
                    dashboardLink.classList.add('dashboard-active', 'active');
                }
                return;
            }

            // ===== SUBMENU =====
            const submenuItem = document.querySelector(
                `.submenu-item[href$="/${activeModule}"]`
            );

            if (submenuItem) {
                activateSubmenuItem(submenuItem);
            }
        }

        // Fungsi untuk reset semua active states
        function resetAllActiveStates() {
            document.querySelectorAll('.nav-link.active, .nav-link.dashboard-active').forEach(link => {
                link.classList.remove('active', 'dashboard-active');
            });

            document.querySelectorAll('.menu-parent').forEach(parent => {
                parent.classList.remove('active');
            });
        }

        // Fungsi untuk menutup semua submenu dengan animasi
        function closeAllSubmenusWithAnimation() {
            document.querySelectorAll('.submenu.show').forEach(submenu => {
                // Tambahkan animasi penutupan
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                // Trigger reflow
                void submenu.offsetHeight;

                submenu.classList.remove('show');

                // Setelah animasi selesai, reset max-height
                setTimeout(() => {
                    submenu.style.maxHeight = '';
                }, 400);
            });

            // Reset semua panah toggle dengan animasi
            document.querySelectorAll('.menu-toggle.rotated').forEach(toggle => {
                toggle.classList.remove('rotated');
            });
        }

        // Fungsi untuk mengaktifkan submenu item
        function activateSubmenuItem(item) {
            // Reset semua active states
            resetAllActiveStates();

            // Dapatkan parent menu
            const parentMenuName = item.getAttribute('data-parent');
            const parentMenu = document.querySelector(`.menu-parent[data-menu="${parentMenuName}"]`);

            if (parentMenu) {
                // Aktifkan parent menu dengan animasi
                parentMenu.classList.add('active');

                // Buka submenu dengan animasi
                const submenu = parentMenu.parentElement.querySelector('.submenu');
                const toggleIcon = parentMenu.querySelector('.menu-toggle');

                if (submenu && !submenu.classList.contains('show')) {
                    submenu.classList.add('show');
                    toggleIcon.classList.add('rotated');
                }
            }

            // Aktifkan item submenu dengan animasi
            item.classList.add('active');
            activeMenuItem = item.getAttribute('data-parent') + '-' + item.textContent.trim().toLowerCase().replace(/\s+/g, '-');
        }

        // Fungsi untuk toggle submenu dengan animasi smooth
        function toggleSubmenuWithAnimation(parentMenu) {
            const currentSubmenu = parentMenu.parentElement.querySelector('.submenu');
            const currentToggle = parentMenu.querySelector('.menu-toggle');

            if (!currentSubmenu) return;

            const isOpen = currentSubmenu.classList.contains('show');

            // === TUTUP SEMUA SUBMENU LAIN ===
            document.querySelectorAll('.submenu.show').forEach(submenu => {
                if (submenu !== currentSubmenu) {
                    const otherParent = submenu.closest('.menu-item')?.querySelector('.menu-parent');
                    const otherToggle = otherParent?.querySelector('.menu-toggle');

                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    void submenu.offsetHeight;

                    submenu.classList.remove('show');
                    otherToggle?.classList.remove('rotated');

                    setTimeout(() => {
                        submenu.style.maxHeight = '';
                    }, 400);
                }
            });

            // === TOGGLE SUBMENU YANG DIKLIK ===
            if (isOpen) {
                // TUTUP
                currentSubmenu.style.maxHeight = currentSubmenu.scrollHeight + 'px';
                void currentSubmenu.offsetHeight;

                currentSubmenu.classList.remove('show');
                currentToggle.classList.remove('rotated');

                setTimeout(() => {
                    currentSubmenu.style.maxHeight = '';
                }, 400);
            } else {
                // BUKA
                currentSubmenu.classList.add('show');
                currentToggle.classList.add('rotated');

                currentSubmenu.style.maxHeight = currentSubmenu.scrollHeight + 'px';

                setTimeout(() => {
                    currentSubmenu.style.maxHeight = '';
                }, 400);
            }
        }


        // Toggle sidebar di mobile - muncul dari bawah
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');

            // Mencegah scroll body saat sidebar terbuka
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        });

        // Tutup sidebar saat klik overlay
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
            this.classList.remove('show');
            document.body.style.overflow = '';
        });

        // Event untuk dashboard link
        document.getElementById('dashboardLink').addEventListener('click', function(e) {

            // Di mobile, tutup sidebar setelah memilih dashboard
            if (window.innerWidth <= 992) {
                setTimeout(() => {
                    document.getElementById('sidebar').classList.remove('show');
                    document.getElementById('overlay').classList.remove('show');
                    document.body.style.overflow = '';
                }, 300);
            }
        });

        // Toggle submenu untuk menu parent
        document.querySelectorAll('.menu-parent').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                toggleSubmenuWithAnimation(this);
            });
        });

        // Event untuk item submenu
        document.querySelectorAll('.submenu-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();

                // Di mobile, tutup sidebar setelah memilih submenu
                if (window.innerWidth <= 992) {
                    setTimeout(() => {
                        document.getElementById('sidebar').classList.remove('show');
                        document.getElementById('overlay').classList.remove('show');
                        document.body.style.overflow = '';
                    }, 300);
                }
            });
        });

        document.querySelectorAll('.logoutBtn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                let timerInterval;

                Swal.fire({
                    title: 'Konfirmasi Logout',
                    html: 'Anda akan keluar dalam <b></b> detik',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Logout Sekarang',
                    cancelButtonText: 'Batal',
                    timer: 5000,
                    timerProgressBar: true,

                    customClass: {
                        popup: 'swal-logout-popup',
                        title: 'swal-logout-title',
                        htmlContainer: 'swal-logout-text',
                        confirmButton: 'swal-logout-confirm',
                        cancelButton: 'swal-logout-cancel'
                    },

                    didOpen: () => {
                        const timer = Swal.getPopup().querySelector('b');
                        timerInterval = setInterval(() => {
                            timer.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }

                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        btn.closest('form').submit();
                    }
                });
            });
        });

        bell.addEventListener('click', () => {
            notif_modal.style.display = 'block';
        });

        closeBtn.addEventListener('click', () => {
            notif_modal.style.display = 'none';
        });

        notif_modal.querySelector('.notif-backdrop').addEventListener('click', () => {
            notif_modal.style.display = 'none';
        });

        // User avatar
        userAvatar.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        // Klik di luar → dropdown menutup
        document.addEventListener('click', function() {
            userMenu.classList.remove('active');
        });

        // Tutup sidebar saat resize window jika di desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                document.getElementById('sidebar').classList.remove('show');
                document.getElementById('overlay').classList.remove('show');
                document.body.style.overflow = '';
            }
        });

        // Swipe untuk menutup sidebar di mobile
        let startY = 0;
        let currentY = 0;
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        sidebar.addEventListener('touchstart', function(e) {
            startY = e.touches[0].clientY;
        }, {
            passive: true
        });

        sidebar.addEventListener('touchmove', function(e) {
            currentY = e.touches[0].clientY;
            const diff = currentY - startY;

            // Hanya izinkan swipe ke bawah jika sidebar terbuka dan user swipe di bagian atas
            if (diff > 0 && e.touches[0].clientY < 100) {
                e.preventDefault();
                const translateY = Math.min(diff, 100);
                sidebar.style.transform = `translateY(${translateY}px)`;
            }
        }, {
            passive: false
        });

        sidebar.addEventListener('touchend', function(e) {
            const diff = currentY - startY;

            // Jika swipe ke bawah lebih dari 50px, tutup sidebar
            if (diff > 50) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Reset transform
            sidebar.style.transform = '';
        });

        // Set dashboard sebagai aktif saat halaman dimuat
        window.addEventListener('DOMContentLoaded', function() {
            activateMenuFromServer();
            const toastElList = document.querySelectorAll('.toast');

            toastElList.forEach(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 5000,
                    autohide: true
                });

                toast.show();
            });
        });

        // Efek hover untuk card dashboard
        document.querySelectorAll('.dashboard-card-highlight').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
                this.style.boxShadow = '0 12px 20px rgba(0, 0, 0, 0.1)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.05)';
            });
        });

        function csrfFetch(url, options = {}) {
            return fetch(url, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    ...(options.headers || {})
                },
                credentials: 'same-origin',
                ...options
            });
        }

        function updateBadge() {
            const unread = document.querySelectorAll('.notif-item.unread').length;
            badge.textContent = unread;
            badge.style.display = unread > 0 ? 'inline-block' : 'none';
        }

        function checkEmptyState() {
            const notifBody = document.querySelector('.notif-body');
            const items = notifBody.querySelectorAll('.notif-item');

            if (items.length === 0) {

                // jika empty belum ada → buat
                if (!notifBody.querySelector('.notif-empty')) {
                    const empty = document.createElement('div');
                    empty.className = 'notif-empty';
                    empty.textContent = 'Tidak ada notifikasi';
                    notifBody.appendChild(empty);
                }

            } else {
                // jika masih ada notif → hapus empty
                const empty = notifBody.querySelector('.notif-empty');
                if (empty) empty.remove();
            }
        }

        updateBadge();

        document.querySelectorAll('.notif-item').forEach(item => {

            let startX = 0;
            let currentX = 0;
            let isDragging = false;

            const threshold = 80;

            /* ========== TOUCH (MOBILE) ========== */
            item.addEventListener('touchstart', e => {
                startX = e.touches[0].clientX;
                isDragging = true;
            });

            item.addEventListener('touchmove', e => {
                if (!isDragging) return;
                currentX = e.touches[0].clientX - startX;
                handleMove(item, currentX);
            });

            item.addEventListener('touchend', () => {
                handleEnd(item, currentX);
                reset(item);
            });

            /* ========== MOUSE (DESKTOP) ========== */
            item.addEventListener('mousedown', e => {
                startX = e.clientX;
                isDragging = true;
                item.style.transition = 'none';
            });

            document.addEventListener('mousemove', e => {
                if (!isDragging) return;
                currentX = e.clientX - startX;
                handleMove(item, currentX);
            });

            document.addEventListener('mouseup', () => {
                if (!isDragging) return;
                handleEnd(item, currentX);
                reset(item);
                isDragging = false;
            });

            /* ========== CLICK (NORMAL) ========== */
            item.addEventListener('click', () => {
                if (Math.abs(currentX) < 10 && item.classList.contains('unread')) {

                    const id = item.dataset.id;

                    csrfFetch(`/notifications/${id}/read`, {
                        method: 'POST'
                    });

                    item.classList.remove('unread');
                    updateBadge();
                }
            });
        });

        /* ================= HELPERS ================= */

        function handleMove(item, diff) {
            item.style.transform = `translateX(${diff}px)`;

            if (diff > 60) {
                item.classList.add('swipe-right');
                item.classList.remove('swipe-left');
            } else if (diff < -60) {
                item.classList.add('swipe-left');
                item.classList.remove('swipe-right');
            } else {
                item.classList.remove('swipe-left', 'swipe-right');
            }
        }

        function handleEnd(item, diff) {

            const id = item.dataset.id;

            /* ================= SWIPE KANAN → READ ================= */
            if (diff > 80 && item.classList.contains('unread')) {

                csrfFetch(`/notifications/${id}/read`, {
                    method: 'POST'
                });

                item.classList.remove('unread');
                updateBadge();
            }

            /* ================= SWIPE KIRI → DELETE ================= */
            if (diff < -80) {

                csrfFetch(`/notifications/${id}`, {
                    method: 'DELETE'
                });

                item.style.transition = 'all 0.25s ease';
                item.style.opacity = '0';
                item.style.height = '0';
                item.style.margin = '0';

                setTimeout(() => {
                    item.remove();
                    updateBadge();
                    checkEmptyState();
                }, 100);
            }
        }

        function reset(item) {
            item.style.transition = 'transform 0.25s ease';
            item.style.transform = 'translateX(0)';
            item.classList.remove('swipe-left', 'swipe-right');
        }

        function checkFormChanged() {
            let changed = false;

            fields.forEach(field => {
                const current = document.getElementById(field)?.value ?? '';
                const original = document.getElementById('original_' + field)?.value ?? '';

                if (current !== original) {
                    changed = true;
                }
            });

            saveBtn.disabled = !changed;
        }

        fields.forEach(field => {
            document.getElementById(field)?.addEventListener('input', checkFormChanged);
        });

        // Saat masuk edit mode, cek ulang
        function enterEditMode() {
            checkFormChanged();
        }

        let isEditMode = false; // 🔑 SATU SUMBER KEBENARAN

        function updateUI() {
            viewMode.classList.toggle('d-none', isEditMode);
            editMode.classList.toggle('d-none', !isEditMode);

            // Desktop button (icon + text)
            if (btnDesktop) {
                btnDesktop.innerHTML = isEditMode ?
                    '<i class="fas fa-eye me-1"></i><span>View</span>' :
                    '<i class="fas fa-edit me-1"></i><span>Edit</span>';
            }

            // Mobile button (icon only)
            if (btnMobile) {
                btnMobile.innerHTML = isEditMode ?
                    '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-edit"></i>';
            }
        }

        function toggleEditMode() {
            isEditMode = !isEditMode;
            updateUI();

            if (isEditMode) {
                enterEditMode();
            }
        }

        btnDesktop?.addEventListener('click', toggleEditMode);
        btnMobile?.addEventListener('click', toggleEditMode);
    </script>
</body>

</html>