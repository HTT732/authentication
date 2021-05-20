<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResendMailController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
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

Route::get('/', function (Request $request) {
    return view('welcome');
})->name('home');

Route::middleware('verify.login')->group(function () {
    Route::resource('login', LoginController::class)->only(['index', 'store']);
    Route::resource('register', RegisterController::class)->only(['index', 'store']);
    Route::resource('forgot-password', ForgotPasswordController::class)->only(['index', 'store']);
    Route::resource('reset-password', ResetPasswordController::class)->only(['show', 'store']);
    Route::resource('resend', ResendMailController::class)->only(['index', 'store']);
    Route::get('/verify-email/{token}', [RegisterController::class, 'verifyRegister'])->name('verify-email');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('user', UserController::class);
    Route::get('search', [UserController::class, 'searchUser'])->name('admin.user.search');
});

