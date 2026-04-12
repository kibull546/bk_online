<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-3 mt-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow p-3 p-md-4 text-center">
            <h2>Cek Status Curhat</h2>
            <p class="text-muted">Masukkan kode unik yang diberikan setelah submit curhat</p>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

                    <form action="/status-anonim/cek" method="POST" class="mt-3">
                        @csrf
                        <input type="text" name="kode" class="form-control mb-3" placeholder="Masukkan kode unik" required>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary">Cek Status</button>
                            <a href="/" class="btn btn-secondary">Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>