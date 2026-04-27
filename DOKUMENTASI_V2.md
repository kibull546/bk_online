# 📚 Dokumentasi Sistem BK Online - Versi 2.0

## Ringkasan Perubahan

Sistem telah diperbarui dengan fitur baru untuk manajemen siswa dan autentikasi yang lebih baik:

### ✅ Fitur Baru Yang Ditambahkan:

1. **Login Siswa Baru**
   - Siswa login menggunakan kode siswa + password
   - Menggantikan sistem lama di mana kode diberikan setelah submit curhat

2. **Import Excel untuk Admin**
   - Admin dapat mengimpor data siswa dari file Excel/CSV
   - Sistem otomatis generate kode siswa unik untuk setiap siswa
   - Password default dihasilkan untuk setiap siswa baru

3. **Fitur Lupa Password**
   - Siswa dapat reset password menggunakan kode siswa + nomor telepon
   - Password baru ditampilkan di halaman reset

4. **Routing Otomatis**
   - Halaman pertama (/) sekarang redirect ke `/student-login`
   - User yang sudah login otomatis diarahkan ke dashboard mereka

---

## 🔄 Alur Sistem

### Untuk Admin:

```
1. Admin login ke /login-admin
2. Admin masuk ke /dashboard-admin
3. Admin ke /admin/import-students
4. Admin download template atau langsung upload Excel
5. Sistem generate kode untuk setiap siswa
6. Admin memberitahukan kode & password ke siswa
```

### Untuk Siswa:

```
1. Siswa buka website (redirect ke /student-login)
2. Siswa masukkan "Kode Siswa" dan "Password"
3. Login berhasil → masuk ke /dashboard
4. Siswa dapat membuat curhat di /curhat
5. Siswa dapat logout di /student-logout
```

### Jika Siswa Lupa Password:

```
1. Di halaman login, klik "Lupa password?"
2. Masukkan Kode Siswa dan Nomor Telepon
3. Sistem generate password baru
4. Login dengan password baru
```

---

## 📝 File-File Yang Dibuat/Diubah

### File Baru Dibuat:

#### Controllers:
- `app/Http/Controllers/StudentLoginController.php` - Mengelola login siswa
- `app/Http/Controllers/StudentImportController.php` - Mengelola import Excel

#### Views:
- `resources/views/student-login.blade.php` - Form login siswa
- `resources/views/forgot-password.blade.php` - Form lupa password
- `resources/views/student-import.blade.php` - Form import Excel
- `resources/views/student-import-result.blade.php` - Hasil import

#### Migration:
- `database/migrations/2026_04_26_000000_add_student_code_to_users_table.php` - Tambah kolom student_code dan phone

### File Yang Diubah:

- `app/Models/User.php` - Tambah fillable untuk student_code dan phone
- `routes/web.php` - Tambah routes untuk fitur baru
- `app/Http/Controllers/CurhatController.php` - Update permission checks

---

## 🛠️ Cara Menggunakan

### Step 1: Jalankan Migration

```bash
php artisan migrate
```

Migration akan menambahkan dua kolom baru ke tabel users:
- `student_code` (VARCHAR, unique, nullable)
- `phone` (VARCHAR, nullable)

### Step 2: Import Siswa dari Excel

**Format Excel/CSV:**
```
Nama Siswa | Email | Nomor Telepon
-----------|-------|---------------
Ujang      | ujang@example.com | 08123456789
Jajang     | jajang@example.com | 08234567890
Boim       | boim@example.com | 08345678901
```

**Langkah:**
1. Login admin ke `/login-admin`
2. Buka `/admin/import-students`
3. Download template atau upload file langsung
4. Setelah upload, akan ditampilkan:
   - Jumlah siswa berhasil diimpor
   - Kode siswa yang di-generate
   - Password default untuk setiap siswa
5. Berikan informasi ini ke siswa

### Step 3: Siswa Login

**URL:** `/student-login`

**Input Required:**
- Kode Siswa (dari admin)
- Password (dari admin atau reset sendiri)

**Setelah Login:**
- Siswa masuk ke `/dashboard`
- Siswa dapat membuat curhat di `/curhat`

### Step 4: Fitur Lupa Password

**URL:** `/forgot-password`

**Input Required:**
- Kode Siswa
- Nomor Telepon (yang terdaftar)

