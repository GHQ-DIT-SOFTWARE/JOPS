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
use App\Http\Controllers\PartoneController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BroadcastController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\DutyRosterController;


use App\Http\Controllers\DG\DGController;
use App\Http\Controllers\DLAND\DLANDController;
use App\Http\Controllers\Doffr\DoffrController;
use App\Http\Controllers\DclerkController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\Auth\PasswordChangeController;


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





// For DG routes
Route::middleware(['auth', 'role:' . User::ROLE_DG . ',' . User::ROLE_SUPERADMIN])
    ->prefix('dg')
    ->as('dg.')
    ->group(function () {
        Route::get('/dashboard', [DGController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports/awaiting-approval', [DGController::class, 'awaitingReports'])->name('reports.awaiting');
        Route::get('/reports/approved', [DGController::class, 'approvedReports'])->name('reports.approved');
        Route::get('/reports/{id}/view', [DGController::class, 'viewReport'])->name('reports.view');
        Route::get('/reports/{id}/approve-form', [DGController::class, 'showApproveForm'])->name('reports.approve-form');
        Route::post('/reports/{id}/approve', [DGController::class, 'approveReport'])->name('reports.approve');
        Route::post('/reports/{id}/comment', [DGController::class, 'addComment'])->name('reports.comment');

        Route::put('/reports/{id}/update-comment', [DGController::class, 'updateComment'])->name('reports.updateComment');

    });

// For DLAND routes
Route::middleware(['auth', 'role:' . User::ROLE_DLAND . ',' . User::ROLE_SUPERADMIN])
    ->prefix('dland')
    ->as('dland.')
    ->group(function () {
        Route::get('/dashboard', [DLANDController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports/pending', [DLANDController::class, 'pendingReports'])->name('reports.pending'); 
        Route::get('/reports/awaiting', [DLANDController::class, 'awaitingReports'])->name('reports.awaiting'); 
        Route::get('/reports/approved', [DLANDController::class, 'approvedReports'])->name('reports.approved');
        Route::get('/reports/{id}/view', [DLANDController::class, 'viewReport'])->name('reports.view'); 
        Route::post('/reports/{id}/review', [DLANDController::class, 'reviewReport'])->name('reports.review');
         Route::put('/reports/{id}/update-comment', [DLANDController::class, 'updateComment'])->name('reports.updateComment');
    });


Route::middleware(['auth', 'role:' . User::ROLE_SUPERADMIN])
    ->prefix('superadmin')
    ->as('superadmin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/mails', [MailsController::class, 'mails'])->name('mails');

    


        Route::get('/scheduler', [SchedulerController::class, 'scheduler'])->name('scheduler');
        Route::get('/partone', [PartoneController::class, 'partone'])->name('partone');
        Route::get('/setting', [SettingsController::class, 'setting'])->name('setting');
        Route::get('/broadcast', [BroadcastController::class, 'broadcast'])->name('broadcast');

        Route::get('/operation', [OperationController::class, 'operation'])->name('operation');
        
        // Users
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('list');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/ajax', [UserController::class, 'usersAjax'])->name('ajax');
        });

    });


Route::prefix('profile')->middleware('auth')->group(function () {
    Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');
    Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
    Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');

    Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
    Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
});



