<?php

use App\Http\Controllers\DataObatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatKeluarController;
use App\Http\Controllers\ObatMasukController;
use App\Http\Controllers\PrediksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrediksiHistorisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('obat', ObatController::class);
    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi.index');
    Route::post('/prediksi', [PrediksiController::class, 'predict'])->name('prediksi.predict');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::post('/save', [PrediksiController::class, 'savePrediction'])->name('save');
    Route::post('laporan/download', [LaporanController::class, 'downloadPDF'])->name('download_pdf');   
    Route::get('/historis', [PrediksiHistorisController::class, 'index'])->name('historis');
});
