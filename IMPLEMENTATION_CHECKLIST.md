# ✅ CHECKLIST IMPLEMENTASI SISTEM BK ONLINE v2.0

## 📋 Pre-Implementation

- [x] Buat migration untuk menambah kolom student_code dan phone
- [x] Update User model dengan fillable fields baru
- [x] Buat StudentLoginController
- [x] Buat StudentImportController
- [x] Buat 4 view baru (student-login, forgot-password, import, import-result)
- [x] Update routes di web.php
- [x] Update CurhatController untuk enforce autentikasi siswa
- [x] Buat dokumentasi lengkap

## 🚀 Langkah Implementasi

### 1. Backup Database (Opsional tapi Disarankan)
```bash
# Backup database sebelum migration
# Jika menggunakan SQLite: cp database/database.sqlite database/database.sqlite.backup
# Jika menggunakan MySQL: mysqldump -u user -p database_name > backup.sql
```

### 2. Jalankan Migration
```bash
cd c:\Users\Rizki\Documents\tugas_sekolah\bk_online
php artisan migrate
```

✓ Seharusnya berhasil menambah kolom:
  - users.student_code (VARCHAR, UNIQUE, NULLABLE)
  - users.phone (VARCHAR, NULLABLE)

### 3. Verifikasi Database
```bash
php artisan tinker
# Jalankan perintah berikut di tinker:
DB::table('users')->getColumns()
# Pastikan 'student_code' dan 'phone' ada di output
```

### 4. Test Routes
```bash
# Pastikan routes berikut terdaftar:
php artisan route:list | grep student
php artisan route:list | grep admin/import
php artisan route:list | grep reset-password
php artisan route:list | grep forgot-password
```

### 5. Upload File ke Production (Jika Needed)
```
Pastikan file-file berikut sudah ter-upload:

Controllers:
- app/Http/Controllers/StudentLoginController.php ✓
- app/Http/Controllers/StudentImportController.php ✓

Views:
- resources/views/student-login.blade.php ✓
- resources/views/forgot-password.blade.php ✓
- resources/views/student-import.blade.php ✓
- resources/views/student-import-result.blade.php ✓

Migrations:
- database/migrations/2026_04_26_000000_add_student_code_to_users_table.php ✓

Modified Files:
- app/Models/User.php ✓
- app/Http/Controllers/CurhatController.php ✓
- routes/web.php ✓
```

## 🧪 Functional Testing

### Test 1: Home Page Redirect
- [ ] Buka http://localhost:8000/
- [ ] Seharusnya redirect ke http://localhost:8000/student-login

### Test 2: Student Login Page
- [ ] Buka http://localhost:8000/student-login
- [ ] Form harus menampilkan: Kode Siswa, Password
- [ ] Link "Lupa password?" harus tersedia

### Test 3: Import Excel Features
- [ ] Login admin di http://localhost:8000/login-admin
- [ ] Buka http://localhost:8000/admin/import-students
- [ ] Download template (harus berformat CSV dengan header: Nama, Email, Telepon)
- [ ] Upload file kosong (harus error)
- [ ] Upload file dengan data valid (harus berhasil)

### Test 4: Create Student from Import
- [ ] Siapkan file Excel dengan data: Ujang, Jajang, Boim
- [ ] Import file tersebut
- [ ] Verifikasi di halaman hasil:
  - [x] 3 siswa berhasil diimpor
  - [x] Kode unik ditampilkan
  - [x] Password default ditampilkan

### Test 5: Login Siswa dengan Kode
- [ ] Logout dari admin
- [ ] Kunjungi halaman login siswa
- [ ] Gunakan kode siswa dari hasil import
- [ ] Gunakan password dari hasil import
- [ ] Verifikasi login berhasil dan masuk ke /dashboard

### Test 6: Reset Password Features
- [ ] Buka halaman lupa password
- [ ] Masukkan kode siswa + nomor telepon
- [ ] Verifikasi password baru ditampilkan
- [ ] Logout
- [ ] Login dengan password baru

