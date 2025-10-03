<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DenunciaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/meu-dashboard', [DenunciaController::class, 'userDashboard'])->name('user.dashboard');
    Route::get('/admin-dashboard', [DenunciaController::class, 'adminDashboard'])->name('admin.dashboard');


    
    // Denuncias
    Route::get('/denuncias', [DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/create', [DenunciaController::class, 'create'])->name('denuncias.create');
    Route::post('/denuncias', [DenunciaController::class, 'store'])->name('denuncias.store');
    Route::get('/denuncias/{id}', [DenunciaController::class, 'show'])->name('denuncias.show');



});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [DenunciaController::class, 'adminDashboard'])->name('admin.dashboard');
});


require __DIR__.'/auth.php';
