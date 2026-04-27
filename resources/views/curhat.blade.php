<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Live Chat BK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

@if(!Auth::check())
    <script>
        window.location.href = "/student-login";
    </script>
@endif

     <!-- DEBUG LOGIN -->
    <div class="text-center mb-2">
        {{ Auth::check() ? 'LOGIN' : 'BELUM LOGIN' }}
    </div>
    @if(session('error'))
<div class="alert alert-danger text-center">
    {{ session('error') }}
</div>
@endif

    <div class="d-flex justify-content-between align-items-center mb-3">

    

    <!-- Tombol kembali -->
    @if(Auth::user()->role == 'murid')
        <a href="/" class="btn btn-secondary">← Kembali</a>
    @else
        <a href="/" class="btn btn-secondary">← Kembali</a>
    @endif

    <h3 class="text-center m-0 flex-grow-1">💬 Live Chat BK</h3>

    <div style="width:100px;"></div> <!-- biar title tetap tengah -->
</div>
    

    <!-- PILIH SISWA (KHUSUS GURU) -->
    @if(Auth::check() && Auth::user()->role == 'guru')
    <div class="mb-3">
        <select id="student_id" class="form-select">
            <option value="">-- Pilih Siswa --</option>

            @foreach(\App\Models\User::where('role','murid')->get() as $siswa)
                <option value="{{ $siswa->id }}">{{ $siswa->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <!-- CHAT BOX -->
    <div class="card">
        <div class="card-body" id="chat-box" style="height:400px; overflow-y:auto;"></div>
    </div>

    <!-- INPUT -->
    <form id="chat-form" class="mt-3 d-flex">
        @csrf
        <input type="text" id="message" class="form-control me-2" placeholder="Ketik pesan..." required>
        <button class="btn btn-primary">Kirim</button>
    </form>

</div>

<script>

// ambil student id (buat guru)
function getStudentId(){
    let select = document.getElementById('student_id');
    return select ? select.value : null;
}

// LOAD CHAT
function loadChat() {

    let url = '/chat/fetch';
    let studentId = getStudentId();

    if(studentId){
        url += '?student_id=' + studentId;
    }

    fetch(url)
    .then(res => res.json())
    .then(data => {

        let html = '';

        data.forEach(chat => {

            // ✅ FIX FINAL POSISI CHAT (WA STYLE)
            if(chat.sender === 'siswa'){
                html += `
                <div class="text-end mb-2">
                    <div class="d-inline-block">
                        <span class="badge bg-primary p-2" style="word-wrap: break-word;">
                            ${chat.message}
                        </span>
                        @if(Auth::check() && Auth::user()->role == 'murid')
                        <button class="btn btn-sm btn-danger ms-1" onclick="deleteMessage(${chat.id})">🗑</button>
                        @endif
                    </div>
                </div>`;
            } else {
                html += `
                <div class="text-start mb-2">
                    <div class="d-inline-block">
                        <span class="badge bg-success p-2" style="word-wrap: break-word;">
                            ${chat.message}
                        </span>
                        @if(Auth::check() && Auth::user()->role == 'guru')
                        <button class="btn btn-sm btn-danger ms-1" onclick="deleteMessage(${chat.id})">🗑</button>
                        @endif
                    </div>
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

    let studentId = getStudentId();
    if(studentId){
        formData.append('student_id', studentId);
    }

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

// reload kalau guru pilih siswa
@if(Auth::check() && Auth::user()->role == 'guru')
document.getElementById('student_id').addEventListener('change', loadChat);
@endif

// HAPUS PESAN
function deleteMessage(chatId) {
    if (!confirm('Yakin hapus pesan?')) return;

    fetch(`/chat/${chatId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('[name=_token]').value,
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'ok') {
            loadChat();
        } else {
            alert(data.error || 'Gagal hapus pesan');
        }
    })
    .catch(err => alert('Terjadi kesalahan'));
}

// LOAD AWAL
loadChat();

</script>

</body>
</html>