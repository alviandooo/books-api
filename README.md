# books-api

## Tutorial Instalasi Project

Berikut adalah langkah-langkah untuk menginstalasi project ini:

1. **Clone Repository**
   Pertama, clone repository ini ke dalam komputer Anda menggunakan perintah berikut:
   ```
   git clone https://github.com/alviandooo/books-api.git
   ```

2. **Masuk ke Direktori Project**
   Setelah proses cloning selesai, masuk ke dalam direktori project:
   ```
   cd books-api
   ```

3. **Instalasi Dependensi**
   Pastikan Anda sudah menginstal Composer. Kemudian, jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
   ```
   composer install
   ```

4. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database dan pengaturan lainnya sesuai kebutuhan Anda:
   ```
   cp .env.example .env
   ```

5. **Generate Key Aplikasi**
   Jalankan perintah berikut untuk menghasilkan kunci aplikasi:
   ```
   php artisan key:generate
   ```

6. **Migrasi Database**
   Jalankan migrasi untuk membuat tabel-tabel yang diperlukan di database:
   ```
   php artisan migrate --seed
   ```

7. **Menjalankan Server**
   Setelah semua langkah di atas selesai, Anda dapat menjalankan server lokal dengan perintah:
   ```
   php artisan serve
   ```

8. **Akses API**
   Anda dapat mengakses API melalui `http://localhost:8000/api`.


9. **Database yang Digunakan**
   Project ini menggunakan database PostgreSQL. Pastikan Anda telah menginstal PostgreSQL dan mengonfigurasi koneksi database di file `.env`.

10. **Postman Collection**
    Anda dapat mengunduh koleksi Postman untuk API ini melalui link berikut: [Download Postman Collection](https://drive.google.com/file/d/1q5GPeQ7fjLIB9nm0tWtg4Jg_qWMgToN8).

Selamat, Anda telah berhasil menginstalasi project ini!


