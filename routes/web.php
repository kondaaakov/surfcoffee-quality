<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PollsController;
use App\Http\Controllers\SecretGuestsController;
use App\Http\Controllers\SpotsController;
use App\Http\Controllers\TemplateController;
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

Route::get('/users', [UsersController::class, 'index'])->name('users');
Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::get('/users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
Route::post('/users', [UsersController::class, 'store'])->name('users.store');
Route::post('/users/{user}', [UsersController::class, 'update'])->name('users.update');
Route::get('/users/delete/{user}', [UsersController::class, 'delete'])->name('users.delete');

Route::middleware('auth')->group(function () {
    Route::view('/', 'home.index')->name('home');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');



    Route::get('/guests', [SecretGuestsController::class, 'index'])->name('guests');
    Route::get('/guests/create', [SecretGuestsController::class, 'create'])->name('guests.create');
    Route::get('/guests/{guest}', [SecretGuestsController::class, 'show'])->name('guests.show');
    Route::get('/guests/{guest}/edit', [SecretGuestsController::class, 'edit'])->name('guests.edit');
    Route::post('/guests', [SecretGuestsController::class, 'store'])->name('guests.store');
    Route::post('/guests/{guest}', [SecretGuestsController::class, 'update'])->name('guests.update');
    Route::get('/guests/delete/{guest}', [SecretGuestsController::class, 'delete'])->name('guests.delete');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/archive/{category}', [CategoryController::class, 'archive'])->name('categories.archive');
    Route::get('/categories/unarchive/{category}', [CategoryController::class, 'unarchive'])->name('categories.unarchive');

    Route::get('/templates', [TemplateController::class, 'index'])->name('templates');
    Route::get('/templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::get('/templates/{template}', [TemplateController::class, 'show'])->name('templates.show');
    Route::get('/templates/{template}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::post('/templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::post('/templates/{template}', [TemplateController::class, 'update'])->name('templates.update');
    Route::get('/templates/delete/{template}', [TemplateController::class, 'delete'])->name('templates.delete');
    Route::get('/templates/archive/{template}', [TemplateController::class, 'archive'])->name('templates.archive');
    Route::get('/templates/unarchive/{template}', [TemplateController::class, 'unarchive'])->name('templates.unarchive');

    Route::get('/spots', [SpotsController::class, 'index'])->name('spots');
    Route::get('/spots/create', [SpotsController::class, 'create'])->name('spots.create');
    Route::get('/spots/{id}', [SpotsController::class, 'show'])->name('spots.show');
    Route::get('/spots/{id}/edit', [SpotsController::class, 'edit'])->name('spots.edit');
    Route::post('/spots', [SpotsController::class, 'store'])->name('spots.store');
    Route::post('/spots/{id}', [SpotsController::class, 'update'])->name('spots.update');
    Route::get('/spots/delete/{id}', [SpotsController::class, 'delete'])->name('spots.delete');
    Route::get('/spots/archive/{id}', [SpotsController::class, 'archive'])->name('spots.archive');
    Route::get('/spots/unarchive/{id}', [SpotsController::class, 'unarchive'])->name('spots.unarchive');

    Route::get('/polls', [PollsController::class, 'list'])->name('polls');
    Route::get('/polls/create', [PollsController::class, 'create'])->name('polls.create');
    Route::get('/polls/{id}', [PollsController::class, 'show'])->name('polls.show');
    Route::post('/polls', [PollsController::class, 'store'])->name('polls.store');
    Route::get('/polls/{id}/close', [PollsController::class, 'close'])->name('polls.close');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

Route::get('/poll/thanks', [PollsController::class, 'thanks'])->name('poll.thanks');
Route::get('/poll/{string}', [PollsController::class, 'index'])->name('poll');
Route::post('/poll', [PollsController::class, 'answer'])->name('poll.answer');
