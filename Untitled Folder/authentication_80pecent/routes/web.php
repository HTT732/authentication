<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('login', [LoginController::class, 'login'])->name('login');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('forgot-password', [ForgotPasswordController::class, 'getEmail'])->name('get-forgot-password');
Route::post('forgot-password', [ForgotPasswordController::class, 'postEmail'])->name('post-forgot-password');   
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'getPassword'])->name('get-password');
Route::post('/reset-password', [ResetPasswordController::class, 'updatePassword'])->name('update-password');
