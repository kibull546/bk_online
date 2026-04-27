<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin BK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .navbar {
            background: #34495e;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .btn-lg-custom {
            padding: 14px;
            border-radius: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container">

        <span class="navbar-brand fw-bold">
            Dashboard Admin BK
        </span>

        <div>
            <span class="text-white me-3">
                Login sebagai: <b>{{ Auth::user()->role }}</b>
            </span>

            <a href="/logout-admin" class="btn btn-light btn-sm">
                Logout
            </a>
        </div>

    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <!-- CARD ACTION -->
    <div class="row g-3">

        <!-- IMPORT SISWA -->
        <div class="col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <h5 class="fw-bold">Import Siswa</h5>
                <p class="text-muted">Upload data siswa dari file Excel</p>
                <a href="/admin/import-students" class="btn btn-primary btn-lg-custom w-100">
                    📥 Import Excel
                </a>
            </div>
        </div>

        <!-- BUAT GURU -->
        <div class="col-md-6">
            <div class="card card-custom p-4 text-center h-100">
                <h5 class="fw-bold">Akun Guru</h5>
                <p class="text-muted">Buat akun guru BK baru untuk sistem</p>
                <a href="/admin/create-guru" class="btn btn-success btn-lg-custom w-100">
                    👨‍🏫 Buat Akun Guru
                </a>
            </div>
        </div>

    </div>

    <!-- BACK BUTTON -->
    <div class="text-center mt-4">
        <a href="/" class="btn btn-secondary">
            Kembali ke Beranda
        </a>
    </div>

</div>

</body>
</html>