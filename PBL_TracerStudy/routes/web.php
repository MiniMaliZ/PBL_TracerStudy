<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AlumniController;

use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postlogin'])->name('login.process');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('register', [AuthController::class, 'register'])->name('register');
// Route::post('register', [AuthController::class, 'postRegister']);

// Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
// Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
// Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset');
// Route::post('reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

Route::get('/dashboard', function () {
    return view('admin.dashboard'); // Pastikan file ini ada
})->name('dashboard');

Route::get('/pertanyaan', [PertanyaanController::class, 'index'])->name('pertanyaan.index');
Route::get('/pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
Route::put('/pertanyaan/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

// Route::resource('alumni', AlumniController::class);// Routes untuk tabel Alumni
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.create');
Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.store');
Route::get('/alumni/{nim}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
Route::put('/alumni/{nim}', [AlumniController::class, 'update'])->name('alumni.update');
Route::delete('/alumni/{nim}', [AlumniController::class, 'destroy'])->name('alumni.destroy');