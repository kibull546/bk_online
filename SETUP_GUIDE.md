# 🚀 PANDUAN SETUP SISTEM BK ONLINE v2.0

## ⏱️ Waktu Estimasi: 15 menit

---

## 📦 Step 1: Persiapan (1 menit)

Pastikan Anda berada di direktori project:
```bash
cd c:\Users\Rizki\Documents\tugas_sekolah\bk_online
```

Verifikasi bahwa composer dan Laravel sudah terinstall:
```bash
php -v
composer -v
php artisan --version
```

---

## 🗄️ Step 2: Jalankan Migration (2 menit)

Jalankan migration untuk menambah kolom baru ke tabel users:

```bash
php artisan migrate
```

**Output yang diharapkan:**
```
Migrating: 2026_04_26_000000_add_student_code_to_users_table
Migrated:  2026_04_26_000000_add_student_code_to_users_table (xxx ms)
```

### Verifikasi Migration Berhasil:

```bash
php artisan tinker
```

Jalankan di tinker prompt:
```php
DB::table('users')->columns()
```

Pastikan output menampilkan: `student_code` dan `phone`

Ketik `exit` untuk keluar dari tinker.

---

## 🎯 Step 3: Test Routes (1 menit)

Verifikasi routes sudah terdaftar:

```bash
php artisan route:list | grep -E "(student|import|reset|forgot)"
```

Seharusnya muncul routes baru:
```
POST   /student-login
GET    /student-login
GET    /forgot-password
POST   /reset-password
GET    /student-logout
GET    /admin/import-students
POST   /admin/import-students
GET    /admin/download-template
```

---

## 🏃 Step 4: Jalankan Development Server (2 menit)

```bash
php artisan serve
```

Buka browser dan kunjungi: `http://localhost:8000`

Seharusnya otomatis redirect ke: `http://localhost:8000/student-login`

---

## 📝 Step 5: Buat Akun Admin untuk Testing (2 menit)

Jika belum ada admin account, buat dengan tinker:

```bash
php artisan tinker
```

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin Baru',
    'email' => 'admin@test.com',
    'password' => Hash::make('admin123'),
    'role' => 'admin'
]);
```

Output:
```
=> App\Models\User {#3
     id: X,
     name: "Admin Baru",
     email: "admin@test.com",
     role: "admin",
     ...
   }
```

Ketik `exit`

---

## 👨‍💼 Step 6: Login Admin (2 menit)

1. Buka: `http://localhost:8000/login-admin`
2. Login dengan:
   - Email: `admin@test.com`
   - Password: `admin123`
3. Seharusnya masuk ke `/dashboard-admin`

---

## 📤 Step 7: Import Siswa Test (3 menit)

### Opsi A: Download Template dan Isi Manual

1. Admin buka: `http://localhost:8000/admin/import-students`
2. Klik tombol "📥 Download Template"
3. File `template_siswa.csv` akan terdownload
4. Buka file dengan Excel atau Text Editor
5. Format sudah ada 3 contoh: Ujang, Jajang, Boim
6. Atau Anda bisa tambah/ubah sesuai kebutuhan
7. Save file

### Opsi B: Buat File Langsung

Buat file `import_test.csv` dengan content:

```
Nama Siswa,Email,Nomor Telepon
Ujang,ujang@test.com,08123456789
Jajang,jajang@test.com,08234567890
Boim,boim@test.com,08345678901
```

### Upload File

1. Kembali ke halaman: `http://localhost:8000/admin/import-students`
2. Klik "Choose File"
3. Pilih file CSV yang sudah dibuat
4. Klik "📤 Upload File"

**Output yang Diharapkan:**
```
✓ Import Berhasil
3 siswa telah berhasil ditambahkan ke sistem

Data Siswa yang Berhasil Diimpor:
[Tabel dengan Nama, Email, Kode Siswa, Password]
```

---

## 👤 Step 8: Test Login Siswa (2 menit)

1. Logout admin: klik `/logout-admin` atau buka `http://localhost:8000/logout-admin`
2. Buka halaman login siswa: `http://localhost:8000/student-login`
3. Masukkan:
   - **Kode Siswa**: Gunakan kode dari hasil import (contoh: ABC123)
   - **Password**: Gunakan password dari hasil import
4. Klik tombol "Login"
5. Seharusnya masuk ke `/dashboard`

---

## 🔑 Step 9: Test Fitur Lupa Password (2 menit)

1. Buka halaman login siswa: `http://localhost:8000/student-login`
2. Klik link "Lupa password?"
3. Masukkan:
   - **Kode Siswa**: ABC123 (dari import)
   - **Nomor Telepon**: 08123456789 (dari import)
4. Klik "Reset Password"
5. Seharusnya muncul pesan dengan password baru
6. Copy password baru
7. Kembali ke login dan coba dengan password baru

---

## 📋 Checklist Final

- [ ] Migration berhasil dijalankan
- [ ] Route baru sudah terdaftar
- [ ] Server Laravel berjalan
- [ ] Admin bisa login
- [ ] Import Excel berhasil
- [ ] 3 siswa berhasil diimpor dengan kode unik
- [ ] Siswa bisa login dengan kode + password
- [ ] Fitur lupa password bekerja
- [ ] Siswa bisa akses dashboard

---

## 🆘 Troubleshooting

### Masalah: "Column not found" saat akses database
**Solusi:**
```bash
php artisan migrate:fresh --seed
# atau
php artisan migrate --force
```

### Masalah: Routes tidak muncul
**Solusi:**
```bash
php artisan route:clear
php artisan route:cache
```

### Masalah: File tidak bisa diupload
**Solusi:**
- Pastikan ukuran file < 5MB
- Format file harus .xlsx, .xls, atau .csv
- Check permissions folder `storage/`

### Masalah: Login siswa error "not found"
**Solusi:**
- Pastikan siswa sudah diimpor
- Cek di database: `SELECT * FROM users WHERE role = 'murid'`
- Pastikan kode siswa sesuai (case-sensitive)

---

## 📞 Next Steps

1. **Lanjutkan Development:**
   - Test fitur curhat
   - Test fitur balas (guru)
   - Test fitur monitoring

2. **Customize (Opsional):**
   - Ubah branding/tema
   - Tambah validasi tambahan
   - Tambah fitur baru

3. **Deploy ke Production:**
   - Backup database
   - Copy semua file ke server
   - Jalankan migration di production
   - Test semua fitur

---

## 📊 Summary Fitur Baru

| Fitur | URL | User | Status |
|-------|-----|------|--------|
| Login Siswa | `/student-login` | Murid | ✅ Live |
| Lupa Password | `/forgot-password` | Murid | ✅ Live |
| Import Excel | `/admin/import-students` | Admin | ✅ Live |
| Download Template | `/admin/download-template` | Admin | ✅ Live |
| Logout Siswa | `/student-logout` | Murid | ✅ Live |

---

**Status**: ✅ READY FOR PRODUCTION  
**Last Updated**: 26 April 2026  
**Version**: 2.0  
**Estimated Completion Time**: 15-20 menit
