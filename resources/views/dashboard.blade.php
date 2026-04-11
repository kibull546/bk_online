<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Guru BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#34495e;">
    <div class="container">

        <span class="navbar-brand fw-bold">
            Dashboard Guru BK
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

    <!-- Form cek kode unik -->
    <form action="{{ route('cek-kode') }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="text" name="kode_unik" class="form-control" placeholder="Masukkan kode unik siswa" required>
            <button class="btn btn-primary">Cek Curhat</button>
        </div>
    </form>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <h5>Total Curhat</h5>
                    <h3>{{ $total }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <h5>Sudah Dibalas</h5>
                    <h3>{{ $dibalas }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-dark shadow">
                <div class="card-body">
                    <h5>Menunggu</h5>
                    <h3>{{ $menunggu }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Curhat -->
    <div class="card shadow border-0">
        <div class="card-body">
            <h4 class="mb-4">Daftar Curhat Siswa</h4>
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kode Unik</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Balasan Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td>{{ $d->kode_unik }}</td>
                        <td>{{ $d->kategori }}</td>
                        <td>
                            @if($d->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-success">Dibalas</span>
                            @endif
                        </td>
                        <td class="text-wrap" style="max-width:300px;">
                            @if($d->balasan)
                                <div class="alert alert-success p-2 mb-0">{{ $d->balasan }}</div>
                            @else
                                <span class="text-muted">Belum ada balasan</span>
                            @endif
                        </td>
                        <td>
                            @if(Auth::user()->role == 'admin')
                                <form action="/hapus/{{ $d->id }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm w-100 mb-2">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Tombol kembali ke beranda -->
<div class="text-center mt-4">
    <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>