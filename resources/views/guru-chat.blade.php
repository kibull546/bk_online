<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat - Guru BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-list {
            max-height: 600px;
            overflow-y: auto;
        }
        .chat-item {
            border-left: 3px solid #007bff;
            cursor: pointer;
            transition: 0.2s;
        }
        .chat-item:hover {
            background-color: #e9ecef;
            border-left-color: #0056b3;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#34495e;">
    <div class="container">
        <span class="navbar-brand fw-bold">💬 Live Chat Guru BK</span>
        <div>
            <span class="text-white me-3">{{ Auth::user()->name }}</span>
            <a href="/logout" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <!-- Daftar Siswa -->
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Siswa yang Chat</h5>
                </div>
                <div class="card-body p-0 chat-list">
                    @if($students->isEmpty())
                        <p class="text-muted text-center mt-3">Belum ada siswa yang chat</p>
                    @else
                        @foreach($students as $chat)
                            @php
                                $student = $chat->user;
                            @endphp
                            <a href="/guru/chat/{{ $student->id }}" class="list-group-item chat-item p-3 text-decoration-none">
                                <h6 class="mb-1">{{ $student->name }}</h6>
                                <small class="text-muted">{{ $student->email }}</small>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body text-center text-muted py-5">
                    <h5>Pilih siswa dari daftar untuk mulai chat</h5>
                    <p>Pesan akan muncul secara real-time</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
