# Cara Run Program
1.Download repo/clone repo ini

2.instal package

     composer install
3. Copy .env & generate key
   
php artisan key:generate

4. Atur `.env` untuk koneksi MySQL:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=toko_buku
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Buat database `toko_buku` di MySQL.
   
5.Jalankan migrasi & seeder

     php artisan migrate --seed

6.Buat symlink storage supaya cover buku bukti bayar bisa tampil

     php artisan storage:link

7.jalankan server

     php artisan serve

8.login (pass/emailnya udah ada di bawah form login)
