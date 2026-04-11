<!DOCTYPE html>
<html>

<head>
    <title>Cek Status Curhat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4 text-center">
            <h2>Cek Status Curhat</h2>
            <p class="text-muted">Masukkan kode unik yang diberikan setelah submit curhat</p>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="/status-anonim/cek" method="POST" class="mt-3">
                @csrf
                <input type="text" name="kode" class="form-control mb-3" placeholder="Masukkan kode unik" required>
                <button class="btn btn-primary w-100">Cek Status</button>
            </form>

            <a href="/" class="btn btn-secondary mt-3">Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>