### Test 7: Student Dashboard
- [ ] Setelah login, check halaman /dashboard
- [ ] Verifikasi dapat akses /curhat
- [ ] Test membuat curhat baru
- [ ] Verifikasi curhat dapat dikirim

### Test 8: Logout Siswa
- [ ] Klik logout atau akses /student-logout
- [ ] Seharusnya redirect ke /student-login

## 🔒 Security Verification

- [ ] Password tidak pernah ditampilkan plaintext di database
- [ ] Student code random dan unique
- [ ] Reset password hanya dengan kode siswa + nomor telepon
- [ ] Role-based access control berfungsi
- [ ] Only murid can access /curhat dan /dashboard
- [ ] Only guru/admin can reply to curhat
- [ ] Only admin can access /admin/import-students

## 📊 Data Verification

Setelah import 3 siswa, verifikasi di database:

```sql
-- Check users table
SELECT id, name, email, student_code, phone, role FROM users WHERE role = 'murid';

-- Seharusnya menampilkan 3 siswa dengan kode unik
```

Expected Output:
```
| id | name  | email           | student_code | phone        | role  |
|----|-------|-----------------|--------------|--------------|-------|
| 4  | Ujang | ujang@exam.com  | ABC123       | 08123456789  | murid |
| 5  | Jajang| jajang@exam.com | DEF456       | 08234567890  | murid |
| 6  | Boim  | boim@exam.com   | GHI789       | 08345678901  | murid |
```

## 🐛 Known Issues & Solutions

### Issue 1: Migration fails
**Solution:**
```bash
# Rollback dan coba lagi
php artisan migrate:rollback
php artisan migrate
```

### Issue 2: Import file tidak support
**Solution:**
- Pastikan file format: .xlsx, .xls, atau .csv
- Pastikan ukuran file < 5MB
- Pastikan header row sesuai: Nama, Email, Telepon

### Issue 3: Student tidak bisa login
**Solution:**
- Cek student_code di database
- Pastikan password dihash (gunakan Hash::check untuk verifikasi)
- Lihat di log untuk error details

### Issue 4: Reset password tidak work
**Solution:**
- Pastikan nomor telepon sesuai dengan yang terdaftar
- Jika lupa nomor, admin harus update manual di database

## 📝 Manual Database Update (Jika Diperlukan)

### Tambah Siswa Manual
```php
php artisan tinker

$user = new App\Models\User();
$user->name = 'Ujang';
$user->email = 'ujang@example.com';
$user->phone = '08123456789';
$user->password = Hash::make('Murid@123456');
$user->role = 'murid';
$user->student_code = 'ABC123';
$user->save();
```

### Reset Password Siswa
```php
php artisan tinker

$user = App\Models\User::where('student_code', 'ABC123')->first();
$user->password = Hash::make('NewPassword123');
$user->save();
```

### Ganti Nomor Telepon
```php
php artisan tiniker

$user = App\Models\User::where('student_code', 'ABC123')->first();
$user->phone = '08999999999';
$user->save();
```

## ✨ Additional Notes

1. **Email Verification**: Sistem saat ini tidak menggunakan email verification, hanya database entry
2. **Two-Factor Authentication**: Tidak diimplementasi (bisa ditambah di versi mendatang)
3. **Audit Logging**: Tidak diimplementasi (bisa ditambah untuk tracking login/import)
4. **Rate Limiting**: Tidak ada batasan login attempt (bisa ditambah untuk security)

## 📞 Support & Contact

Jika ada pertanyaan atau masalah, silakan check:
1. DOKUMENTASI_V2.md - Dokumentasi lengkap sistem
2. Log file di `storage/logs/laravel.log`
3. Database backups (jika ada issue)

---

**Status**: ✅ READY FOR TESTING  
**Last Updated**: 26 April 2026  
**Version**: 2.0
