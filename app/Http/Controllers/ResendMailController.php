<?php

namespace App\Http\Controllers;

use App\Jobs\JobVerifyEmail;
use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Config;
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

        if (!$update) {
            return redirect()->route('resend.index')->withErrors(['verify_fail' => trans('messages.verify_fail')]);
        }

        // Verify email
        $details = [
            'email' => $request->email,
            'url' => route('verify-email', ['token' => $token]),
            'expire' => Config::get('constants.expire')
        ];

        dispatch(new JobVerifyEmail($details));

        return redirect()->route('login.index')->with(['message' => trans('messages.link_has_been_sent')]);
    }
}
