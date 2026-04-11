<!DOCTYPE html>

<html>

<head>
    <title>Login Admin BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
    body {
        background: #f1f4f7;
    }

    .card {
        border-radius: 15px;
    }

    .btn-login {
        background: #34495e;
        border: none;
    }

    .btn-login:hover {
        background: #2c3e50;
    }
</style>


</head>

<body>


<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow p-4">

                <h2 class="text-center mb-4 fw-bold">Login Admin BK</h2>

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <form action="/login-admin" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan email admin" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>
                    </div>

                    <button type="submit" class="btn btn-login text-white w-100 mt-3">
                        Login
                    </button>

                    <a href="/" class="btn btn-secondary w-100 mt-2">
                        Kembali ke Beranda
                    </a>

                </form>

            </div>

        </div>
    </div>

</div>


</body>

</html>
