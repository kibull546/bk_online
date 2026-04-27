<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Chat Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="/" class="btn btn-secondary">← Kembali</a>
        <h4 class="m-0">💬 Riwayat Chat Saya</h4>
        <div style="width:100px;"></div>
    </div>

    <!-- CHAT BOX -->
    <div class="card shadow-sm">
        <div class="card-body" id="chat-box" style="height:400px; overflow-y:auto;">
        </div>
    </div>

    <!-- INPUT -->
    <form id="chat-form" class="mt-3 d-flex">
        @csrf
        <input type="text" id="message" class="form-control me-2" placeholder="Ketik pesan..." required>
        <button class="btn btn-primary">Kirim</button>
    </form>

</div>

<script>

// LOAD CHAT
function loadChat() {
    fetch('/chat/fetch')
    .then(res => res.json())
    .then(data => {

        let html = '';

        data.forEach(chat => {

            if(chat.sender === 'siswa'){
                html += `
                <div class="text-end mb-2">
                    <span class="badge bg-primary p-2">
                        ${chat.message}
                    </span>
                </div>`;
            } else {
                html += `
                <div class="text-start mb-2">
                    <span class="badge bg-success p-2">
                        ${chat.message}
                    </span>
                </div>`;
            }

        });

        document.getElementById('chat-box').innerHTML = html;

        let chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}

// AUTO REFRESH
setInterval(loadChat, 2000);

// KIRIM CHAT
document.getElementById('chat-form').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData();
    formData.append('message', document.getElementById('message').value);
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

// LOAD AWAL
loadChat();

</script>

</body>
</html>