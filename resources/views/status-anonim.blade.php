<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive { overflow-x: auto; }
        td.pesan, td.balasan { white-space: pre-wrap; word-break: break-word; }
        .badge { font-size: 0.85rem; }
        .text-muted { font-style: italic; }
        @media (max-width: 768px) {
            .table { font-size: 0.8rem; }
            td.pesan, td.balasan { max-width: 150px; }
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-3 mt-md-5">
    <!-- Header -->
    <div class="card shadow p-3 p-md-4 text-center mb-4">
        <h2>Status Curhat Anda</h2>
        <a href="/" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
    </div>
    <!-- Tabel Curhat dengan scroll horizontal -->
    <div class="card shadow border-0">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle table-sm">
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