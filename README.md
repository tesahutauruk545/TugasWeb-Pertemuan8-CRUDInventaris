# CRUD Inventaris Alat Musik

Aplikasi manajemen inventaris alat musik dengan PHP dan MySQL.

## Fitur

✅ CRUD lengkap (Create, Read, Update, Delete)
✅ Database dengan 3 tabel + Foreign Key
✅ PDO dengan Singleton Pattern
✅ Prepared Statements untuk keamanan
✅ Flash Messages dengan redirect pattern
✅ Search & Pagination (Bonus)
✅ Log Aktivitas dengan Transaction (Bonus)
✅ UI Modern dan Responsive
✅ Output HTML dengan htmlspecialchars()

## Instalasi

1. Import file `sql/inventaris_db.sql` ke MySQL
2. Sesuaikan konfigurasi di `config/config.php`
3. Akses `http://localhost/inventaris-musik/public/`

## Struktur Database

- **kategori**: Jenis alat musik
- **supplier**: Penyedia alat musik
- **produk**: Daftar produk alat musik
- **log_aktivitas**: Catatan aktivitas (bonus)

## Tech Stack

- PHP 7.4+
- MySQL
- PDO
- Vanilla CSS & JavaScript