<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetAbsensiController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\PrintAbsensiController;

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
    return inertia('Auth/Login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware([
    'auth',
    'role:Admin|Guru|Kepala Sekolah|Kesiswaan|Kurikulum'
])->group(function () {

    //Route Get Data
    Route::controller(GetDataController::class)->group(function () {
        Route::post('get-ekstrakurikuler', 'get_ekstrakurikuler')->name('get-ekstrakurikuler');
        Route::post('get-jenis-penilaian', 'get_jenis_penilaian')->name('get-jenis-penilaian');
        Route::post('get-kategori-nilai', 'get_kategori_nilai')->name('get-kategori-nilai');
        Route::post('get-kelas', 'get_kelas')->name('get-kelas');
        Route::post('get-siswa', 'get_siswa')->name('get-siswa');
    });

    //Route Get Absensi
    Route::controller(GetAbsensiController::class)->group(function () {
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
    });


    // Batas Route Menu dan Route Get Data

    // Route Absensi
    Route::controller(AbsensiController::class)->group(function () {
        Route::get('absensi', 'index')->name('absensi');
        Route::post('absensi/simpan', 'simpan')->name('absensi.simpan');
        Route::post('absensi/nihil', 'nihil')->name('absensi.nihil');
    });

    // Route Absensi Ujian
    Route::controller(AbsensiUjianController::class)->group(function () {
        Route::get('absensi-ujian', 'index')->name('absensi-ujian');
        Route::post('absensi-ujian/simpan', 'simpan')->name('absensi-ujian.simpan');
        Route::post('absensi-ujian/nihil', 'nihil')->name('absensi-ujian.nihil');
    });

    //Route Print Kehadiran
    Route::controller(PrintAbsensiController::class)->group(function () {
        Route::get('print-absensi', 'index')->name('print-absensi');
        Route::get('print-absensi/print-per-bulan', 'print_per_bulan')->name('print-absensi.print-per-bulan');
        Route::get('print-absensi/print-per-semester', 'print_per_semester')->name('print-absensi.print-per-semester');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
