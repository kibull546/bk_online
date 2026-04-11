<!DOCTYPE html>
<html>
<head>
    <title>Status Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Biar tabel bisa scroll horizontal */
        .table-responsive {
            overflow-x: auto;
        }
        td.pesan, td.balasan {
            white-space: pre-wrap; /* teks bisa turun tapi tetap rapi */
            word-break: break-word;
        }
        td.pesan {
            min-width: 400px; /* lebar kolom pesan */
        }
        td.balasan {
            min-width: 400px; /* lebar kolom balasan */
        }
        .badge {
            font-size: 0.85rem;
        }
        .text-muted {
            font-style: italic;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">

    <!-- Header -->
    <div class="card shadow p-4 text-center mb-4">
        <h2>Status Curhat Anda</h2>
        <a href="/" class="btn btn-secondary mt-2">Kembali ke Beranda</a>
    </div>

    <!-- Tabel Curhat dengan scroll horizontal -->
    <div class="card shadow border-0">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th class="pesan">Pesan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th class="balasan">Balasan Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $d->id }}</td>
                        <td class="pesan">{{ $d->pesan }}</td>
                        <td><span class="badge bg-info">{{ $d->kategori }}</span></td>
                        <td>
                            @if($d->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @else
                                <span class="badge bg-success">Dibalas</span>
                            @endif
                        </td>
                        <td class="balasan">
                            @if($d->balasan)
                                {{ $d->balasan }}
                            @else
                                <span class="text-muted">Belum ada balasan</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>