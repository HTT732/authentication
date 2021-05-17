<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Repositories\AuthRepository;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Global property or variable repository
     *
     * @var object
     */
    protected $authRepo;

    /**
     * Construct
     *
     * @param AuthRepository $authRepository
     * @return void
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepo = $authRepository;
    }

    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(RegisterRequest $request) {
        $token = Str::random(64);
        $register = $this->authRepo->register($request, $token);

        if($register) {
            // Verify email
            $this->authRepo->verifyMailResgiter($request->email, $token);

            return redirect('/login')->with(['message' => 'A link has been sent to your mailbox, open your mailbox to confirm your account.']);
        }
        return back()->with(['message' => 'Account registration failed, please try again!', 'class-color' => 'text-danger']);
    }

    public function verifyRegister($token) {
        $status = $this->authRepo->activeUser($token);

        if ($status == false) {
            return redirect('/login')->with('expire', 'Validation time has expired.');
        }

        if ($status == 'verified') {
            return redirect('/login')->with('verify-fail', 'Your email has been verified.!');
        }

        if ($status == 'error') {
            return redirect('/login')->with('verify-fail', 'Verify error!');
        }

        return redirect('/login')->with('message', 'Your email has been verified.!');
    }

    public function showResendForm() {
        return view('auth.password.resend-verify-mail');
    }

    public function resendMailVerify(ForgotPasswordRequest $request) {
        $token = Str::random(64);

        // update token to users
        $update = $this->authRepo->updateToken($request->email, $token);
        $mess = ['verify-fail' => 'Resend mail faild.'];

        if (!$update) {
            return redirect('/resend-email')->withErrors('verify-fail', 'Resend mail faild.');
        }

        // Verify email
        $this->authRepo->verifyMailResgiter($request->email, $token);

        return redirect('/login')->with(['message' => 'A link has been sent to your mailbox, open your mailbox to confirm your account.']);
    }
}
