## PROJECT UAS
# Implementasi Fitur Autentikasi Menggunakan Laravel Breeze
1. Membuat Project Baru:  
   ```
   composer create-project laravel/laravel qrcode
   ```
2. Masuk ke File Project:
   ```
   cd qrcode
   ```
3. Install Laravel Breeze:
   ```
   composer require laravel/breeze --dev
   ```
   Kemudian pilih ```blade```--> Untuk proyek berbasis Blade (sederhana dan ringan) dan juga agar fokus pada autentikasi dasar.
4. Migrasi Database:
   Mengubah pengaturan database di file ```.env```:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=qr_codes
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Perubahan:
            ```DB_CONNECTION=sqlite``` --> ```DB_CONNECTION=mysql``` Karena pada dasarnya MySQL memiliki kelebih Dukungan Penuh dan Cocok Untuk Aplikasi Besar.
            ```DB_DATABASE=Laravel``` --> ```DB_DATABASE=qr_code``` Menyesuaikan dengan nama database yang dibuat sebelumnya.
5. Membuat Tabel:
   Jalankan migrasi untuk membuat tabel pengguna dan tabel terkait autentikasi:
   ```
   php artisan migrate
   ```
6. Menjalankan Aplikasi:
   ```
   php artisan serve
   ```
   Kemudian ```Ctrl + Klik[http://127.0.0.1:8000]```
   ![Wellcome: ](screenshot/WELLCOME.png)
   Breeze akan menyiapkan rute seperti:
   - ```/register``` --> Registrasi
   - ```/login``` --> Login
   - ```/dashboard``` --> Dashboard (memerlukan autentikasi)
7. Contoh Code:
   Semua rute yang berkaitan dengan autentikasi berada di          ```routes/auth.php```. Ini di impor secara otomatis ke dalam Aplikasi.
   a) Code middleware pada ```routes/web.php```:
      ```
      Route::post('/login', [LoginController::class, 'store'])
        ->middleware(VerifyRecaptcha::class)
        ->name('login');

      Route::post('/register', [RegisterController::class, 'store'])
        ->middleware(VerifyRecaptcha::class)
        ->name('register');

      Route::get('/', function () {
        return view('welcome');
      });

      Route::get('/dashboard', function () {
        return view('dashboard');
      })->middleware(['auth', 'verified'])->name('dashboard');

      Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class,                 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class,             'destroy'])->name('profile.destroy');
      });
      ```
