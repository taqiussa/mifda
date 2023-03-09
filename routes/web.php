<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GetAbsensiController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\AturGuruKelasController;
use App\Http\Controllers\AturKurikulumController;
use App\Http\Controllers\GetPenilaianController;
use App\Http\Controllers\InputCatatanController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\InputNilaiEkstrakurikulerController;
use App\Http\Controllers\InputNilaiSikapController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MataPelajaranController;
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
    'role:Admin|Bendahara|Guru|Kepala Sekolah|Kesiswaan|Kurikulum'
])->group(function () {

    //Route Get Data
    Route::controller(GetDataController::class)->group(function () {
        Route::post('get-aturan-kurikulum', 'get_aturan_kurikulum')->name('get-aturan-kurikulum');
        Route::post('get-catatan', 'get_catatan')->name('get-catatan');
        Route::post('get-ekstrakurikuler', 'get_ekstrakurikuler')->name('get-ekstrakurikuler');
        Route::post('get-guru-kelas', 'get_guru_kelas')->name('get-guru-kelas');
        Route::post('get-jenis-penilaian', 'get_jenis_penilaian')->name('get-jenis-penilaian');
        Route::post('get-jenis-sikap', 'get_jenis_sikap')->name('get-jenis-sikap');
        Route::post('get-kategori-nilai', 'get_kategori_nilai')->name('get-kategori-nilai');
        Route::post('get-kelas', 'get_kelas')->name('get-kelas');
        Route::post('get-kelas-wali', 'get_kelas_wali')->name('get-kelas-wali');
        Route::post('get-mata-pelajaran', 'get_mata_pelajaran')->name('get-mata-pelajaran');
        Route::post('get-siswa', 'get_siswa')->name('get-siswa');
    });

    //Route Get Absensi
    Route::controller(GetAbsensiController::class)->group(function () {
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
    });

    // Route Get Nilai dan Penilaian
    Route::controller(GetPenilaianController::class)->group(function () {
        Route::post('get-nilai-ekstrakurikuler', 'get_nilai_ekstrakurikuler')->name('get-nilai-ekstrakurikuler');
        Route::post('get-nilai-sikap', 'get_nilai_sikap')->name('get-nilai-sikap');
        Route::post('get-nilai-siswa', 'get_nilai_siswa')->name('get-nilai-siswa');
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

    // Route Atur Guru Kelas
    Route::controller(AturGuruKelasController::class)->group(function () {
        Route::get('atur-guru-kelas', 'index')->name('atur-guru-kelas');
        Route::post('atur-guru-kelas/simpan', 'simpan')->name('atur-guru-kelas.simpan');
        Route::delete('atur-guru-kelas/{id}', 'hapus')->name('atur-guru-kelas.hapus');
    });

    // Route Atur Kurikulum
    Route::controller(AturKurikulumController::class)->group(function () {
        Route::get('atur-kurikulum', 'index')->name('atur-kurikulum');
        Route::post('atur-kurikulum/simpan', 'simpan')->name('atur-kurikulum.simpan');
        Route::delete('atur-kurikulum/{id}', 'hapus')->name('atur-kurikulum.hapus');
    });

    // Route Input Catatan
    Route::controller(InputCatatanController::class)->group(function () {
        Route::get('input-catatan', 'index')->name('input-catatan');
        Route::post('input-catatan/simpan', 'simpan')->name('input-catatan.simpan');
        Route::delete('input-catatan/{id}', 'hapus')->name('input-catatan.hapus');
    });

    // Route Kelas
    Route::controller(KelasController::class)->group(function () {
        Route::get('kelas', 'index')->name('kelas');
        Route::post('kelas/{id}', 'edit')->name('kelas.edit');
        Route::post('kelas', 'simpan')->name('kelas.simpan');
    });

    // Route Kurikulum
    Route::controller(KurikulumController::class)->group(function () {
        Route::get('kurikulum', 'index')->name('kurikulum');
        Route::post('kurikulum/{id}', 'edit')->name('kurikulum.edit');
        Route::post('kurikulum', 'simpan')->name('kurikulum.simpan');
    });

    // Route Mata Pelajaran
    Route::controller(MataPelajaranController::class)->group(function () {
        Route::get('mata-pelajaran', 'index')->name('mata-pelajaran');
        Route::post('mata-pelajaran/{id}', 'edit')->name('mata-pelajaran.edit');
        Route::post('mata-pelajaran', 'simpan')->name('mata-pelajaran.simpan');
    });

    // Route Input Nilai
    Route::controller(InputNilaiController::class)->group(function () {
        Route::get('input-nilai', 'index')->name('input-nilai');
        Route::post('input-nilai/simpan', 'simpan')->name('input-nilai.simpan');
    });

    // Route Input Nilai Ekstrakurikuler
    Route::controller(InputNilaiEkstrakurikulerController::class)->group(function () {
        Route::get('input-nilai-ekstrakurikuler', 'index')->name('input-nilai-ekstrakurikuler');
        Route::post('input-nilai-ekstrakurikuler/simpan', 'simpan')->name('input-nilai-ekstrakurikuler.simpan');
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
        Route::get('print-rapor/download', 'download')->name('print-rapor.download');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
