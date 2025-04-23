# Patient Management System (Kasap Mata)

## 1. Overview
Aplikasi manajemen klinik sederhana dengan Laravel 10 dan AdminLTE. Mendukung registrasi pasien, permintaan pemeriksaan, antrian dokter, pencatatan pemeriksaan, manajemen obat, dan riwayat.

## 2. Fitur Utama
- **Autentikasi**: login, register untuk pasien dan dokter.
- **Registrasi Pasien**: pasien daftar akun.
- **Permintaan Pemeriksaan**: pasien isi keluhan, status `pending`.
- **Antrian Dokter**: dokter lihat daftar periksa `pending`.
- **Update Pemeriksaan**: dokter isi catatan, ubah status ke `done`.
- **Manajemen Obat**: CRUD obat dengan DataTables (tambah, edit, hapus via AJAX & modal).
- **Riwayat Pasien**: pasien lihat riwayat periksa dengan catatan dokter dan resep obat.

## 3. Struktur Folder (Non-default Laravel)
```
app/
  Http/Controllers/
    AuthController.php        # Login, register
    PasienController.php      # CRUD pasien, form periksa, riwayat
    DokterController.php      # Antrian periksa, update, CRUD obat
  Models/
    Pasien.php                # Eloquent model pasien
    Periksa.php               # Eloquent model periksa (keluhan, catatan_dokter, status)
    Obat.php                  # Eloquent model obat

database/
  migrations/
    *_create_pasiens_table.php
    *_create_periksas_table.php
    *_create_obats_table.php
  seeders/                   # (opsional) data awal

public/
  adminlte/                  # template AdminLTE (CSS/JS)
  plugins/datatables/        # DataTables assets

resources/views/
  layouts/dokter.blade.php   # layout utama dokter
  layouts/pasien.blade.php   # layout utama pasien
  pasien/
    register.blade.php       # form registrasi
    periksa.blade.php        # form permintaan periksa
    riwayat.blade.php        # tabel riwayat pemeriksaan
  dokter/
    dashboard.blade.php      # statistik dashboard dokter
    periksa.blade.php        # tabel antrian periksa
    periksa-edit.blade.php   # modal edit pemeriksaan
    obat.blade.php           # form + tabel obat (DataTables)

routes/web.php               # route definisi untuk pasien & dokter
```

## 4. Alur Sistem
1. **Pasien Register**: POST `/register` → `AuthController@register` → tabel `pasiens`.
2. **Pasien Login**: POST `/login` → `AuthController@login`.
3. **Permintaan Pemeriksaan**: POST `/pasien/periksa` → `PasienController@storePeriksa` → `periksas` status `pending`.
4. **Dokter Antrian**: GET `/dokter/periksa` → `DokterController@periksa` → tampilkan DataTable.
5. **Update Pemeriksaan**: PUT `/dokter/periksa/{id}` → `DokterController@periksaUpdate` (simpan `catatan_dokter`, status `done`).
6. **CRUD Obat**: 
   - GET `/dokter/obat` → form + DataTable.
   - POST `/dokter/obat` → `DokterController@storeObat`.
   - PUT `/dokter/obat/{id}` → `DokterController@updateObat`.
   - DELETE `/dokter/obat/{id}` → `DokterController@destroyObat`.
7. **Riwayat Pasien**: GET `/pasien/riwayat` → `PasienController@riwayat` → DataTable.

## 5. Dependensi & Teknologi
- **Laravel 10.x**, **PHP 8.x**, **Composer**
- **AdminLTE** (Bootstrap 4)
- **jQuery**, **DataTables** (responsive, buttons)
- **AJAX & Modal**: CRUD obat tanpa reload penuh

## 6. Cara Penggunaan
1. `composer install`
2. `php artisan migrate`
3. `php artisan serve`
4. Akses di `http://localhost:8000`

## 7. User Stories / Demonstrasi

### 7.1 Pasien
- **Register Pasien**: Demonstrasikan pasien melakukan registrasi di `/register`.
- **Login Pasien**: Demonstrasikan pasien login menggunakan akun terdaftar.
- **Fitur Periksa**: Demonstrasikan pasien mengisi form periksa (`/pasien/periksa`), memasukkan keluhan, dan submit.

### 7.2 Dokter
- **Login Dokter**: Demonstrasikan dokter login di `/login` dengan role dokter.
- **Fitur Memeriksa**: Demonstrasikan dokter melihat daftar periksa pending, membuka detail periksa (`/dokter/periksa/{id}/edit`), mengisi `catatan_dokter`, dan submit.
- **Fitur CRUD Obat**: Demonstrasikan doktor menambah, mengedit, menghapus, dan melihat data obat di `/dokter/obat`.

### 7.3 Tampilan AdminLTE
- **Kesesuaian UI**: Demonstrasikan semua halaman menggunakan template AdminLTE (navigation, card, form, tabel) untuk tampilan konsisten.

---