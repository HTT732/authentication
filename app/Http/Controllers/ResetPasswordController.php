<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

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

    public function show($token)
    {
        $email = $this->authRepo->getEmailByToken($token);
        $exsist = $this->authRepo->checkEmailExists($email);

        if ($email && $exsist) {
            $row = $this->authRepo->getDataPasswordReset($token);
            $now = Carbon::now();
            $created_at = $row->created_at;
            $checkExpire = $this->authRepo->checkExpireToken($created_at, $now);

            if (!$checkExpire) {
                return view('auth.password.reset-password', ['expire' => trans('messages.expire'), 'token' => $token]);
            }
        }

        return view('auth.password.reset-password', ['token' => $token]);
    }

    public function store(ResetPasswordRequest $request)
    {
        $email = $this->authRepo->getEmailByToken($request->token);
        $checkMail = $this->authRepo->checkEmailExists($email);

        // Reset password
        if ($checkMail) {
            $this->authRepo->updatePassword($email, $request->password);

            // Delete token and email
            $this->authRepo->deleteTokenEmail($email);
        } else {
            return back()->withErrors(['reset_failed' => trans('messages.reset_failed')]);
        }

        return redirect()->route('login.index')->with('message', trans('messages.has_been_change', ['name' => 'password']));
    }
}
