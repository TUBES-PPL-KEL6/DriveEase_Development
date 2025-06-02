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
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Nunito Sans', 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            scroll-behavior: smooth;
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #0d6efd !important;
        }

        .nav-link {
            color: #495057;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #0d6efd;
        }

        .navbar.scrolled {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        /* Tombol Utama (Primary Button) */
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            transform: translateY(-2px);
        }

        .btn-secondary-custom {
            /* Tombol sekunder custom */
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-2px);
        }


        /* Hero Section */
        .hero {
            /* Overlay digelapkan untuk kontras dengan teks putih */
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.45)), url('https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=1470&q=80') no-repeat center center/cover;
            min-height: 90vh;
            display: flex;
            align-items: center;
            text-align: left;
            padding-top: 80px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            color: #FFFFFF;
            /* DIUBAH menjadi PUTIH */
            line-height: 1.2;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            /* Ditambahkan text-shadow agar lebih terbaca */
        }

        .hero .brand-accent {
            color: #00ffae;
            /* Menggunakan warna aksen hijau neon Anda agar menonjol dengan teks putih */
            /* text-shadow: 0 0 10px rgba(0,255,174,0.6); /* Efek shadow neon jika diinginkan */
        }

        .hero p.lead {
            font-size: 1.25rem;
            color: #e9ecef;
            /* DIUBAH menjadi PUTIH KEABUAN (Off-white) */
            max-width: 600px;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
            /* Ditambahkan text-shadow tipis */
        }

        /* Tombol di hero akan menggunakan style default .btn-primary dan .btn-outline-primary,
           Bootstrap secara default akan membuat teks .btn-outline-primary sesuai dengan warna primarynya.
           Kita bisa override jika ingin teksnya putih: */
        .hero .btn-outline-primary {
            color: #FFFFFF;
            /* Teks putih untuk tombol outline di hero */
            border-color: #FFFFFF;
            /* Border putih */
        }

        .hero .btn-outline-primary:hover {
            background-color: #FFFFFF;
            color: #0d6efd;
            /* Teks biru saat hover */
        }

        .hero .btn-explore {
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
        }


        /* Section Titles */
        section {
            padding: 60px 0;
        }

        section h2.section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }

        section h2.section-title::after {
            content: '';
            position: absolute;
            display: block;
            width: 60px;
            height: 4px;
            background: #0d6efd;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }


        /* Feature Box */
        .feature-box {
            background-color: #ffffff;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease-in-out;
            height: 100%;
        }

        .feature-box:hover {
            transform: translateY(-8px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.12);
        }

        .feature-box .icon {
            /* Pastikan ada class .icon pada <i> Anda */
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .feature-box h4 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        .feature-box p {
            color: #6c757d;
            font-size: 0.95rem;
        }


        /* Testimonial Section */
        #testimonials {
            /* Nama ID yang benar adalah testimonials, bukan testimoni */
            background-color: #e9ecef;
        }

        .testimonial-card {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.07);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .testimonial-card p.quote {
            font-style: italic;
            color: #495057;
            margin-bottom: 1rem;
            flex-grow: 1;
            font-size: 1rem;
        }

        .testimonial-card .author {
            font-weight: 600;
            color: #0d6efd;
            font-size: 0.9rem;
        }

        .testimonial-card .location {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* CTA Section (pada kode HTML Anda classnya "bg-gradient-to-r from-blue-600 to-indigo-600 text-white") */
        /* Tidak perlu style tambahan jika sudah pakai kelas Bootstrap/utility, kecuali ingin override */
        /* Contoh jika ingin memastikan warna teks:
        .cta-section h2, .cta-section p.lead { color: #FFFFFF; }
        */


        /* Footer */
        footer {
            background-color: #212529;
            color: #adb5bd;
            padding: 40px 0 20px;
        }

        footer .footer-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        footer p {
            font-size: 0.9rem;
        }

        .social-icons a {
            color: #adb5bd;
            margin: 0 0.75rem;
            font-size: 1.3rem;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #0d6efd;
        }
    </style>
</head>

<body data-bs-spy="scroll" data-bs-target="#mainNavbar" data-bs-offset="80">

    {{-- Navbar --}}
    <nav id="mainNavbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">🚗 DriveEase</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent"
                aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="#hero">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Testimoni</a></li>
                    {{-- ID section diganti menjadi testimonials --}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-primary ms-lg-2 mt-2 mt-lg-0"
                            href="{{ route('register') }}">Daftar Gratis</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero" id="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right" data-aos-delay="100">
                    <h1 class="display-3 fw-bolder">Sewa Mobil Impian Anda, <br class="d-none d-md-block"> <span
                            class="brand-accent">Mudah & Aman</span> Bersama DriveEase</h1>
                    <p class="lead my-4">
                        Platform terpercaya untuk menemukan dan menyewa berbagai jenis mobil dengan proses cepat,
                        transparan, dan harga terbaik. Mulai petualangan Anda hari ini!
                    </p>
                    <a href="{{ route('register') }}"
                        class="btn btn-primary btn-lg btn-explore shadow-lg me-2 mb-2 mb-sm-0" data-aos="zoom-in"
                        data-aos-delay="300">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Daftar Sekarang
                    </a>
                    <a href="#features" class="btn btn-outline-primary btn-lg btn-explore shadow-lg mb-2 mb-sm-0"
                        data-aos="zoom-in" data-aos-delay="400">
                        <i class="bi bi-arrow-down-circle me-2"></i>Lihat Fitur
                    </a>
                </div>
                <div class="col-lg-5 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
                    {{-- Gambar hero tetap menggunakan dari CSS .hero background-image --}}
                    {{-- Jika ingin ada elemen gambar di sini, pastikan tidak bentrok dengan background section .hero --}}
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur Section --}}
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="section-title text-center" data-aos="fade-up">Kenapa Memilih DriveEase?</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-box text-center">
                        <div class="icon"><i class="bi bi-phone-vibrate-fill"></i></div>
                        <h4>Akses Mudah & Cepat</h4>
                        <p>Cari, bandingkan, dan sewa kendaraan favorit Anda langsung dari perangkat mana pun, kapan
                            pun.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-box text-center">
                        <div class="icon"><i class="bi bi-credit-card-2-front-fill"></i></div>
                        <h4>Pembayaran Digital Lengkap</h4>
                        <p>Tersedia QRIS, e-wallet, virtual account, dan transfer bank. Pilih yang paling nyaman untuk
                            Anda.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-box text-center">
                        <div class="icon"><i class="bi bi-shield-check"></i></div>
                        <h4>Transparan, Aman & Terpercaya</h4>
                        <p>Lihat review dan rating dari pengguna lain. Semua transaksi diverifikasi untuk keamanan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonial Section --}}
    <section id="testimonials" class="py-5"> {{-- ID section diganti menjadi testimonials --}}
        <div class="container">
            <h2 class="section-title text-center" data-aos="fade-up">Apa Kata Pelanggan Kami?</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="testimonial-card">
                        <p class="quote">“DriveEase benar-benar game-changer! Proses sewa mobil jadi super mudah dan
                            cepat. Website-nya intuitif banget, pilihan mobilnya juga banyak. Highly recommended!”</p>
                        <div class="mt-auto text-end">
                            <div class="author">Alya Fitriani</div>
                            <div class="location">Mahasiswa, Jakarta</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <p class="quote">“Awalnya ragu sewa mobil online, tapi DriveEase membuktikan keamanannya.
                            Konfirmasi instan, mobil sesuai deskripsi. Liburan keluarga jadi makin seru!”</p>
                        <div class="mt-auto text-end">
                            <div class="author">Budi Santoso</div>
                            <div class="location">Wiraswasta, Bandung</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" data-aos="fade-left" data-aos-delay="300">
                    <div class="testimonial-card">
                        <p class="quote">“Pembayaran pakai QRIS praktis banget! Gak perlu ribet transfer manual lagi.
                            Customer servicenya juga responsif. Pasti bakal sewa di sini lagi.”</p>
                        <div class="mt-auto text-end">
                            <div class="author">Rizky Pratama</div>
                            <div class="location">Fotografer, Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    {{-- Pada HTML Anda, section ini menggunakan class "bg-gradient-to-r from-blue-600 to-indigo-600 text-white" 
     yang merupakan kelas Tailwind. Jika Anda menggunakan Bootstrap murni, Anda perlu style manual atau pakai class Bootstrap.
     Saya akan asumsikan Anda ingin tetap dengan gaya itu, tapi jika tidak, bisa diubah ke style Bootstrap.
--}}
    <section class="py-5 text-center text-white"
        style="background-image: linear-gradient(to right, var(--bs-primary), var(--bs-indigo));" data-aos="zoom-in">
        <div class="container">
            <h2 class="display-5 fw-bold mb-3">Siap Memulai Perjalanan Anda?</h2>
            <p class="lead mb-4 mx-auto" style="max-width: 600px;">
                Jangan tunda lagi! Temukan kendaraan yang sempurna untuk petualangan atau kebutuhan bisnis Anda
                berikutnya dengan DriveEase.
            </p>
            <a href="{{ route('register') }}"
                class="btn btn-light btn-lg shadow-lg me-2 transform hover:scale-105 transition-transform">
                <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
            </a>
            <a href="{{ route('vehicles.index') }}"
                class="btn btn-outline-light btn-lg shadow-lg transform hover:scale-105 transition-transform">
                <i class="bi bi-search me-2"></i> Cari Mobil
            </a>
        </div>
    </section>

    {{-- JS Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });

        const navbar = document.getElementById('mainNavbar');
        if (navbar) {
            window.onscroll = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            };
        }

        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>

</body>

</html>
