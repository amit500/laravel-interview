<?php

use App\Http\Controllers\AdharCardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
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
    return view('welcome');
});

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');

    Route::get('/adhar', [AdharCardController::class, 'index'])->name('adhar.list');
    Route::get('/adhar-form', [AdharCardController::class, 'showAdharForm'])->name('adhar.form');
    Route::post('/adhar', [AdharCardController::class, 'adharStore'])->name('adhar.store');

    Route::get('adharcards/{id}/edit', [AdharCardController::class, 'edit'])->name('adharcards.edit');
    Route::put('adharcards/{id}', [AdharCardController::class, 'update'])->name('adharcards.update');
});
