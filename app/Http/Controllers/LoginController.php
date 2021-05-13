<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use App\Http\Requests\LoginRequest;

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

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $login = $this->authRepo->login($request);

        if ($login) {
            return redirect('/');
        } else {
            return redirect('/')->withErrors('Incorrect password or email!');
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
        $this->authRepo->logout();
        return redirect('/');
    }
}
