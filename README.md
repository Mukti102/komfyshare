# KomfyShare & KomfyChecker

Platform multifungsi yang menyediakan layanan berlangganan/berbagi akun (*KomfyShare*) serta layanan pengecekan dokumen profesional (*KomfyChecker*). 

Sistem ini dibangun menggunakan ekosistem **Laravel 11, Livewire v3, dan Filament v3** dengan antarmuka yang bersih, modern, dan sangat dioptimalkan untuk skalabilitas tinggi.

---

## 🚀 Fitur Utama

### 🛒 KomfyShare (Berbagi Akun / Berlangganan)
- **Katalog Produk:** Menampilkan berbagai layanan berlangganan dengan sistem *slot*.
- **Otomatisasi Stok:** Pengelolaan slot (*availability*) secara *real-time*.
- **Integrasi Pembayaran:** Terintegrasi penuh dengan **Tokopay Webhook** untuk deteksi pembayaran otomatis (Otomatis sukses / dibatalkan).

### 📄 KomfyChecker (Pengecekan Dokumen)
- **Formulir Dinamis:** Form pemesanan berbasis *Livewire* yang dinamis dengan kalkulasi harga secara *real-time*.
- **Upload Terpusat:** Sistem unggah file (PDF/DOCX) dengan batasan ukuran dan validasi yang ketat.
- **Auto-Cleanup:** Fitur pembersihan otomatis (*cron job*) untuk menghapus dokumen pelanggan yang lebih tua dari 30 hari demi menghemat kapasitas *server*.
- **Sistem Token & Kupon:** Pelanggan dapat membeli paket Token prabayar atau menggunakan kode kupon (persentase / nominal) saat proses *checkout*.
- **Lacak Pesanan (Track):** Halaman publik interaktif untuk memantau status pesanan (Pending, Processing, Completed).

### ⚙️ Admin & Manajemen (Filament Panel)
- **Dashboard Ganda:** Visualisasi data terpisah (Grafik & Tabel Statistik) antara *KomfyShare* dan *KomfyChecker*.
- **WhatsApp Testing Mode:** Pengaturan khusus untuk menguji coba notifikasi WhatsApp tanpa melakukan *spam* ke pelanggan.
- **Konfigurasi Dinamis:** Konfigurasi toko, SEO, dan API *Key* dapat diubah langsung melalui halaman Pengaturan (*Settings*).

---

## 🛠️ Stack Teknologi

- **Backend:** PHP 8.2+, Laravel 11.x
- **Frontend / Interaktif:** Livewire v3, Alpine.js
- **Styling:** Tailwind CSS (Mode Gelap yang disesuaikan)
- **Admin Panel:** Filament PHP v3
- **Payment Gateway:** Tokopay (via Webhook)
- **Notifikasi:** Wablas (WhatsApp API)

---

## 💻 Instalasi & Menjalankan di Lokal

### Persyaratan Sistem
- PHP >= 8.2
- Composer 2.x
- Node.js & NPM
- MySQL / MariaDB atau SQLite

### Langkah-langkah:
1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/username/komfyshare.git
   cd komfyshare
   ```

2. **Instal dependensi Composer & NPM:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Pengaturan Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Atur konfigurasi `DB_DATABASE`, `DB_USERNAME`, dll. pada file `.env`.*

4. **Jalankan Migrasi & Database Seeder:**
   ```bash
   php artisan migrate --seed
   ```

5. **Storage Link:**
   Agar fitur *upload file* (logo, dokumen) bisa diakses publik.
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   *Untuk Livewire & Tailwind-*nya:
   ```bash
   npm run dev
   ```

---

## 🔒 Catatan Keamanan (*Production*)

Saat akan melakukan *deploy* ke **Server Production**, sangat penting untuk memverifikasi hal berikut di dalam file `.env`:
- `APP_ENV=production`
- `APP_DEBUG=false` (Wajib, untuk mencegah tereksposnya struktur database/kode apabila terjadi *error*)
- Jangan lupa menyalakan *Cron Job* pada panel *hosting/server* Anda dengan target perintah `php artisan schedule:run` untuk mengaktifkan pembersihan file otomatis (`checker:cleanup-files`) dan fitur *Reminder*.

---

## 📝 Lisensi
Proyek ini dibuat untuk keperluan internal. Semua struktur basis data dan arsitektur berada di bawah hak cipta pengembang.
