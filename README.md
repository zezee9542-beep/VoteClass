# VoteClass - Sistem E-Voting Pemilihan Ketua Kelas

VoteClass adalah sebuah sistem aplikasi berbasis web (E-Voting) yang dirancang khusus untuk memfasilitasi proses pemilihan ketua kelas di lingkungan sekolah secara digital. Aplikasi ini dibangun menggunakan framework Laravel dan menawarkan antarmuka yang ramah pengguna serta fitur real-time untuk memantau hasil pemungutan suara.

Sistem ini memiliki tiga hak akses (role) utama: **Admin (Operator Sekolah)**, **Wali Kelas**, dan **Siswa**, di mana setiap role memiliki fungsi dan wewenang masing-masing yang terisolasi dengan aman.

---

## 🌟 Fitur Utama

### 1. Admin (Operator Sekolah)
Admin bertanggung jawab atas pengaturan sistem secara menyeluruh di tingkat sekolah.
*   **Manajemen Kelas**: Menambah, mengubah, dan menghapus data kelas yang ada di sekolah.
*   **Manajemen Wali Kelas**: Mendaftarkan akun untuk Wali Kelas dan menetapkan mereka ke kelas masing-masing.
*   **Pantauan Voting (Overview)**: Memantau status dan ringkasan hasil voting dari seluruh kelas secara global.

### 2. Wali Kelas
Wali Kelas bertindak sebagai panitia penyelenggara pemilihan di kelasnya masing-masing.
*   **Manajemen Data Siswa (Pemilih)**: Menambah, mengubah, atau menghapus data siswa yang berhak memilih di kelasnya (termasuk import/export data).
*   **Manajemen Kandidat**: Mendaftarkan calon ketua kelas (kandidat), lengkap dengan foto, visi, dan misi.
*   **Pantauan Real-time**: Memantau jalannya pemungutan suara di kelasnya secara *real-time* (live stats).
*   **Laporan Hasil Voting**: Melihat rekapitulasi hasil akhir pemungutan suara dan mengekspor hasilnya (PDF/Excel) untuk pelaporan.

### 3. Siswa (Pemilih)
Siswa menggunakan aplikasi untuk menyalurkan hak suaranya.
*   **Melihat Kandidat**: Siswa dapat melihat daftar kandidat calon ketua kelas beserta foto, visi, dan misi mereka.
*   **Voting**: Melakukan pemungutan suara dengan memilih salah satu kandidat secara rahasia dan aman (satu siswa, satu suara).
*   **Melihat Hasil**: (Opsional/Tergantung Pengaturan) Siswa dapat melihat hasil perolehan suara kelasnya setelah selesai memilih.

---

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dibangun menggunakan tumpukan teknologi (Tech Stack) modern:
*   **Backend**: [Laravel 11.x](https://laravel.com/) (PHP 8.x)
*   **Frontend**: Blade Templating Engine, HTML5, CSS3
*   **Styling**: [Tailwind CSS 4.x](https://tailwindcss.com/) (dengan Vite) / Bootstrap
*   **Database**: MySQL / MariaDB

---

## 🔄 Alur Penggunaan Aplikasi (Workflow)

Berikut adalah alur standar bagaimana aplikasi ini digunakan dari awal hingga proses pemilihan selesai:

1.  **Persiapan oleh Admin**:
    *   Admin login ke dalam sistem.
    *   Admin membuat data **Kelas** (misal: X IPA 1, X IPA 2).
    *   Admin membuat akun **Wali Kelas** dan menghubungkan wali kelas tersebut dengan kelas yang telah dibuat.
2.  **Persiapan oleh Wali Kelas**:
    *   Wali Kelas login menggunakan akun yang diberikan Admin.
    *   Wali Kelas mendaftarkan atau mengimpor data **Siswa** di kelasnya (siswa otomatis mendapatkan akun untuk login).
    *   Wali Kelas mendaftarkan **Kandidat** calon ketua kelas, mengunggah foto kandidat, serta mengisi visi dan misi.
3.  **Pelaksanaan Pemungutan Suara (Voting)**:
    *   Siswa login menggunakan akun masing-masing (misal: menggunakan NIS dan password).
    *   Siswa masuk ke menu "Pemilihan" dan membaca visi misi kandidat.
    *   Siswa menekan tombol **Vote** pada kandidat pilihan mereka (setelah memilih, tombol vote akan dinonaktifkan untuk mencegah *double voting*).
4.  **Monitoring dan Pelaporan**:
    *   Selama pemilihan berlangsung, Wali Kelas dapat melihat perolehan suara secara live di Dashboard.
    *   Setelah semua siswa memilih (atau waktu habis), Wali Kelas dapat mencetak **Hasil Voting** dan menyerahkannya sebagai laporan resmi.

---

## 🚀 Panduan Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di komputer lokal Anda.

### Prasyarat:
*   PHP >= 8.3
*   Composer
*   Node.js & npm
*   MySQL atau MariaDB

### Langkah Instalasi:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/zezee9542-beep/VoteClass.git
    cd VoteClass
    ```

2.  **Install Dependensi PHP (Composer)**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend (NPM)**
    ```bash
    npm install
    ```

4.  **Salin file Environment dan Generate Key**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan kredensial database Anda:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database_anda
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan Migrasi dan Seeder (Database)**
    *(Jika ada seeder untuk akun admin default)*
    ```bash
    php artisan migrate --seed
    ```

7.  **Jalankan Server Lokal dan Build Asset**
    Buka dua terminal terpisah:
    
    Terminal 1 (Menjalankan server PHP):
    ```bash
    php artisan serve
    ```
    
    Terminal 2 (Menjalankan Vite untuk Tailwind CSS):
    ```bash
    npm run dev
    ```

8.  **Akses Aplikasi**
    Buka browser Anda dan akses `http://localhost:8000`.

---

## 📄 Lisensi

Project ini bersifat open-source dan tersedia di bawah [Lisensi MIT](https://opensource.org/licenses/MIT). Silakan gunakan dan modifikasi sesuai kebutuhan Anda.

