<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BK Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#34495e;">
    <div class="container">
        <a class="navbar-brand fw-bold">
            BK Online
            <a href="/" class="btn btn-light btn-sm">Kembali</a>
        </a>
    </div>
</nav>

    <div class="container mt-5">

        <div class="text-center mb-4">
            <h2 class="fw-bold">Curhat Anonim Siswa</h2>
            <p class="text-muted">Ceritakan masalahmu dengan aman dan anonim</p>
            <h6 class="text-danger">(INGAT ADA KODE UNIK YANG HARUS DISIMPAN, UNTUK MELIHAT STATUS CURHAT ANDA SUDAH DI BALAS ATAU BELUM!!!)</h6>
        </div>

        <!-- Form Curhat -->
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-7">

                <div class="card shadow-lg border-0">

                    <div class="card-body p-4">

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form method="POST" action="/curhat">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Masalah Kamu</label>
                                <textarea name="pesan" class="form-control" rows="4" placeholder="Tulis curhatan kamu..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="kategori" class="form-select">
                                    <option>Belajar</option>
                                    <option>Keluarga</option>
                                    <option>Pertemanan</option>
                                    <option>Pribadi</option>
                                </select>
                            </div>

                            <div class="text-center mt-4 d-grid gap-2">
                                <button class="btn btn-primary">
                                    Kirim Curhat
                                </button>
                                <a href="/" class="btn btn-secondary">
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>




    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</body>

</html>