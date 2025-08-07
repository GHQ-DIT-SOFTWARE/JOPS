<?php

use App\Http\Controllers\Front\Dashboard\DashboardController;
use App\Http\Controllers\Front\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/login', [App\Http\Controllers\Login\AuthController::class, 'Login'])->name('login');
Route::get('/logout', [App\Http\Controllers\Login\AuthController::class, 'Logout'])->name('logout');

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/photo', [ProfileController::class, 'photo'])->name('photo');
    Route::get('/security', [ProfileController::class, 'security'])->name('security');
    Route::get('/signature', [ProfileController::class, 'signature'])->name('signature');
});
