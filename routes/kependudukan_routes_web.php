<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Penduduk Routes
Route::resource('penduduk', PendudukController::class);

// Keluarga Routes
Route::resource('keluarga', KeluargaController::class);
Route::post('keluarga/{keluarga}/anggota', [KeluargaController::class, 'addAnggota'])->name('keluarga.addAnggota');
Route::delete('keluarga/{keluarga}/anggota/{hubungan}', [KeluargaController::class, 'removeAnggota'])->name('keluarga.removeAnggota');
