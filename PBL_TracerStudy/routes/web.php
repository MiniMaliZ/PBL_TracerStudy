<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\ImportController;
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

