<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth')->group(function () {
    Route::view('/', 'home.index')->name('home');
    Route::view('/logout', 'home.index')->name('logout');
});

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');

Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');

Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');

Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');

Route::get('/users/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
