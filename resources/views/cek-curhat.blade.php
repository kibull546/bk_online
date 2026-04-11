<!DOCTYPE html>
<html>

<head>
    <title>Cek Curhat Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="container mt-4">

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
    <div class="text-center mt-4">
        <a href="/dashboard" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>