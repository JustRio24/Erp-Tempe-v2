# Sistem ERP UMKM Tempe 3 Puteri 🌿

Sistem ERP (Enterprise Resource Planning) yang dirancang khusus untuk UMKM Tempe 3 Puteri. Website ini mengintegrasikan modul Inventori, Produksi, Penjualan (E-commerce), dan Keuangan dalam satu platform yang user-friendly dan responsif.

## ✨ Fitur Utama

### 🏛️ Modul Admin (Dashboard Internal)
- **Dashboard Terintegrasi**: Statistik real-time untuk stok, pesanan, dan laba rugi.
- **Prakiraan Cuaca 7 Hari**: Integrasi WeatherAPI untuk membantu perencanaan produksi berdasarkan suhu (fermentasi tempe sangat bergantung pada cuaca).
- **Manajemen Produk**: Kelola katalog, harga normal, harga grosir, dan penyesuaian stok manual.
- **Siklus Produksi 4 Hari**: Pelacakan batch produksi tempe dari tahap peragian hingga panen dengan pencatatan kegagalan produksi.
- **Manajemen Pesanan**: Proses pesanan masuk dari pelanggan dan update status pengiriman/pembayaran.
- **Laporan Keuangan**: Pencatatan pengeluaran manual dan laporan laba rugi otomatis dari data penjualan.

### 🛒 Modul Pelanggan (E-commerce)
- **Katalog Produk**: Tampilan produk premium dengan detail lengkap dan info stok.
- **Sistem Keranjang**: Penambahan produk ke keranjang belanja dengan perhitungan harga grosir otomatis.
- **Guest Checkout**: Pelanggan dapat berbelanja tanpa harus login (registrasi opsional).
- **Simulasi Pembayaran**: Pilihan metode Transfer Bank dan COD (Cash on Delivery).

## 🛠️ Tech Stack
- **Framework**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS (via Breeze)
- **Database**: MySQL
- **Asset Bundler**: Vite
- **Integrasi API**: WeatherAPI.com (Prakiraan Cuaca)

## 🚀 Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan project di lingkungan lokal:

### 1. Persyaratan Sistem
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### 2. Clone Project & Install Dependencies
```bash
# Clone repository ini (jika ada) atau masuk ke direktori project
cd Erp-Tempe-v2

# Install PHP dependencies
composer install

# Install JS dependencies
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database Anda:
```bash
cp .env.example .env
```
Edit bagian database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tempe_db
DB_USERNAME=root
DB_PASSWORD=

# Tambahkan API Key WeatherAPI (Opsional untuk fitur cuaca)
# WEATHER_API_KEY=ad6b5989479b485286390913252502
```

### 4. Setup Database & Key
```bash
# Generate application key
php artisan key:generate

# Jalankan migrasi dan seeder awal
php artisan migrate --seed
```

### 5. Build Assets & Jalankan Server
```bash
# Compile assets (Tailwind/Vite)
npm run dev

# Jalankan web server Laravel (buka tab terminal baru)
php artisan serve
```
Website dapat diakses di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## 🔑 Akun Akses Default (Admin)
- **Email**: `admin@tempe3puteri.local`
- **Password**: `password`

## 📂 Struktur Project Penting
- `app/Http/Controllers/Admin`: Logika manajemen internal ERP.
- `app/Models`: Definisi skema database dan relation (Produk, Batch, Order, Finance).
- `app/Services`: WeatherService untuk integrasi API Cuaca.
- `resources/views`: Template tampilan (Admin, Katalog, Cart, Checkout, Auth).
- `routes/web.php`: Definisi semua route aplikasi.

---
**UMKM Tempe 3 Puteri** - *Membawa Kualitas Tradisional ke Era Digital.*
