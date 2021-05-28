<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResendMailController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\View;
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

Route::middleware('verify.login')->group(function () {
    Route::resource('login', LoginController::class);
    Route::resource('register', RegisterController::class)->only(['index', 'store']);
    Route::resource('forgot-password', ForgotPasswordController::class)->only(['index', 'store']);
    Route::resource('reset-password', ResetPasswordController::class)->only(['show', 'store']);
    Route::resource('resend', ResendMailController::class)->only(['index', 'store']);
    Route::get('/verify-email/{token}', [RegisterController::class, 'verifyRegister'])->name('verify-email');
});
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'isAdmin', 'prefix' => 'admin'],function () {
    Route::resource('user', UserController::class);
    Route::get('search', [UserController::class, 'searchUser'])->name('admin.user.search');
});

// Send message to user
Route::post('send-message-to-user', [NotificationController::class, 'sendMessageToUser'])->name('send-message');

Route::get('sms', function () {
    $basic  = new \Vonage\Client\Credentials\Basic("a659b762", "jSSoFf9u91wXZDvR");
    $client = new \Vonage\Client($basic);

    $verification = $client->verify()->start([
        'number' => '+84789109732',
        'brand'  => 'My App',
    ]);

    // cancel verify by sms
    $client->verify()->cancel($verification);
//    $response = $client->sms()->send(
//        new \Vonage\SMS\Message\SMS("84789109732", '84932556770', 'A text message sent using the Nexmo SMS API')
//    );
//
//    $message = $response->current();
return $verification->getRequestId();
//    if ($message->getStatus() == 0) {
//        echo "The message was sent successfully\n";
//    } else {
//        echo "The message failed with status: " . $message->getStatus() . "\n";
//    }
});
