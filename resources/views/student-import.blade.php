<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Siswa</title>
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

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #693a94 100%);
        }

        .file-upload {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .file-upload input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-upload label {
            display: inline-block;
            padding: 10px 20px;
            background: #f8f9fa;
            border: 2px dashed #667eea;
            border-radius: 5px;
            cursor: pointer;
        }

        .file-upload label:hover {
            background: #e9ecef;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Import Siswa dari Excel</h4>
                    </div>

                    <div class="card-body">

                        @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="mb-4">
                            <h6>Instruksi:</h6>
                            <ol>
                                <li>Download template Excel terlebih dahulu</li>
                                <li>Isi data siswa dengan format: Nama, Email, Nomor Telepon</li>
                                <li>Upload file Excel yang sudah diisi</li>
                                <li>Sistem akan generate kode unik untuk setiap siswa</li>
                                <li>Berikan kode dan password ke siswa</li>
                            </ol>
                        </div>

                        <hr>

                        <form method="POST" action="/admin/import-students" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pilih File Excel</label>
                                <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                                    accept=".xlsx,.xls,.csv" required>
                                <small class="text-muted">Format: Excel (.xlsx, .xls) atau CSV | Ukuran maksimal: 5MB</small>
                                @error('file')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/admin/download-template" class="btn btn-secondary">
                                    📥 Download Template
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    📤 Upload File
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Format File Excel</h5>
                    </div>

                    <div class="card-body">
                        <p>File harus memiliki kolom dengan format berikut:</p>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ujang</td>
                                    <td>ujang@example.com</td>
                                    <td>08123456789</td>
                                </tr>
                                <tr>
                                    <td>Jajang</td>
                                    <td>jajang@example.com</td>
                                    <td>08234567890</td>
                                </tr>
                                <tr>
                                    <td>Boim</td>
                                    <td>boim@example.com</td>
                                    <td>08345678901</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
