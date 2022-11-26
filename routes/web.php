<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\RuleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
            // Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
            // Route::get('/menu', [AdminController::class, 'menu'])->name('admin.menu');
            Route::resource('admin', AdminController::class);
            Route::resource('group', GroupController::class);
            Route::resource('rules', RuleController::class);
        });
    });

});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('auth.destroy');

Route::get('/', function () {
    return view('welcome');
});
