<?php

namespace App\Http\Controllers;

use App\Jobs\JobVerifyEmail;
use App\Repositories\AuthRepository;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Config;
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

    public function index() {
        return view('auth.register');
    }

    public function store(RegisterRequest $request) {
        $token = Str::random(64);
        $register = $this->authRepo->register($request, $token);

        if($register) {
            // Verify email
            $details = [
                'email' => $request->email,
                'url' => route('verify-email', ['token' => $token]),
                'expire' => Config::get('constants.expire')
            ];

            dispatch(new JobVerifyEmail($details));

            return redirect()->route('login.index')->with(['message' => trans('messages.link_has_been_sent')]);
        }
        return back()->with(['message' => trans('messages.register_failed'), 'class-color' => 'text-danger']);
    }

    public function verifyRegister($token) {
        $status = $this->authRepo->activeUser($token);

        if ($status == false) {
            return redirect()->route('login.index')->with('expire', trans('messages.expire'));
        }

        if ($status == config('constants.VERIFIED')) {
            return redirect()->route('login.index')->with('verify-fail', trans('messages.has_been_verified'));
        }

        if ($status == config('constants.ERROR')) {
            return redirect()->route('login.index')->with('verify-fail', 'Verify error!');
        }

        return redirect()->route('login.index')->with('message', trans('messages.has_been_verified'));
    }


}
