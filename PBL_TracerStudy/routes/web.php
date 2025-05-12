<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\TCFormController;

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
    return view('welcome');
});

// Tambahkan route untuk dashboard
Route::get('/dashboard', function () {
    return view('admin.dashboard'); // Pastikan file ini ada
})->name('dashboard');

Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
Route::get('/pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

Route::get('/import',[ImportController::class,'index'])->name('import.index'); 
Route::get('/list',[ImportController::class,'list']); 
Route::get('/import-form', [ImportController::class, 'import']); // Halaman form upload
Route::post('/import_ajax', [ImportController::class, 'import_ajax'])->name('import_ajax');
Route::post('/import_excel', [ImportController::class, 'import_excel']);
Route::get('/export_excel', [ImportController::class, 'export_excel']);
Route::get('/import/{nim}/edit_ajax', [ImportController::class, 'edit_ajax']);
Route::put('/import/{nim}/update_ajax', [ImportController::class, 'update_ajax']);
Route::delete('/import/{nim}/delete_ajax', [ImportController::class, 'delete_ajax']);

// Route::resource('alumni', AlumniController::class);// Routes untuk tabel Alumni
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
Route::get('/alumni/{nim}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
Route::put('/alumni/{nim}', [AlumniController::class, 'update'])->name('alumni.update');
Route::delete('/alumni/{nim}', [AlumniController::class, 'destroy'])->name('alumni.destroy');

// Routes untuk tabel Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
Route::get('/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
Route::put('/admin/{id}', [AdminController::class, 'update'])->name('admin.update');
Route::delete('/admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

Route::prefix('tracerstudy')->group(function () {
    //landing page
    Route::get('/', [TCFormController::class, 'index']);
    //opsi form
    Route::get('/formopsi', [TCFormController::class, 'opsi'])->name("form.opsi");
    // form alumni 
    Route::get('/formopsi/formalumni', [TCFormController::class, 'kusionerA'])->name("form.alumni");
    Route::get('/formulir', [TCFormController::class, 'nim'])->name('formulir.create'); // menampilkan nim importan 
    Route::get('/get-alumni-data/{nim}', [TCFormController::class, 'getAlumniData']); // mengisi data otomatis 

    //form penggunalulusan 
    Route::get('/formopsi/formpenggunalulusan', [TCFormController::class, 'surveiPL'])->name("form.penggunalulusan");
});
