<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat dengan {{ $student->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #eef2f7;
        }

        /* CHAT BOX */
        #chat-box {
            height: 65vh;
            overflow-y: auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 12px;
        }

        /* BUBBLE WRAPPER */
        .msg-siswa,
        .msg-guru {
            display: flex;
            margin-bottom: 10px;
        }

        .msg-siswa {
            justify-content: flex-end;
        }

        .msg-guru {
            justify-content: flex-start;
        }

        /* BUBBLE */
        .bubble-siswa {
            background: #0d6efd;
            color: white;
            padding: 10px 14px;
            border-radius: 15px;
            max-width: 75%;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        .bubble-guru {
            background: #198754;
            color: white;
            padding: 10px 14px;
            border-radius: 15px;
            max-width: 75%;
            word-wrap: break-word;
            white-space: pre-wrap;
        }

        /* INPUT FIX */
        .chat-input {
            position: sticky;
            bottom: 0;
            background: white;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            #chat-box {
                height: 70vh;
            }

            .bubble-siswa,
            .bubble-guru {
                max-width: 90%;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark" style="background:#34495e;">
    <div class="container">
        <a href="/guru/chat" class="btn btn-light btn-sm">← Kembali</a>
        <span class="navbar-brand fw-bold">💬 {{ $student->name }}</span>
        <a href="/logout" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<!-- CHAT -->
<div class="container mt-3">

    <div class="card shadow">
        <div class="card-body" id="chat-box">
            <p class="text-center text-muted">Memuat pesan...</p>
        </div>

        <!-- INPUT -->
        <div class="chat-input">
            <form id="chat-form" class="d-flex gap-2">
                @csrf
                <input type="hidden" name="student_id" value="{{ $userId }}">
                <input type="text" id="message" class="form-control" placeholder="Tulis pesan..." required>
                <button class="btn btn-success">Kirim</button>
            </form>
        </div>

    </div>

</div>

<script>
const studentId = {{ $userId }};

// LOAD CHAT
function loadChat() {
    fetch(`/chat/fetch/student/${studentId}`)
        .then(res => res.json())
        .then(data => {

            let html = '';

            data.forEach(chat => {

                if (chat.sender === 'siswa') {
                    html += `
                    <div class="msg-siswa">
                        <div class="bubble-siswa">
                            ${chat.message}
                        </div>
                    </div>`;
                } else {
                    html += `
                    <div class="msg-guru">
                        <div class="bubble-guru">
                            ${chat.message}
                            <button class="btn btn-sm btn-danger ms-2" onclick="deleteMessage(${chat.id})">🗑</button>
                        </div>
                    </div>`;
                }

            });

            document.getElementById('chat-box').innerHTML =
                html || '<p class="text-center text-muted">Belum ada pesan</p>';

            let box = document.getElementById('chat-box');
            box.scrollTop = box.scrollHeight;
        });
}

// AUTO REFRESH
setInterval(loadChat, 1000);
loadChat();

// SEND CHAT
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
    .then(() => {
        document.getElementById('message').value = '';
        loadChat();
    });
});

// DELETE
function deleteMessage(id) {
    if (!confirm('Hapus pesan?')) return;

    fetch(`/chat/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name=_token]').value,
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(() => loadChat());
}
</script>

</body>
</html>