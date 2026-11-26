<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Website ExploreLocal (publik)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinasi', [DestinationController::class, 'index'])->name('destinations.index');
Route::get('/destinasi/{destination:slug}', [DestinationController::class, 'show'])->name('destinations.show');

/*
|--------------------------------------------------------------------------
| Autentikasi (wisatawan & admin)
|--------------------------------------------------------------------------
*/
Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.submit');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.submit');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| Fitur wisatawan (harus login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/destinasi/{destination:slug}/ulasan', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/ulasan/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    Route::post('/destinasi/{destination:slug}/favorit', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorit', [FavoriteController::class, 'index'])->name('favorites.index');

    Route::get('/profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Dashboard Admin (backoffice)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('destinations', Admin\DestinationController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except(['show', 'create']);

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('reviews', [Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('reviews/{review}', [Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
});
