<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

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
        $this->authRepo->register($request);
    }
}
