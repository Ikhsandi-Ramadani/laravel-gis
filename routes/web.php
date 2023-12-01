<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PengawasController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pengawas\DashboardController;
use App\Http\Controllers\Pengawas\LaporanController;
use Spatie\FlareClient\View;

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::post('proses_registrasi', [AuthController::class, 'proses_registrasi'])->name('proses_registrasi');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {

    Route::prefix('admin')->middleware('cek_login:admin')->group(function () {
        Route::get('/', function () {
            return view('admin.pages.dashboard.index');
        })->name('dashboard');
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('pengawas', PengawasController::class);
        Route::get('monitoring', [ProjectController::class, 'monitoring'])->name('monitoring');
        Route::resource('project', ProjectController::class);
    });

    Route::prefix('pengawas')->middleware('cek_login:pengawas')->group(function () {
        Route::get('/', DashboardController::class)->name('pengawas.dashboard');
        Route::prefix('{project_id}/laporan')->name('laporan.')->group(function () {
            Route::get('', [LaporanController::class, 'index'])->name('index');
            Route::post('', [LaporanController::class, 'store'])->name('store');
            Route::put('{id}', [LaporanController::class, 'update'])->name('update');
            Route::delete('{id}', [LaporanController::class, 'destroy'])->name('destroy');
        });
    });
});
