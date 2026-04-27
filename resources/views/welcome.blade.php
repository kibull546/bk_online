<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BK Online</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background: radial-gradient(circle at top, #e8f1ff 0%, #f7f9fc 40%, #eef2f7 100%);
            color:#2c3e50;
            overflow-x:hidden;
        }

        /* GLASS NAVBAR */
        .navbar-custom{
            background: rgba(20, 35, 55, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .navbar-brand{
            font-weight:700;
            letter-spacing:0.5px;
        }

        /* HERO */
        .hero{
            padding:90px 0;
        }

        .hero-title{
            font-size:48px;
            font-weight:800;
            line-height:1.15;
        }

        .hero-title span{
            background: linear-gradient(90deg,#4facfe,#00f2fe);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
        }

        .hero-text{
            margin-top:18px;
            color:#6c7a89;
            font-size:16px;
        }

        /* BUTTON */
        .btn-main{
            background: linear-gradient(135deg,#4facfe,#00f2fe);
            color:white;
            border-radius:14px;
            padding:12px 30px;
            border:none;
            box-shadow:0 10px 25px rgba(0,242,254,0.25);
            transition:0.3s;
        }

        .btn-main:hover{
            transform:translateY(-3px);
            box-shadow:0 15px 35px rgba(0,242,254,0.35);
        }

        /* CARDS GLASS */
        .card-custom{
            border:none;
            border-radius:22px;
            background: rgba(255,255,255,0.65);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            box-shadow:0 15px 40px rgba(0,0,0,0.06);
            transition:0.35s;
        }

        .card-custom:hover{
            transform: translateY(-10px);
            box-shadow:0 25px 60px rgba(0,0,0,0.10);
        }

        .section-title{
            font-weight:800;
            margin-bottom:35px;
        }

        /* BUTTON SOFT */
        .btn-soft{
            border-radius:12px;
            padding:10px;
            border:none;
            font-weight:500;
            transition:0.3s;
        }

        .btn-soft:hover{
            transform:scale(1.02);
        }

        .blue{background:#4facfe;color:white;}
        .green{background:#43e97b;color:white;}
        .orange{background:#f6d365;color:white;}

        /* IMAGE HERO */
        .hero-img{
            max-width:380px;
            width:100%;
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.12));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float{
            0%,100%{transform:translateY(0px);}
            50%{transform:translateY(-10px);}
        }

        footer{
            background:#0f172a;
            color:white;
            margin-top:70px;
        }
    </style>
</head>

<body>

<!-- NAV -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand">BK Online</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-md-6">
                <h1 class="hero-title">
                    Bimbingan Konseling <span>Online</span>
                </h1>

                <p class="hero-text">
                    Platform modern untuk siswa berbagi cerita dengan Guru BK secara aman, nyaman, dan anonim.
                </p>

                <a href="/student-login" class="btn btn-main mt-3">
                    Curhat Sekarang
                </a>
            </div>

            <div class="col-md-6 text-center">
                <img src="/images/guru_islam.png" class="hero-img" alt="BK">
            </div>

        </div>
    </div>
</section>

<!-- FITUR -->
<section class="container mb-5">

    <h3 class="text-center section-title">Fitur Utama</h3>

    <div class="row g-4">

        <div class="col-md-4">
            <div class="card card-custom p-4 h-100 text-center">
                <h5 class="fw-bold">Curhat Anonim</h5>
                <p class="text-muted">Siswa bisa bercerita tanpa identitas untuk kenyamanan maksimal.</p>
                <a href="/student-login" class="btn btn-soft blue w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-4 h-100 text-center">
                <h5 class="fw-bold">Konsultasi Guru BK</h5>
                <p class="text-muted">Guru memberikan solusi langsung secara real-time.</p>
                <a href="/konsultasi" class="btn btn-soft green w-100">Buka</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom p-4 h-100 text-center">
                <h5 class="fw-bold">Riwayat Chat</h5>
                <p class="text-muted">Lihat semua percakapan dengan tampilan rapi dan modern.</p>
                <a href="/riwayat-chat" class="btn btn-soft orange w-100">Buka</a>
            </div>
        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="text-center p-3">
    © 2026 BK Online • Built with modern UI
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
