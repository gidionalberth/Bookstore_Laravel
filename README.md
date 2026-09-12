# Cara Run Program
1.Download repo/clone repo ini dan buat project laravel baru
   ```
   composer create-project laravel/laravel bookstore
   cd bookstore
   ```

2.Copy semua file dari folder ini ke dalam project Laravel yang baru dibuat,
   timpa/gabungkan folder berikut:
   - `app/Models/*`
   - `app/Http/Controllers/*`
   - `app/Http/Middleware/AdminMiddleware.php`
   - `database/migrations/*`
   - `database/seeders/DatabaseSeeder.php`
   - `routes/web.php`
   - `resources/views/*`

3.Daftarkan middleware `admin`.

   **Laravel 11+** (edit `bootstrap/app.php`):
   ```php
   ->withMiddleware(function (Middleware $middleware) {
       $middleware->alias([
           'admin' => \App\Http\Middleware\AdminMiddleware::class,
       ]);
   })
   ```

   **Laravel 10** (edit `app/Http/Kernel.php`, tambahkan di `$routeMiddleware`):
   ```php
   'admin' => \App\Http\Middleware\AdminMiddleware::class,
   ```
4.Atur `.env` untuk koneksi MySQL:
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
