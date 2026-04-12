<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Curhat Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 575px) {
            .navbar-text { font-size: 0.85rem; }
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#34495e;">
        <div class="container">

            <span class="navbar-brand fw-bold">
                Cek Curhat Siswa
            </span>

            <div>
                <span class="text-white me-3">
                    Login sebagai : <b>{{ Auth::user()->role }}</b>
                </span>

                <a href="/logout" class="btn btn-light btn-sm">
                    Logout
                </a>
            </div>

        </div>
    </nav>

    <div class="container mt-3 mt-md-4">
        <!-- Info Kode Curhat -->
        <div class="card mb-4 shadow">
            <div class="card-body">
                <h5>Kode Unik: <b>{{ $curhat->kode_unik }}</b></h5>
                <p class="text-wrap" style="max-width:100%;">
                    <strong>Pesan Siswa:</strong> {{ $curhat->pesan }}
                </p>
                <p>
                    <strong>Kategori:</strong> {{ $curhat->kategori }} <br>
                    <strong>Status:</strong>
                    @if($curhat->status == 'menunggu')
                    <span class="badge bg-warning text-dark">Menunggu</span>
                    @else
                    <span class="badge bg-success">Dibalas</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Form Balas Curhat -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <h5>Balas Curhat</h5>
                <form action="/balas/{{ $curhat->id }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="balasan" class="form-control text-wrap" rows="4" placeholder="Tulis balasan guru..." required>{{ $curhat->balasan }}</textarea>
                    </div>
                    <button class="btn btn-primary">Kirim Balasan</button>
                </form>
            </div>
        </div>

    </div>

    <!-- Tombol kembali ke dashboard -->
    <div class="container mt-4 mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <a href="/dashboard" class="btn btn-secondary w-100">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>