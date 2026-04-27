<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - BK Online</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg,#667eea,#764ba2);
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

.card{
    width:100%;
    max-width:420px;
    border:none;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.3);
}

.card-header{
    background:#34495e;
    color:white;
    text-align:center;
    padding:20px;
    font-weight:bold;
}

.btn-primary{
    width:100%;
}
</style>

</head>

<body>

<div class="card">

    <div class="card-header">
        RESET PASSWORD
    </div>

    <div class="card-body p-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/reset-password">
            @csrf

            <div class="mb-3">
                <label>Kode Siswa</label>
                <input type="text" name="student_code" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input type="text" name="password" class="form-control" placeholder="contoh: 1234 / keren333" required>
            </div>

            <button class="btn btn-primary">
                Reset Password
            </button>

        </form>

        <div class="text-center mt-3">
            <a href="/student-login">← kembali login</a>
        </div>

    </div>
</div>

</body>
</html>