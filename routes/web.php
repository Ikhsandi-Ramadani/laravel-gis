<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\KecamatanController;


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::post('proses_registrasi', [AuthController::class, 'proses_registrasi'])->name('proses_registrasi');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:admin']], function () {
        Route::get('/', function () {
            return view('pages.dashboard.index');
        })->name('dashboard');
        Route::resource('kecamatan', KecamatanController::class);
        Route::resource('pengawas', PengawasController::class);
        Route::get('monitoring', [ProjectController::class, 'monitoring'])->name('monitoring');
        Route::resource('project', ProjectController::class);
    });
    Route::group(['middleware' => ['cek_login:pengawas']], function () {
        Route::resource('editor', AdminController::class);
    });
});
