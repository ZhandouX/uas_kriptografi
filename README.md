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
   ![Wellcome: ](screnshot/WELLCOME.png)
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
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
      });
      ```
   b) Controller untuk Dashboard:
       Membuat file app/Http/Controllers/DashboardController.php dengan perintah:
       ```
       php artisan make:controller DashboardController
       ```
      Code :
       ```
           <?php

            namespace App\Http\Controllers;
            
            use Illuminate\Http\Request;
            
            class DashboardController extends Controller
            {
                public function index()
            {
                return view('dashboard');
            }
            
            }
       ```
   c) Perbarui rute di ```routes/web.php```:
       ```
       use App\Http\Controllers\DashboardController;
       
       Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
       ```
   d) Breeze secara otomatis sudah menyiap fungsi Logout.
8. Uji Coba Login dan Register:
   # Register:
   ![Wellcome: ](screnshot/REGISTER.png)
   # Login:
   ![Wellcome: ](screnshot/LOGIN.png)
   Saat User berhasil melakukan Register atau Login maka akan diarahkan ke halaman Dashboard:
   ![Wellcome: ](screnshot/DASHBOARD.png)

   Data user akan tersimpan di database yang sudah dibuat sebelumnya, tepatnya pada Tabel ```user```.
   ![Wellcome: ](screnshot/TBLUSER.png)


# Membuat middleware di Laravel untuk mencegah serangan XSS
1. Membuat Projek:
   ```
   composer create-project laravel/laravel xss-protection
   ```
   
2. Masuk ke File Projek:
   ```
   cd xss-protection
   ```
   
3. Membuat Middleware untuk Mencegah XSS:
   ```
   php artisan make:middleware XSSProtection
   ```
   
4. Edit file ```app/Http/Middleware/XSSProtection.php```:
   ```
   <?php

    use Illuminate\Foundation\Application;
    use Illuminate\Foundation\Configuration\Exceptions;
    use Illuminate\Foundation\Configuration\Middleware;
    use App\Http\Middleware\XSSProtection;
    
    return Application::configure(basePath: dirname(__DIR__))
        ->withRouting(
            web: __DIR__.'/../routes/web.php',
            commands: __DIR__.'/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
            $middleware->append(XSSProtection::class); // Tambahkan middleware di sini
        })
        ->withExceptions(function (Exceptions $exceptions) {
            //
        })->create();
   ```
   
5. Mendaftar Middleware di Kernel:
   Buka file ```app/Http/Kernel.php``` dan tambahkan middleware baru di grup ```web```:
   ```
    protected $middlewareGroups = [
        'web' => [
            // Middleware bawaan Laravel
            \App\Http\Middleware\XSSProtection::class, // Tambahkan ini
        ],
        'api' => [
            // Middleware API
        ],
    ];
   ```
   
6. Menguji Middleware:
   Buat controller untuk menguji middleware:
   ```
   php artisan make:controller XSSController
   ```

   Edit file ```app/Http/Controllers/XSSController.php```:
   ```
   <?php

    namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;
    
    class XSSController extends Controller
    {
        public function store(Request $request)
        {
            return response()->json([
                'clean_input' => $request->all(),
            ]);
        }
    }
   ```

   Tambahkan rute di ```routes/web.php```:
   ```
   use App\Http\Controllers\XSSController;
    
   Route::post('/xss-test', [XSSController::class, 'store']);
   ```

   Kirim request menggunakan cuURL:
   ```
   Starting Laravel development server: http://127.0.0.1:8000
   ```

   Jika middleware XSSProtection berjalan dengan benar, akan melihat output seperti ini:
   ```
   {
      "clean_input": {
        "input": "alert('xss')"
      }
   }
   ```

# Menambahkan logo sebagai watermark pada halaman login, navbar, dan footer menggunakan Laravel Blade.
1. Siapkan file gambar yang akan dijadikan sebagai logo watermark. Kemudian file gambar diletakkan di folder ```public/images/logo.png```.
2. Kemudian masuk ke projek aplikasi yaitu ```qrcode``` diatas, dan buka file             ```resources/views/layout/navigation.blade.php```. Dan ubah code ini:
    ```
    <x-application-logo src="{{ asset('images/custom-logo.png') }}" />
    ```
    Menjadi:
    ```
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
    ```
    
   Hasil :
   ![Wellcome: ](screnshot/LogoNav.png)
4. Lakukan hal yang sama untuk merubah logo pada footer dan otomatis akan merubah logo watermark pada halaman Login & Register:
   Hasil:
   ![Wellcome: ](screnshot/LogoLogin.png)
   ![Wellcome: ](screnshot/LogoRegistrasi.png)


