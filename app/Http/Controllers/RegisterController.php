<?php

namespace App\Http\Controllers;

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
        $register = $this->authRepo->register($request);

        if($register) {
            $token = Str::random(64);

            // Add data in session
            session()->put('email', $request->email);
            session()->put('token', $request->token);

            // Verify email
            $this->authRepo->verifyMailResgiter($request->email, $token);

            return redirect('/login')->with(['message' => 'A link has been sent to your mailbox, open your mailbox to confirm your account.']);
        }
        return back()->with(['message' => 'Account registration failed, please try again!', 'class-color' => 'text-danger']);
    }

    public function verifyRegister($token) {
        $email = session('email');

        $status = $this->authRepo->activeUser($email);

        if ($status) {
            return redirect('/login')->with('message', 'Account confirmation successful!');
        } else {
            return redirect('/login')->withErrors('Validation time has expired, get authentication link');
        }
    }
}
