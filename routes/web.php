<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ReplyController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Client\ApplyController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeCookieRedirect', 'isWhitelistIp']
], function() {

    Route::prefix('/admin269')->group(function(){
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('auth.login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('auth.store');

        Route::middleware('auth')->group(function() {
            Route::get('index', [HomeController::class, 'index'])->name('home.index');
            Route::get('dashboard', [HomeController::class, 'dashboard'])->name('home.dashboard');
            Route::get('menu', [HomeController::class, 'menu'])->name('home.menu');
            Route::post('upload', [HomeController::class, 'upload_poster'])->name('home.upload');
            Route::get('cancel-upload', [HomeController::class, 'cancel_upload'])->name('home.activity_flush');

            Route::resource('admin', AdminController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('activity', ActivityController::class);
            Route::resource('reply', ReplyController::class);

            Route::controller(SystemController::class)->as('system.')->group(function () {
                Route::get('log', 'log')->name('log');
                Route::get('showlog/{id}', 'show_log')->name('show-log');
                Route::match(['get', 'put'], 'whitelist', 'whitelist')->name('whitelist');
                Route::match(['get', 'put'], 'announcement', 'announcement')->name('announcement');
            });

            Route::controller(TicketController::class)
                ->prefix('tickets')
                ->as('ticket.')
                ->group(function () {
                    Route::get('pending', 'pending')->name('pending');
                    Route::get('audited', 'audited')->name('audited');
                    Route::get('chart', 'chart')->name('chart');
                    Route::put('accept', 'accept')->name('accept');
                    Route::put('reject', 'reject')->name('reject');
                    Route::put('update', 'update')->name('update');
                    Route::get('export', 'export')
                        ->withoutMiddleware(['localeSessionRedirect', 'localizationRedirect', 'localeCookieRedirect'])
                        ->name('export');
                    Route::get('export-progress', 'updateExportProgress')->name('export-progress');
                    Route::get('download-export', 'downloadExport')
                        ->withoutMiddleware(['localeSessionRedirect', 'localizationRedirect', 'localeCookieRedirect'])
                        ->name('download-export');
                }
            );
        });
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('auth.destroy');
});


Route::get('/', [ApplyController::class, 'index'])->name('client.index');
