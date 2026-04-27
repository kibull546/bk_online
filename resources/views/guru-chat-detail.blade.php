<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $student->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #chat-box {
            height: 500px;
            overflow-y: auto;
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
        }
        .msg-siswa {
            text-align: right;
            margin-bottom: 10px;
        }
        .msg-siswa .badge {
            background-color: #007bff;
            padding: 8px 12px;
            max-width: 70%;
            word-wrap: break-word;
            text-align: left;
            display: inline-block;
        }
        .msg-guru {
            text-align: left;
            margin-bottom: 10px;
        }
        .msg-guru .badge {
            background-color: #28a745;
            padding: 8px 12px;
            max-width: 70%;
            word-wrap: break-word;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#34495e;">
    <div class="container">
        <a href="/guru/chat" class="btn btn-light btn-sm">← Kembali</a>
        <span class="navbar-brand fw-bold ms-3">💬 Chat dengan {{ $student->name }}</span>
        <div class="ms-auto">
            <a href="/logout" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow">
        <!-- Chat Box -->
        <div class="card-body" id="chat-box">
            <p class="text-center text-muted">Memuat pesan...</p>
        </div>

        <!-- Input Area -->
        <div class="card-footer">
            <form id="chat-form" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="student_id" value="{{ $userId }}">
                <input type="text" id="message" class="form-control" placeholder="Tulis balasan..." required>
                <button type="submit" class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>
</div>

<script>
const studentId = {{ $userId }};

// Load pesan
function loadChat() {
    fetch(`/chat/fetch/student/${studentId}`)
        .then(res => res.json())
        .then(data => {
            let html = '';
            
            data.forEach(chat => {
                if (chat.sender === 'siswa') {
                    html += `
                    <div class="msg-siswa">
                        <span class="badge">
                            <strong>Siswa:</strong><br>${chat.message}
                        </span>
                    </div>`;
                } else {
                    html += `
                    <div class="msg-guru">
                        <span class="badge">
                            <strong>Anda:</strong><br>${chat.message}
                        </span>
                    </div>`;
                }
            });

            document.getElementById('chat-box').innerHTML = html || '<p class="text-center text-muted">Belum ada pesan</p>';
            
            let chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

// Auto refresh setiap 1 detik
setInterval(loadChat, 1000);
loadChat();

// Kirim pesan
document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    let formData = new FormData();
    formData.append('message', document.getElementById('message').value);
    formData.append('student_id', studentId);
    formData.append('_token', document.querySelector('[name=_token]').value);
    
    fetch('/chat/send', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            document.getElementById('message').value = '';
            loadChat();
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
