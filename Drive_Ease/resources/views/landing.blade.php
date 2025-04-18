<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>DriveEase - Sewa Mobil Mudah dan Aman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- AOS CSS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #0d1117;
            color: #ffffff;
            scroll-behavior: smooth;
        }

        nav {
            background-color: #0d1117 !important;
        }

        .hero {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1605384721378-7d75f8130d5e?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #00b894;
            border: none;
        }

        .feature-box {
            background-color: #1c1c2e;
            padding: 2rem;
            border-radius: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .feature-box:hover {
            transform: translateY(-5px);
            background-color: #292943;
        }

        footer {
            background-color: #0d1117;
            color: #aaa;
        }

        .social-icons a {
            color: #aaa;
            margin: 0 0.5rem;
            font-size: 1.5rem;
            transition: 0.3s;
        }

        .social-icons a:hover {
            color: #00b894;
        }
    </style>
</head>
<body>

{{-- Navbar --}}
<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="#">🚗 DriveEase</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimoni">Testimoni</a></li>
                <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                <li class="nav-item"><a class="btn btn-primary ms-2" href="/register">Daftar</a></li>
            </ul>
        </div>
    </div>
</nav>

{{-- Hero --}}
<section class="hero text-white" id="home">
    <div class="container">
        <h1 data-aos="fade-down">Selamat Datang di DriveEase</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="200">Sewa kendaraan tanpa ribet, cukup dari genggamanmu.</p>
        <a href="#features" class="btn btn-primary btn-lg mt-3" data-aos="zoom-in" data-aos-delay="400">Jelajahi Fitur</a>
    </div>
</section>

{{-- Fitur --}}
<section class="py-5" id="features">
    <div class="container">
        <h2 class="text-center mb-4" data-aos="fade-up">Kenapa Memilih DriveEase?</h2>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box text-center">
                    <h4>Akses Mudah</h4>
                    <p>Cari & sewa kendaraan langsung dari browser.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box text-center">
                    <h4>Pembayaran Digital</h4>
                    <p>QRIS, e-wallet, atau transfer bank. Pilih sesuai kenyamananmu.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box text-center">
                    <h4>Transparan & Aman</h4>
                    <p>Review, rating, dan verifikasi langsung di sistem.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Testimoni --}}
<section class="py-5 bg-dark" id="testimoni">
    <div class="container">
        <h2 class="text-center mb-4" data-aos="fade-up">Apa Kata Mereka?</h2>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-right">
                <div class="p-4 bg-secondary rounded">
                    <p>“DriveEase bener-bener menyelamatkan waktu saya saat urgent butuh mobil. Website-nya gampang banget dipakai!”</p>
                    <h6 class="text-muted">— Fajar, Jakarta</h6>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up">
                <div class="p-4 bg-secondary rounded">
                    <p>“Baru pertama coba, tapi sistem pemesanan dan konfirmasinya cepet. Recommended banget!”</p>
                    <h6 class="text-muted">— Nanda, Bandung</h6>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-left">
                <div class="p-4 bg-secondary rounded">
                    <p>“Bayar pake e-wallet langsung masuk, tanpa nunggu lama. Saya kasih bintang 5!”</p>
                    <h6 class="text-muted">— Dimas, Surabaya</h6>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="pt-4 pb-2">
    <div class="container text-center">
        <p class="mb-1">© 2025 DriveEase. All rights reserved.</p>
        <div class="social-icons mt-2">
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
        </div>
    </div>
</footer>

{{-- JS Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
</html>