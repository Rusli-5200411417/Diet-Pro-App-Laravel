<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\makananController;
use App\Http\Controllers\UserController;
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
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::group(['middleware' => ['guest:sanctum']], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost']);
   
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'makanan'], function () {
        Route::get('/', [makananController::class, 'index'])->name('makanan');
        Route::post('/import', [makananController::class, 'importData'])->name('import');
        Route::get('/search', [makananController::class, 'search'])->name('search');
        Route::post('/tambah', [makananController::class, 'tambah'])->name('makanan.tambah');
        Route::put('/edit/{id}', [makananController::class, 'edit'])->name('makanan.edit');
        Route::delete('/hapus/{id}', [makananController::class, 'hapus'])->name('makanan.hapus');
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'tampilUser'])->name('user');
        Route::get('/new-user', [UserController::class, 'newUser'])->name('new-user');
    });
    
});