**Hasil:**
- Password baru di-generate dan ditampilkan
- Siswa dapat login dengan password baru

---

## 🔑 Routes Baru

| Method | Route | Keterangan |
|--------|-------|-----------|
| GET | `/student-login` | Form login siswa |
| POST | `/student-login` | Proses login siswa |
| GET | `/forgot-password` | Form lupa password |
| POST | `/reset-password` | Proses reset password |
| GET | `/student-logout` | Logout siswa |
| GET | `/admin/import-students` | Form import Excel |
| POST | `/admin/import-students` | Proses import Excel |
| GET | `/admin/download-template` | Download template Excel |

---

## 📊 Database Schema

### Tabel Users (Updated)

```
- id (PRIMARY KEY)
- name (VARCHAR)
- email (VARCHAR, UNIQUE)
- student_code (VARCHAR, UNIQUE, NULLABLE) ← BARU
- phone (VARCHAR, NULLABLE) ← BARU
- password (VARCHAR)
- role (VARCHAR) - 'murid', 'guru', 'admin'
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### Tabel Curhats (Unchanged)

```
- id (PRIMARY KEY)
- nama (VARCHAR)
- pesan (TEXT)
- kategori (VARCHAR)
- kode_unik (VARCHAR) ← Tetap ada untuk status anonymous
- balasan (TEXT, NULLABLE)
- status (VARCHAR) - 'menunggu', 'dibalas'
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

## ⚠️ Catatan Penting

### Security:
1. **Password Default:** Dibuat dari hash email, bukan plain text
2. **Student Code:** Kode random 6 karakter yang unique
3. **Session Management:** Laravel session otomatis mengelola login

### Fitur Lama Yang Tetap:
1. ✓ Curhat anonim tetap berfungsi
2. ✓ Guru BK login masih di `/login`
3. ✓ Admin login masih di `/login-admin`
4. ✓ Dashboard admin tetap di `/dashboard-admin`
5. ✓ Cek status dengan kode curhat tetap di `/status-anonim`

### Perubahan Behavior:
1. ✗ Kode curhat sudah tidak diberikan setelah submit
2. ✗ Sistem lama: siswa bisa curhat tanpa login → SEKARANG: siswa harus login
3. ✓ Login siswa sekarang menggunakan kode siswa (dari admin) + password

---

## 🧪 Testing

### Test Scenario 1: Import Siswa
```
1. Login admin
2. Buka import page
3. Download template
4. Isi data: Ujang, Jajang, Boim
5. Upload file
6. Verifikasi: 3 siswa berhasil diimpor
7. Copy kode dan password mereka
```

### Test Scenario 2: Login Siswa Baru
```
1. Logout admin
2. Buka website (seharusnya redirect ke /student-login)
3. Masukkan kode siswa yang dikirim admin
4. Masukkan password dari admin
5. Verifikasi: berhasil login dan masuk dashboard
```

### Test Scenario 3: Reset Password
```
1. Di halaman login siswa, klik "Lupa password?"
2. Masukkan kode siswa dan nomor telepon
3. Verifikasi: password baru ditampilkan
4. Logout dan login dengan password baru
```

---

## 📞 Troubleshooting

### Error: "Kode siswa tidak ditemukan"
- Pastikan siswa sudah diimpor dari Excel
- Pastikan kode siswa sesuai (case-sensitive)
- Pastikan siswa memiliki role 'murid'

### Error: "Password salah"
- Pastikan password sudah benar (dari admin atau hasil reset)
- Coba reset password di halaman lupa password

### Error: "Kode siswa atau nomor telepon tidak sesuai"
- Pastikan kode siswa benar
- Pastikan nomor telepon sesuai dengan yang terdaftar saat import

### Siswa tidak bisa import Excel
- Pastikan file format Excel atau CSV
- Pastikan ukuran file < 5MB
- Pastikan login sebagai admin dulu

---

## 🎯 Next Steps / Improvements (Opsional)

1. Tambah fitur: Admin bisa lihat daftar siswa dan edit/hapus
2. Tambah fitur: Siswa bisa ganti password sendiri setelah login
3. Tambah fitur: Notifikasi email saat siswa baru di-import
4. Tambah fitur: Export data siswa yang sudah diimpor
5. Tambah fitur: Bulk edit password siswa

---

**Dokumentasi Dibuat:** 26 April 2026  
**Version:** 2.0  
**Status:** Production Ready
