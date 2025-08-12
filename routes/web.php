<?php

// use App\Http\Controllers\Front\Dashboard\DashboardController;
// use App\Http\Controllers\Front\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\User;

use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\MailsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;


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

Route::prefix('profile')->group(function () {

    Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
    Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
    Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
    Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
    Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');

});


Route::middleware(['auth', 'role:' . User::ROLE_SUPPERADMIN])
    ->prefix('superadmin')
    ->as('superadmin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/mails', [MailsController::class, 'mails'])->name('mails');

    Route::prefix('reports')->group(function () {
        Route::get('/dutyreport', [ReportsController::class, 'dutyReport'])->name('dutyreport.view');
        Route::get('/dailysitrep', [ReportsController::class, 'dailySitrep'])->name('dailysitrep.view');
    });

    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('list');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/ajax', [UserController::class, 'usersAjax'])->name('ajax');
    });

});


Route::middleware(['auth', 'role:' . User::ROLE_DG])
    ->prefix('dg')
    ->as('dg.')
    ->group(function () {
        Route::get('/dashboard', [DGDashboardController::class, 'index'])->name('dashboard');
    });