// For DOFFR routes
Route::middleware(['auth', 'role:' . User::ROLE_DOFFR . ',' . User::ROLE_SUPERADMIN])
    ->prefix('doffr')
    ->as('doffr.')
    ->group(function () {
        Route::get('/dashboard', [DoffrController::class, 'dashboard'])->name('dashboard');
        
        // Doffr notifications routes (using DoffrController)
        Route::get('/notifications', [DoffrController::class, 'getNotifications'])->name('notifications');
        Route::post('/notification/{id}/read', [DoffrController::class, 'markNotificationRead'])->name('notification.read');

        
        
        // Reports
        Route::prefix('reports')->as('reports.')->group(function () {
            // Report Views
            Route::get('/dutyreport', [DoffrController::class, 'dutyReport'])->name('dutyreport');
            Route::get('/addreport', [DoffrController::class, 'add'])->name('addreport');
            Route::get('/{id}/view', [DoffrController::class, 'view'])->name('view');
            Route::get('/dailysitrep', [DoffrController::class, 'dailySitrep'])->name('dailysitrep');

            // Report Step Saving
            Route::post('/save-step', [DoffrController::class, 'saveStep'])->name('saveStep');  
            Route::post('/submit', [DoffrController::class, 'submit'])->name('submit');  

            // Report Store (for non-AJAX submit)
            Route::post('/store', [DoffrController::class, 'store'])->name('store');  

            // Report Edit + Update
            Route::get('/{id}/edit', [DoffrController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DoffrController::class, 'update'])->name('update');
        });
    });


Route::middleware(['auth', 'role:' . User::ROLE_SUPERADMIN . ',' . User::ROLE_DCLERK])
    ->group(function () {
        Route::get('duty-roster', [DutyRosterController::class, 'index'])->name('duty-roster.index');
        Route::post('duty-roster', [DutyRosterController::class, 'store'])->name('duty-roster.store');
        Route::post('duty-roster/submit', [DutyRosterController::class, 'submitRoster'])->name('duty-roster.submit');
        Route::post('duty-roster/publish', [DutyRosterController::class, 'publishRoster'])->name('duty-roster.publish');
        Route::delete('duty-roster/{id}', [DutyRosterController::class, 'destroy'])->name('duty-roster.destroy');
        Route::get('duty-roster/account-status', [DutyRosterController::class, 'getAccountStatus'])->name('duty-roster.account-status');

        Route::get('duty-roster/manage-officers', [DutyRosterController::class, 'manageOfficers'])->name('duty-roster.manage-officers');
        Route::post('duty-roster/add-officer', [DutyRosterController::class, 'addOfficer'])->name('duty-roster.add-officer');
        Route::post('duty-roster/update-available-officers', [DutyRosterController::class, 'updateAvailableOfficers'])->name('duty-roster.update-available-officers');
        
        // Duty Roster extra duty and notifications (using DutyRosterController)
        Route::post('/duty-roster/extra-duty', [DutyRosterController::class, 'addExtraDuty'])->name('duty-roster.extra-duty');
        Route::get('/duty-roster/notifications', [DutyRosterController::class, 'getNotifications'])->name('duty-roster.notifications');
        Route::post('/duty-roster/notification/{id}/read', [DutyRosterController::class, 'markNotificationRead'])->name('duty-roster.notification.read');
    


Route::prefix('dclerk')->group(function () {
    Route::get('/dashboard', [DclerkController::class, 'dashboard'])->name('dclerk.dashboard');
    Route::get('/accounts', [DclerkController::class, 'manageAccounts'])->name('dclerk.accounts');
    Route::post('/create-accounts', [DclerkController::class, 'createAccounts'])->name('dclerk.create-accounts');
    Route::get('/communication', [DclerkController::class, 'officerCommunication'])->name('dclerk.communication');
    Route::get('/reports', [DclerkController::class, 'accountReports'])->name('dclerk.reports');
    Route::get('/roster', [DclerkController::class, 'viewRoster'])->name('dclerk.roster.view');
    Route::get('/password-list', [DclerkController::class, 'showPasswords'])->name('dclerk.password-list');
});

});

Route::post('/dclerk/regenerate-temp-password/{userId}', [DclerkController::class, 'regenerateTempPassword'])
    ->name('dclerk.regenerate-temp-password');

// Single SMS route
Route::post('/dclerk/send-sms/{user}', [CommunicationController::class, 'sendSms'])
    ->name('dclerk.sendSms');

// Bulk communication route  
Route::post('/dclerk/send-bulk', [CommunicationController::class, 'sendBulk'])
    ->name('dclerk.sendBulkCommunication');

Route::get('/ck', function () {
    return view('dutyofficer');
});


