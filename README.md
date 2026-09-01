# EPILKETOS - Sistem E-Voting Pemilihan Ketua OSIS

Sistem Informasi E-Voting Pemilihan Ketua OSIS (EPILKETOS) berbasis Web & Mobile-First.
Di-upgrade dari CodeIgniter 3 ke **Laravel 11** untuk performa yang lebih baik, kode yang lebih terstruktur, dan antarmuka *mobile-first* yang optimal digunakan oleh pemilih melalui smartphone.

## 🚀 Fitur Utama

*   **Mobile-First Voting:** Antarmuka pemungutan suara didesain 100% responsif dan dioptimalkan untuk layar HP.
*   **Dual Authentication:** Login terpisah yang aman untuk Admin dan Siswa (Pemilih).
*   **Keamanan Terjamin:** Password di-hash menggunakan `Bcrypt`, anti double-vote, dan proteksi multi-step konfirmasi.
*   **Manajemen DPT Mudah:** Dukungan import Data Pemilih Tetap (DPT) massal menggunakan format Excel.
*   **Laporan Otomatis:** Export hasil voting dan daftar hadir dalam format PDF (DomPDF).
*   **Real-time Dashboard:** Pantau hasil perolehan suara secara langsung di panel admin.

---

## 🛠️ Persyaratan Sistem

Pastikan server atau lokal environment Anda memenuhi spesifikasi berikut:
*   PHP >= 8.2
*   Composer >= 2.0
*   MySQL >= 8.0 (atau MariaDB setara)
*   Web Server (Apache/Nginx/Laragon)

---

## 📥 Panduan Instalasi (Development)

Ikuti langkah-langkah berikut untuk menginstall dan menjalankan aplikasi di komputer lokal (misal: menggunakan Laragon / XAMPP):

1. **Clone Repository**
   ```bash
   git clone -b production https://github.com/fikihar/EPILKETOS.git
   cd EPILKETOS
   ```

2. **Install Dependensi PHP**
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan koneksi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_pilketos
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Buat Database**
   Buat database kosong bernama `db_pilketos` (atau sesuai nama di `.env`) pada MySQL/phpMyAdmin Anda.

6. **Jalankan Migrasi & Seeder Database**
   Perintah ini akan membuat struktur tabel beserta data awal (Data Admin, Identitas Sekolah, dan Data Kelas).
   ```bash
   php artisan migrate --seed
   ```

7. **Storage Link (Opsional tapi direkomendasikan)**
   Untuk menampilkan foto kandidat secara publik, jalankan:
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Aplikasi**
   Jika menggunakan Laragon, aplikasi biasanya bisa diakses via `http://epilketos.test`. Jika tidak, jalankan server bawaan artisan:
   ```bash
   php artisan serve
   ```
   Akses di browser: `http://localhost:8000`

---

## 👑 Uji Coba Panel Admin

Panel admin digunakan oleh panitia/guru untuk mengelola semua data sebelum dan sesudah pemilihan.

1. Buka URL halaman admin:
   `http://localhost:8000/admin` (atau `http://epilketos.test/admin/login`)
2. Login menggunakan kredensial default bawaan seeder:
   *   **Username:** `admin`
   *   **Password:** `admin`
3. **Hal yang bisa Anda lakukan di Admin Panel:**
   *   **Identitas Sekolah:** Ubah logo, nama sekolah, dan nama panitia Pilketos.
   *   **Manajemen Kelas:** Tambah/Edit data kelas.
   *   **Manajemen Kandidat:** Tambahkan paslon dan upload foto kandidat (disarankan rasio portrait 3:4).
   *   **Manajemen DPT (Siswa):** 
       *   Anda bisa menambahkan siswa manual, ATAU
       *   **Download Template Excel** yang tersedia, isi data DPT Anda, lalu **Import** sekaligus!
   *   **Pantau Suara:** Lihat grafik / bar perolehan suara langsung di menu Dashboard.
   *   **Cetak Laporan:** Cetak Laporan Hasil Voting & Daftar Hadir (PDF) di menu Cetak Laporan.

---

## 📱 Uji Coba Portal Siswa (Voting)

Digunakan oleh siswa untuk memberikan suara melalui HP/Komputer.

1. Buka URL landing page aplikasi (misal menggunakan HP):
   `http://localhost:8000` (atau `http://epilketos.test`)
2. Klik tombol **Login Pemilih**.
3. Login menggunakan data siswa yang sudah ada di database (DPT).
   *   **Username:** `(Gunakan NISN siswa)`
   *   **Password Default:** `(Sama dengan NISN siswa)`
4. **Alur Voting:**
   *   Siswa akan melihat kartu para kandidat secara vertikal.
   *   Klik tombol **PILIH** pada kandidat yang diinginkan.
   *   Akan muncul **Modal Konfirmasi (2 Langkah)** untuk meyakinkan pilihan.
   *   Setelah sukses memilih, akun siswa otomatis ter-*logout* dan siswa tersebut tidak bisa login/memilih lagi.

---

## 📝 Lisensi
Proyek ini dikembangkan khusus untuk SMKS Walisongo Pecangaan, Jepara.
Developer & Owner: **fikihar**
