<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive { overflow-x: auto; }
        .col-pesan { word-break: break-word; }
        .col-balasan { word-break: break-word; }
        @media (max-width: 768px) {
            .table { font-size: 0.8rem; }
            .btn-sm { padding: 0.25rem 0.5rem; font-size: 0.65rem; }
            .col-pesan, .col-balasan { max-width: 150px; }
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#34495e;">
    <div class="container">

        <span class="navbar-brand fw-bold">
            Dashboard Admin BK
        </span>

        <div>
            <span class="text-white me-3">
                Login sebagai : <b>{{ Auth::user()->role }}</b>
            </span>

            <a href="/logout-admin" class="btn btn-light btn-sm">
                Logout
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="/admin/import-students" class="btn btn-primary btn-lg">
                <i class="bi bi-upload"></i> 📥 Import Siswa dari Excel
            </a>
        </div>
    </div>

    <!-- Daftar Curhat Anonim -->
    <div class="card shadow border-0">
        <div class="card-body table-responsive">
            <h4 class="mb-4">Daftar Curhat Anonim</h4>
            <table class="table table-striped align-middle table-bordered table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kode Unik</th>
                        <th>Pesan</th>
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

                        <!-- Kolom Pesan -->
                        <td class="col-pesan text-wrap">{{ $d->pesan }}</td>

                        <td><span class="badge bg-info">{{ $d->kategori }}</span></td>
                        <td>
                            @if($d->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-success">Dibalas</span>
                            @endif
                        </td>

                        <!-- Kolom Balasan Guru -->
                        <td class="col-balasan text-wrap">
                            @if($d->balasan)
                                {{ $d->balasan }}
                            @else
                                <span class="text-muted">Belum ada balasan</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('hapus', $d->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">Hapus</button>
                            </form>
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