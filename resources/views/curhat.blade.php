<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Live Chat BK</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#eef2f7; }

#chat-box {
    height:65vh;
    overflow-y:auto;
    background:#fff;
    border-radius:12px;
    padding:12px;
}

.bubble {
    display:inline-block;
    padding:10px 14px;
    border-radius:14px;
    max-width:75%;
    word-wrap:break-word;
}

.me { background:#0d6efd; color:#fff; }
.other { background:#198754; color:#fff; }

.right { text-align:right; }
.left { text-align:left; }

.del {
    border:none;
    background:red;
    color:white;
    font-size:10px;
    border-radius:5px;
    margin-left:5px;
}

.time {
    font-size:10px;
    opacity:0.6;
}
</style>
</head>

<body>

<div class="container mt-3">

<h4 class="text-center">💬 Live Chat BK</h4>

@if(Auth::user()->role == 'guru')
<select id="student_id" class="form-select mb-2">
    <option value="">-- Pilih Siswa Berdasarkan Kode --</option>
    @foreach(\App\Models\User::where('role','murid')->get() as $siswa)
        <option value="{{ $siswa->id }}">
            {{ $siswa->student_code }}
        </option>
    @endforeach
</select>
@endif

<div class="text-end mb-2">
    <button class="btn btn-danger btn-sm" onclick="clearAllChat()">
        Clear Chat (View Ini)
    </button>
</div>

<div class="card shadow">
    <div class="card-body" id="chat-box"></div>

    <div class="p-2 border-top">
        <form id="chat-form" class="d-flex gap-2">
            @csrf
            <input type="text" id="message" class="form-control" placeholder="Tulis pesan..." required>
            <button class="btn btn-primary">Kirim</button>
        </form>
    </div>
</div>

</div>

<script>

const ROLE = "{{ Auth::user()->role }}";
const USER_ID = "{{ Auth::user()->id }}";

function getStudentId(){
    let el = document.getElementById('student_id');
    return el ? el.value : null;
}

/* ================= REALTIME WA ================= */
function loadChat(){

    let url = '/chat/fetch';
    let studentId = getStudentId();

    if(studentId) url += '?student_id=' + studentId;

    fetch(url)
    .then(res => res.json())
    .then(data => {

        let html = '';

        data.forEach(chat => {

            let canDelete =
                (ROLE === 'murid' && chat.sender === 'siswa' && chat.user_id == USER_ID)
                ||
                (ROLE === 'guru' && chat.sender === 'guru' && chat.guru_id == USER_ID);

            let delBtn = canDelete
                ? `<button class="del" onclick="deleteMsg(${chat.id})">x</button>`
                : '';

            let time = chat.time ?? '';

            if(chat.sender === 'siswa'){
                html += `
                <div class="right mb-2">
                    <span class="bubble me">
                        ${chat.message}
                        <div style="font-size:10px; opacity:0.6;">${time}</div>
                        ${delBtn}
                    </span>
                </div>`;
            } else {
                html += `
                <div class="left mb-2">
                    <span class="bubble other">
                        ${chat.message}
                        <div style="font-size:10px; opacity:0.6;">${time}</div>
                        ${delBtn}
                    </span>
                </div>`;
            }
        });

        let box = document.getElementById('chat-box');

let isAtBottom = (box.scrollTop + box.clientHeight) >= (box.scrollHeight - 50);

box.innerHTML = html || '<p class="text-center text-muted">Belum ada chat</p>';

// hanya auto scroll kalau user memang di bawah
if (isAtBottom) {
    box.scrollTop = box.scrollHeight;
}
    });
}

/* ================= SEND ================= */
document.getElementById('chat-form').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData();
    formData.append('message', document.getElementById('message').value);
    formData.append('_token', document.querySelector('[name=_token]').value);

    let studentId = getStudentId();
    if(studentId) formData.append('student_id', studentId);

    fetch('/chat/send', {
        method:'POST',
        body:formData
    }).then(() => {
        document.getElementById('message').value='';
        loadChat();
    });
});

/* ================= DELETE GLOBAL ================= */
function deleteMsg(id){

    if(!confirm('Hapus pesan ini?')) return;

    fetch(`/chat/${id}`, {
        method:'DELETE',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('[name=_token]').value
        }
    }).then(() => loadChat());
}

/* ================= CLEAR VIEW ================= */
function clearAllChat(){

    if(!confirm('Hapus tampilan chat?')) return;

    fetch('/chat/clear-all', {
        method:'POST',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('[name=_token]').value
        }
    }).then(() => loadChat());
}

/* ================= REALTIME LOOP ================= */
setInterval(loadChat, 1000);

loadChat();

</script>

</body>
</html>