<?php

use App\Http\Controllers\TodoController;
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

Route::middleware('isGuest')->group(function () {
    Route::get('/', [TodoController::class, 'login'])->name('login');
    Route::get('/register', [TodoController::class, 'register'])->name('register');
    Route::post('/login', [TodoController::class, 'auth'])->name('login.auth');
    Route::post('/register', [TodoController::class, 'registerAccount'])->name('register.registerAccount');
});

Route::get('/logout', [TodoController::class, 'logout'])->name('logout');

Route::middleware('isLogin')->prefix('/todo')->name('todo.')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('index');
    Route::get('/create', [TodoController::class, 'create'])->name('create');
    Route::post('/store', [TodoController::class, 'store'])->name('store');
    // Parh yang ada {} artinya path dinamis. path dinamis merupakan path yang datanya diisi dari database. path dinamis ini nantinya akan berubah ubah tergantung data yang diberikan. apabila dalam route-nya ada path dinamis maka nantinya data path dinamis ini dapat diakses oleh controller melalui parameter di function nya
    Route::get('/edit/{id}', [TodoController::class, 'edit'])->name('edit');
    // Method route buat update data ke database itu pake patch/put
    Route::patch('/update/{id}', [TodoController::class, 'update'])->name('update');
    // Method route buat delete data di database itu pake delete
    Route::delete('/destroy/{id}', [TodoController::class, 'destroy'])->name('destroy');
});
