<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Jobs\SendMail;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use App\Mail\SendMailResetPassword;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
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

    public function index()
    {
        return view('auth.password.forgot-password');
    }

    public function store(ForgotPasswordRequest $request)
    {
        $token = Str::random(64);

        // Insert email and token to password_resets table
        $this->authRepo->insertEmailAndToken($request, $token);

        // Send mail
        $details=[
            "email" => $request->email,
            "token" => $token,
            "url" => route('reset-password.show', ['reset_password' => $token])
        ];

        dispatch(new SendMail($details));

        return back()->with('message', trans('messages.email_sended'));
    }
}
