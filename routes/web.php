<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\VerifyRecaptcha;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HomeController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/create-qrcode', [QrCodeController::class, 'createQrCodeForm'])->name('create-qrcode');
    Route::post('/store-qrcode', [QrCodeController::class, 'createQrCode'])->name('store-qrcode');
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::get('/menu', [MenuController::class, 'menu'])->name('menu');
    Route::get('/home', [HomeController::class, 'home'])->name('home');
});

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

require __DIR__.'/auth.php';
