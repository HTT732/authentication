<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Str;

class ResendMailController extends Controller
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

    public function index() {
        return view('auth.password.resend-verify-mail');
    }

    public function store(ForgotPasswordRequest $request) {
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
