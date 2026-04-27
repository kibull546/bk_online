<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat Guru BK</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef2f7;
        }

        .chat-item {
            border-left: 3px solid #0d6efd;
            transition: 0.2s;
        }

        .chat-item:hover {
            background: #f1f1f1;
        }

        .list-box {
            max-height: 75vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .list-box {
                max-height: 40vh;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark" style="background:#34495e;">
    <div class="container">

        <!-- BACK BUTTON (DIPERTAHANKAN) -->
        <a href="/" class="btn btn-light btn-sm">← Kembali</a>

        <span class="navbar-brand fw-bold">💬 Live Chat Guru BK</span>

        <a href="/logout" class="btn btn-light btn-sm">Logout</a>

    </div>
</nav>

<div class="container mt-4">

    <div class="row">

        <!-- LIST SISWA (WAJIB ADA) -->
        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <b>📋 Siswa yang Chat</b>
                </div>

                <div class="list-group list-box">

                    @if($students->isEmpty())
                        <div class="p-3 text-muted text-center">
                            Belum ada siswa chat
                        </div>
                    @else

                        @foreach($students as $chat)
                            @php $student = $chat->user; @endphp

                            <a href="/guru/chat/{{ $student->id }}"
                               class="list-group-item chat-item text-decoration-none p-3">

                                <b>{{ $student->name }}</b><br>
                                <small class="text-muted">{{ $student->email }}</small>

                            </a>

                        @endforeach

                    @endif

                </div>

            </div>

        </div>

        <!-- AREA CHAT -->
        <div class="col-md-8 d-none d-md-block">

            <div class="card shadow p-5 text-center text-muted">

                <h5>💬 Pilih siswa untuk mulai chat</h5>
                <p>Pesan akan muncul di sini secara real-time</p>

            </div>

        </div>

    </div>

</div>

</body>
</html>