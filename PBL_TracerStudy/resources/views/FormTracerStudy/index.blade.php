<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Tracer Study</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-green: #13754C;
            --secondary-green: #13754C;
            --accent-yellow: #F7DC6F;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }

        .header-section {
            background-color: var(--primary-green);
            color: white;
            padding: 3rem 2rem;
            position: relative;
        }

        .ts-logo {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-text {
            font-size: 1rem;
            font-weight: normal;
            margin-left: 0.2rem;
            vertical-align: middle;
        }

        .welcome-text {
            font-size: 3rem;
            font-weight: bold;
            line-height: 1.3;
            margin-bottom: 1.5rem;
        }

        .btn-fill-form {
            background-color: var(--accent-yellow);
            color: #000;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 5px;
        }

        .btn-fill-form:hover {
            background-color: #e0a800;
            color: #000;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .mechanism-item {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .mechanism-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .mechanism-text {
            font-size: 0.9rem;
        }

        /* Menambahkan margin pada setiap elemen mekanisme untuk memastikan jarak antar elemen */
        .mechanism-item1 {
            margin: 0 120px 40px 0px;
            /* 30px horizontal gap dan 40px vertical gap */
            text-align: center;
        }

        .mechanism-item2 {
            margin: 0 0px 40px 120px;
            /* 30px horizontal gap dan 40px vertical gap */
            text-align: center;
        }

        /* Menambahkan gap yang lebih besar dalam flex container */
        .d-flex {
            display: flex;
            gap: 50px;
            /* Gap antar elemen lebih besar */
        }

        .d-flex.justify-content-center {
            justify-content: center;
            flex-wrap: wrap;
            /* Membungkus elemen secara otomatis pada ukuran layar lebih kecil */
            gap: 50px;
            /* Mengatur jarak antar elemen */
        }

        .benefits-section {
            background-color: #f8f9fa;
            padding: 2rem;
            margin-top: 2rem;
        }

        .benefits-text {
            font-size: 1rem;
            line-height: 1.6;
        }

        .cta-section {
            background-color: var(--primary-green);
            color: white;
            padding: 2rem;
            text-align: center;
            margin-top: 2rem;
        }

        .cta-text {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .university-logo {
            max-width: 100px;
            margin-bottom: 1rem;
        }

        .copyright {
            background-color: var(--accent-yellow);
            color: #000;
            padding: 0.5rem;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .illustration-container {
            text-align: center;
            margin: 2rem 0;
        }

        .illustration-img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .welcome-text {
                font-size: 1.5rem;
            }

            .mechanism-container {
                flex-direction: column;
            }
        }

        .footer {
            background-color: var(--primary-green);
            color: white;
            padding: 1rem 0;
        }

        .footer a {
            color: white;
            text-decoration: underline;
        }

        .footer h5 {
            font-size: 1.1rem;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <!-- Header Section -->
        <section class="header-section">
            <div class="container">
                <div class="row align-items-center" style="min-height: 500px;">
                    <!-- Kolom Gambar -->
                    <div class="col-md-6 position-relative">
                        <img src="{{ asset('landingpageimg/52b023a5-c751-4b7e-bdf7-e8fa378708c9-removebg-preview 1.png') }}"
                            alt="Tracer Study Illustration"
                            style="height: 500px; width: 100%; object-fit: contain; margin-bottom: 50px;">
                    </div>

                    <!-- Kolom Tulisan -->
                    <div class="col-md-6 text-white">
                        <h1 class="welcome-text mt-4 mb-4">Selamat Datang di Sistem<br>Tracer Study</h1>
                        <a href="{{ route('form.opsi') }}" class="btn btn-fill-form mb-5">Isi Formulir</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- What is Tracer Study Section -->
        <section class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="section-title" style="font-weight: bold; font-size:3rem;">Apa itu Tracer Study?</h2>
                    <p style="font-size:20px;">
                        Tracer Study adalah survei yang dilakukan oleh institusi pendidikan, seperti perguruan tinggi
                        kepada para lulusan (alumni) untuk mengetahui jejak karier mereka, aktivitas pekerjaan setelah
                        lulus, serta sejauh mana pendidikan yang telah diterima selaras dengan dunia kerja.
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('landingpageimg/Workflow visualization with kanban board.png') }}"
                        alt="Tracer Study Illustration" style="max-width: 80%; height: auto;">
                </div>
            </div>
        </section>

        <!-- ... (sebelumnya tetap sama sampai bagian Mekanisme) -->

        <!-- Mechanism Section -->
        <section class="container mt-5">
            <h2 class="section-title text-left mb-4" style="font-weight: bold; font-size:2rem;">Mekanisme Tracer Study
            </h2>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <!-- Baris pertama: Step 1 dan 2 -->
                    <div class="d-flex justify-content-center flex-wrap" style="gap: 50px;">
                        <!-- Step 1 -->
                        <div class="mechanism-item1 text-center" style="width: 300px; margin-bottom: 50px;">
                            <img src="{{ asset('landingpageimg/Online survey on tablet screen.png') }}" alt="Form Icon"
                                style="width: 100px; height: auto;">
                            <p style="font-size: 14px; margin-top: 10px;">1. Alumni mengisi form Tracer Study</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="mechanism-item1 text-center" style="width: 300px; margin-bottom: 50px;">
                            <img src="{{ asset('landingpageimg/spam email.png') }}" alt="Email Icon"
                                style="width: 100px; height: auto;">
                            <p style="font-size: 14px; margin-top: 10px;">2. Pengguna lulusan akan menerima email</p>
                        </div>
                    </div>

                    <!-- Baris kedua: Step 3 dan 4 -->
                    <div class="d-flex justify-content-center flex-wrap" style="gap: 50px;">
                        <!-- Step 3 -->
                        <div class="mechanism-item2 text-center" style="width: 300px; margin-bottom: 50px;">
                            <img src="{{ asset('landingpageimg/documents.png') }}" alt="Survey Icon"
                                style="width: 100px; height: auto;">
                            <p style="font-size: 14px; margin-top: 10px;">3. Pengguna lulusan mengisi survey penilaian
                                kinerja alumni</p>
                        </div>

                        <!-- Step 4 -->
                        <div class="mechanism-item2 text-center" style="width: 300px; margin-bottom: 50px;">
                            <img src="{{ asset('landingpageimg/pie chart.png') }}" alt="Data Icon"
                                style="width: 100px; height: auto;">
                            <p style="font-size: 14px; margin-top: 10px;">4. Data akan dikelola untuk evaluasi &
                                peningkatan kualitas pendidikan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Manfaat Section -->
        <section class="container mt-5 text-center">
            <h2 class="section-title mb-3" style="font-size:2rem;">Manfaat Tracer Study</h2>
            <p style="max-width: 1000px; margin: 0 auto; line-height: 1.8;">
                Tracer Study adalah jembatan antara kampus dan para alumninya. Melalui survei ini, kampus dapat
                melacak bagaimana perjalanan karier lulusan setelah menyelesaikan pendidikan. Lebih dari sekadar
                formalitas, Tracer Study menjadi alat penting untuk mengevaluasi kualitas pendidikan, memperbaiki
                kurikulum, dan memastikan bahwa apa yang diajarkan benar-benar relevan dengan kebutuhan dunia kerja.
            </p>
        </section>
        <!-- CTA Section -->
        <section
            style="background-color: #13754C;
           color: white;
           padding: 60px 0 40px 0;
           margin-top: 60px;
           position: relative;
           overflow: hidden;
           clip-path: polygon(0 0, 100% 20%, 100% 100%, 0 100%);">
            <div class="container text-center">
                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-5 mb-4">
                    <h2 style="font-size: 2rem; font-weight: bold; margin: 0;">
                        Partisipasi anda penting untuk<br>kemajuan pendidikan tinggi
                    </h2>
                    <a href="{{ route('form.opsi') }}" class="btn"
                        style="background-color: #F7DC6F; color: #000; font-weight: 600; padding: 10px 30px; border-radius: 5px; font-size: 16px;">
                        Isi Formulir
                    </a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer style="background-color: #13754C; color: white; padding: 0 0 00px 0;">
            <div class="container">
                <div class="row py-4">
                    <!-- Logo dan Judul -->
                    <div class="col-md-4 mb-4">
                        <div class="d-flex align-items-center mb-3" style="gap: 10px; margin: 0; padding: 0;">
                            <img src="{{ asset('landingpageimg/3186eafb-bdc8-461c-93ef-b3ac617a517c 3.png') }}"
                                alt="Politeknik Negeri Malang Logo" style="width: 90px; height: 90px;">
                            <div>
                                <div class="fw-bold" style="font-size: 18px;">Tracer Study</div>
                                <div>Politeknik Negeri Malang</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div class="col-md-4 mb-4">
                        <h5 class="mb-3" style="font-weight: bold;">Kontak Kami</h5>
                        <p class="mb-1">Politeknik Negeri Malang, Jl. Soekarno Hatta</p>
                        <p class="mb-1">No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang</p>
                        <p class="mb-1">(0341) 404424 / 404425</p>
                        <p class="mb-0">humas@polinema.ac.id</p>
                    </div>

                    <!-- Berita -->
                    <div class="col-md-4 mb-4">
                        <h5 class="mb-3" style="font-weight: bold;">Berita Terbaru</h5>
                        <p>
                            Anda dapat mengakses berita terbaru mengenai Polinema
                            <a href="https://www.polinema.ac.id/" class="text-white"
                                style="text-decoration: underline;">
                                disini
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-3" style="background-color: #F7DC6F; color: black; padding: 10px 0;">
                © 2025 Politeknik Negeri Malang. All Rights Reserved.
            </div>
        </footer>

        <!-- jQuery and Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                // Smooth scrolling for anchor links
                $('a[href^="#"]').on('click', function(event) {
                    event.preventDefault();

                    $('html, body').animate({
                        scrollTop: $($.attr(this, 'href')).offset().top
                    }, 800);
                });
            });
        </script>
</body>

</html>
