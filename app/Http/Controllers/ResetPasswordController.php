<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use DB;
use App\Models\User;

class ResetPasswordController extends Controller
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

    public function getPassword($token)
    {
        return view('auth.password.reset-password', ['token' => $token]);
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $email = $this->authRepo->getEmailByToken($request->token);
        $checkMail = $this->authRepo->checkEmailExists($email);

        // Reset password
        if ($checkMail) {
            $this->authRepo->updatePassword($email, $request->password);

            // Delete token and email
            $this->authRepo->deleteTokenEmail($email);
        }

        return redirect('/')->with('message', 'Your password has been changed!');
    }
}
