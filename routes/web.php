<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetAbsensiController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\GetPenilaianController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\InputNilaiSikapController;
use App\Http\Controllers\PrintAbsensiController;
use App\Http\Controllers\PrintRaporController;
use App\Http\Controllers\UploadNilaiController;
use App\Http\Controllers\UploadNilaiSikapController;

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
        Route::post('get-jenis-sikap', 'get_jenis_sikap')->name('get-jenis-sikap');
        Route::post('get-kategori-nilai', 'get_kategori_nilai')->name('get-kategori-nilai');
        Route::post('get-kelas', 'get_kelas')->name('get-kelas');
        Route::post('get-kelas-wali', 'get_kelas_wali')->name('get-kelas-wali');
        Route::post('get-siswa', 'get_siswa')->name('get-siswa');
    });

    //Route Get Absensi
    Route::controller(GetAbsensiController::class)->group(function () {
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
    });

    // Route Get Nilai dan Penilaian
    Route::controller(GetPenilaianController::class)->group(function () {
        Route::post('get-nilai-siswa', 'get_nilai_siswa')->name('get-nilai-siswa');
        Route::post('get-nilai-sikap', 'get_nilai_sikap')->name('get-nilai-sikap');
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

    // Route Input Nilai
    Route::controller(InputNilaiController::class)->group(function () {
        Route::get('input-nilai', 'index')->name('input-nilai');
        Route::post('input-nilai/simpan', 'simpan')->name('input-nilai.simpan');
    });

    // Route Input Nilai Sikap
    Route::controller(InputNilaiSikapController::class)->group(function () {
        Route::get('input-nilai-sikap', 'index')->name('input-nilai-sikap');
        Route::post('input-nilai-sikap/simpan', 'simpan')->name('input-nilai-sikap.simpan');
    });

    //Route Print Kehadiran
    Route::controller(PrintAbsensiController::class)->group(function () {
        Route::get('print-absensi', 'index')->name('print-absensi');
        Route::get('print-absensi/print-per-bulan', 'print_per_bulan')->name('print-absensi.print-per-bulan');
        Route::get('print-absensi/print-per-semester', 'print_per_semester')->name('print-absensi.print-per-semester');
    });

    // Route Upload Nilai
    Route::controller(UploadNilaiController::class)->group(function () {
        Route::get('upload-nilai', 'index')->name('upload-nilai');
        Route::get('upload-nilai/export', 'export')->name('upload-nilai.export');
        Route::post('upload-nilai/import', 'import')->name('upload-nilai.import');
    });

    // Route Upload Nilai Sikap
    Route::controller(UploadNilaiSikapController::class)->group(function () {
        Route::get('upload-nilai-sikap', 'index')->name('upload-nilai-sikap');
        Route::get('upload-nilai-sikap/export', 'export')->name('upload-nilai-sikap.export');
        Route::post('upload-nilai-sikap/import', 'import')->name('upload-nilai-sikap.import');
    });

    // Route Print Rapor
    Route::controller(PrintRaporController::class)->group(function () {
        Route::get('print-rapor', 'index')->name('print-rapor');
        Route::get('print-rapor/print', 'print')->name('print-rapor.print');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
