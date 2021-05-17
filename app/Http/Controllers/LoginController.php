<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Http\Requests\LoginRequest;
use Cookie;

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
        $login = $this->authRepo->login($request);

        if ($login == 'success') {
            // remember login
            if ($request->has('remember')) {
                $this->authRepo->rememberLogin($request);
            } else {

            }

            return redirect('/');
        } else if ($login == 'inactive') {
            return redirect('/login')->with('not-found-link', 'Please check your mailbox to activate your account.');
        } else {
            return redirect('/login')->withErrors('Incorrect password or email!');
        }
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
            $this->authRepo->forgetLogin();
        }
        $this->authRepo->logout();
        return redirect('/');
    }
}
