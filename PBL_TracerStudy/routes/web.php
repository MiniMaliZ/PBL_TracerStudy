<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\PertanyaanController;

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

//form
Route::get('/lp', function () {
    return view('FormTracerStudy/index');
});

Route::get('/opsi', function () {
    return view('FormTracerStudy/opsiform');
});

Route::get('/ts', function () {
    return view('FormTracerStudy/tracerstudy');
});

Route::get('/tspl', function () {
    return view('FormTracerStudy/surveiPL');
});
