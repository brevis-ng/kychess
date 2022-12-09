<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController;
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

            Route::match(['get', 'post'], 'log', [HomeController::class, 'log'])->name('home.log');
            Route::match(['get', 'post'], 'whitelist', [HomeController::class, 'whitelist'])->name('home.whitelist');
            Route::match(['get', 'post'], 'announcement', [HomeController::class, 'announcement'])->name('home.announcement');
        });
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('auth.destroy');
});


Route::get('/', function () {
    return view('welcome');
});
