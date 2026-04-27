<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Import Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .success-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-small {
            font-size: 0.85em;
        }

        .btn-copy {
            padding: 2px 6px;
            font-size: 0.8em;
        }

        .code-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
            font-family: monospace;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">

                <div class="success-banner">
                    <h3 class="mb-2">✓ Import Berhasil</h3>
                    <p class="mb-0">{{ $imported }} siswa telah berhasil ditambahkan ke sistem</p>
                </div>

                @if(count($errors) > 0)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <h5>⚠️ Ada {{ count($errors) }} baris yang gagal diproses:</h5>
                    <ul class="mb-0">
                        @foreach($errors as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Data Siswa yang Berhasil Diimpor</h5>
                    </div>

                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Berikut adalah data siswa beserta kode unik dan password default mereka.
                            <strong>Pastikan memberikan informasi ini kepada siswa!</strong>
                        </p>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-small">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Email</th>
                                        <th>Kode Siswa</th>
                                        <th>Password Default</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($generatedCodes as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['email'] }}</td>
                                        <td>
                                            <code class="bg-light p-2">{{ $data['student_code'] }}</code>
                                        </td>
                                        <td>
                                            <code class="bg-light p-2">{{ $data['password'] }}</code>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <h6 class="mt-4">Instruksi untuk Siswa:</h6>
                        <div class="code-box">
                            1. Kunjungi website dan masuk ke halaman login siswa<br>
                            2. Masukkan "Kode Siswa" yang telah diberikan<br>
                            3. Masukkan "Password Default" di atas<br>
                            4. Login berhasil dan dapat mengakses dashboard<br>
                            5. Anda dapat mengubah password setelah login
                        </div>

                    </div>
                </div>

                <div class="mt-4 text-center">
                    <a href="/admin/import-students" class="btn btn-primary">← Kembali ke Import</a>
                    <a href="/dashboard-admin" class="btn btn-secondary">Ke Dashboard Admin</a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi copy ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Teks berhasil disalin!');
            });
        }
    </script>

</body>

</html>
