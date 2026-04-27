# 📖 QUICK REFERENCE GUIDE - BK Online v2.0

## 🚀 Quick Commands

```bash
# Setup awal
php artisan migrate                    # Jalankan migration
php artisan serve                      # Start development server

# Testing
php artisan tinker                     # Interactive shell
php artisan route:list                 # Lihat semua routes
php -l app/Http/Controllers/*.php      # Check syntax
```

---

## 🔗 Important URLs

### 👤 Siswa
| Feature | URL | Method |
|---------|-----|--------|
| Login | `/student-login` | GET/POST |
| Lupa Password | `/forgot-password` | GET/POST |
| Reset Password | `/reset-password` | POST |
| Logout | `/student-logout` | GET |
| Dashboard | `/dashboard` | GET |
| Curhat | `/curhat` | GET/POST |

### 👨‍🏫 Guru
| Feature | URL | Method |
|---------|-----|--------|
| Login | `/login` | GET/POST |
| Dashboard | `/dashboard` | GET |
| Logout | `/logout` | GET |

### 🔐 Admin
| Feature | URL | Method |
|---------|-----|--------|
| Login | `/login-admin` | GET/POST |
| Dashboard | `/dashboard-admin` | GET |
| Import Siswa | `/admin/import-students` | GET/POST |
| Download Template | `/admin/download-template` | GET |
| Logout | `/logout-admin` | GET |

---

## 📊 Database

### Users Table (New Columns)
```sql
-- Tambahan kolom baru:
ALTER TABLE users ADD COLUMN student_code VARCHAR(255) UNIQUE NULLABLE;
ALTER TABLE users ADD COLUMN phone VARCHAR(255) NULLABLE;
```

### View Users (Tinker)
```php
// Lihat semua siswa
DB::table('users')->where('role', 'murid')->get();

// Lihat siswa tertentu
DB::table('users')->where('student_code', 'ABC123')->get();

// Update siswa
DB::table('users')->where('student_code', 'ABC123')
  ->update(['phone' => '081234567890']);
```

---

## 🎯 Workflow

### Admin Setup
```
1. Login: /login-admin
2. Import: /admin/import-students  
3. Download template
4. Upload file Excel
5. Bagikan kode & password ke siswa
```

### Siswa First Login
```
1. Buka: /student-login
2. Masukkan kode siswa (dari admin)
3. Masukkan password (dari admin)
4. Masuk ke: /dashboard
```

### Siswa Lupa Password
```
1. Buka: /forgot-password
2. Masukkan kode siswa + nomor telepon
3. Password baru di-generate
4. Login dengan password baru
```

### Siswa Buat Curhat
```
1. Login ke /student-login
2. Buka: /curhat
3. Isi form: Nama, Pesan, Kategori
4. Submit
5. Curhat tercatat di database
```

---

## 🔑 Key Files

```
app/
├── Http/Controllers/
│   ├── StudentLoginController.php      ← NEW
│   ├── StudentImportController.php     ← NEW
│   └── CurhatController.php            (modified)
└── Models/
    └── User.php                        (modified)

resources/views/
├── student-login.blade.php             ← NEW
├── forgot-password.blade.php           ← NEW
├── student-import.blade.php            ← NEW
└── student-import-result.blade.php     ← NEW

database/migrations/
└── 2026_04_26_000000_add_student_code_to_users_table.php ← NEW

routes/
└── web.php                             (modified)
```

---

## 💾 Tinker Commands Reference

### Create Student Manually
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

User::create([
    'name' => 'Nama Siswa',
    'email' => 'email@test.com',
    'phone' => '08123456789',
    'password' => Hash::make('password123'),
    'role' => 'murid',
    'student_code' => strtoupper(Str::random(6))
]);
```

### Reset Student Password
```php
$user = User::where('student_code', 'ABC123')->first();
$user->password = Hash::make('NewPassword123');
$user->save();
```

### Get Student Info
```php
User::where('student_code', 'ABC123')->first();
```

### Delete Student
```php
User::where('student_code', 'ABC123')->delete();
```

### View All Students
```php
User::where('role', 'murid')->get();
```

---

## 🧪 Test Data

### Test User (Admin)
```
Email: admin@test.com
Password: admin123
Role: admin
```

### Test Students
```
1. Ujang / ujang@test.com / 08123456789
2. Jajang / jajang@test.com / 08234567890
3. Boim / boim@test.com / 08345678901
```

---

## 📥 Excel/CSV Format

### Header Row (Required)
```
Nama Siswa | Email | Nomor Telepon
```

### Example Data
```
Ujang,ujang@example.com,08123456789
Jajang,jajang@example.com,08234567890
Boim,boim@example.com,08345678901
```

### Validasi Data
- ✓ Nama: tidak boleh kosong
- ✓ Email: format valid (user@domain.com)
- ✓ Telepon: tidak boleh kosong
- ✓ Email: harus unique (belum ada di database)

---

## ⚠️ Important Notes

### Security
- ✓ Password di-hash sebelum disimpan
- ✓ Student code unique dan random
- ✓ Reset password via kode + telepon
- ✓ Role-based access control

### Constraints
- ✓ Student harus login untuk akses dashboard
- ✓ Student hanya bisa akses data mereka
- ✓ Guru/Admin: akses khusus untuk mereka
- ✓ Admin: akses import dan manage siswa

### Backup & Recovery
```bash
# Backup database
cp database/database.sqlite database/database.sqlite.backup

# Restore database
cp database/database.sqlite.backup database/database.sqlite

# Reset migration
php artisan migrate:refresh
```

---

## 🐛 Common Issues

| Issue | Solution |
|-------|----------|
| Column not found | Run: `php artisan migrate` |
| Routes not found | Run: `php artisan route:clear` |
| Import error | Check file format & size < 5MB |
| Login error | Check kode siswa & password |
| Password reset error | Verify kode siswa & nomor telepon |

---

## 📞 Debugging

### Enable Query Logging
```php
// Tambahkan di controller/route
DB::enableQueryLog();
// ... kode Anda ...
dd(DB::getQueryLog());
```

### Check Log Files
```bash
tail -f storage/logs/laravel.log
```

### Database Query
```bash
# SQLite
sqlite3 database/database.sqlite ".tables"

# MySQL
mysql -u user -p database_name -e "SHOW TABLES;"
```

---

## 📈 Performance Tips

1. **Cache Routes**
   ```bash
   php artisan route:cache
   ```

2. **Cache Config**
   ```bash
   php artisan config:cache
   ```

3. **Index Important Columns**
   ```sql
   CREATE INDEX idx_student_code ON users(student_code);
   CREATE INDEX idx_role ON users(role);
   ```

---

**Version**: 2.0  
**Last Updated**: 26 April 2026  
**Quick Reference Card for BK Online**
