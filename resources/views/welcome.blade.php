<!DOCTYPE html>

<html>

<head>
    <title>BK Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!DOCTYPE html>

        
        <style>
            body {
                background: #f1f4f7;
            }

            /* NAVBAR */
            .navbar-custom {
                background: #34495e;
            }

            /* HERO */
            .hero-title {
                font-size: 40px;
            }

            /* BUTTON */
            .btn-main {
                background: #5d6d7e;
                color: white;
                border-radius: 10px;
                padding: 10px 28px;
                border: none;
            }

            .btn-main:hover {
                background: #34495e;
                color: white;
            }

            .btn-soft-blue {
                background: #85c1e9;
                color: white;
                border-radius: 10px;
                border: none;
            }

            .btn-soft-blue:hover {
                background: #5dade2;
            }

            .btn-soft-green {
                background: #82e0aa;
                color: white;
                border-radius: 10px;
                border: none;
            }

            .btn-soft-green:hover {
                background: #58d68d;
            }

            .btn-soft-orange {
                background: #f8c471;
                border-radius: 10px;
                border: none;
            }

            .btn-soft-orange:hover {
                background: #f5b041;
            }

            /* CARD */
            .card-custom {
                border-radius: 18px;
                transition: 0.25s;
            }

            .card-custom:hover {
                transform: translateY(-6px);
            }

            footer {
                background: #34495e;
                color: white;
            }
        </style>
        

    </head>

<body>

    
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold">
                BK Online
            </a>
        </div>
    </nav>

    <!-- HERO -->
    <div class="container mt-5">
        <div class="row align-items-center">

            <div class="col-md-6">
                <h1 class="fw-bold hero-title">
                    Konsultasi & Curhat BK Online
                </h1>

                <p class="text-muted mt-3">
                    Platform ini membantu siswa menyampaikan permasalahan secara anonim kepada Guru BK
                    sehingga siswa tetap merasa aman, nyaman, dan tidak malu untuk bercerita.
                </p>

                <a href="/curhat" class="btn btn-main mt-3">
                    Curhat Sekarang
                </a>
            </div>

            <div class="col-md-6 text-center">
                <img src="/images/guru_islam.png" width="340">
            </div>

        </div>
    </div>

    <!-- FITUR -->
    <div class="container mt-5 mb-5">

        <h3 class="text-center fw-bold mb-4">
            Fitur Website
        </h3>

        <div class="row g-4">

            <!-- CURHAT -->
            <div class="col-md-4">
                <div class="card card-custom shadow border-0 text-center p-4 h-100 d-flex flex-column">

                    <h5 class="fw-bold">Curhat Anonim</h5>

                    <p class="text-muted flex-grow-1 mt-2">
                        Siswa dapat mengirimkan curhatan tanpa mencantumkan identitas
                        sehingga lebih bebas dalam menyampaikan masalah.
                    </p>

                    <a href="/curhat" class="btn btn-soft-blue w-100">
                        Buka Fitur
                    </a>

                </div>
            </div>

            <!-- GURU -->
            <div class="col-md-4">
                <div class="card card-custom shadow border-0 text-center p-4 h-100 d-flex flex-column">

                    <h5 class="fw-bold">Konsultasi Guru BK</h5>

                    <p class="text-muted flex-grow-1 mt-2">
                        Guru BK dapat membaca curhatan siswa dan memberikan
                        tanggapan atau solusi secara langsung melalui sistem.
                    </p>

                    <a href="/konsultasi" class="btn btn-soft-green w-100">
                        Buka Konsultasi
                    </a>

                </div>
            </div>

            <!-- STATUS -->
            <div class="col-md-4">
                <div class="card card-custom shadow border-0 text-center p-4 h-100 d-flex flex-column">

                    <h5 class="fw-bold">Cek Status Curhat</h5>

                    <p class="text-muted flex-grow-1 mt-2">
                        Siswa dapat memasukkan kode unik yang didapat setelah
                        mengirim curhat untuk melihat apakah sudah dibalas oleh Guru BK.
                    </p>

                    <a href="/monitoring" class="btn btn-soft-orange w-100">
                        Cek Status
                    </a>

                </div>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <footer class="text-center p-3">
        Website BK Online © 2026
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    

</body>

</html>

</body>

</html>