<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Http\Requests\LoginRequest;
use Cookie;
use Illuminate\Support\Str;

class LoginController extends Controller
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
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $token = Str::random(64);
        $login = $this->authRepo->login($request, $token);

        // login success
        if ($login == config('constants.LOGIN_SUCCESS')) {
            session()->put('login', true);
            session()->put('name', $request->name);

            // remember login
            if ($request->has('remember')) {
                $this->authRepo->rememberLogin($request);

                // create cookie remember
                setcookie("remember_token", $token, (time()+3600*24*365));
            }

            return redirect()->route('home');
        }

        // account inactive
        if ($login == config('constants.INACTIVE')) {
            return redirect()->route('login.index')->with('not-found-link', trans('messages.inactive'));
        }

        //incorrect password or email
        return redirect()->route('login.index')->withErrors(trans('messages.incorrect_email_pass'));
    }

    /**
     * User Logout
     *
     * @param null
     * @return redirect
     */
    public function logout()
    {
        if (session('login')) {
            $this->authRepo->updateRememberToken(session('email'), null);

            // delete cookie
            setcookie('remember_token', '', time()-3600);

            // delete session
            session()->forget('login');
            session()->forget('email');
            session()->forget('name');
        }
        return redirect()->route('home');
    }
}
