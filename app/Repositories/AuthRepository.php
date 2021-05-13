<?php

namespace App\Repositories;

use App\Jobs\SendMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;

/**
 * Class AuthRepository
 *
 * @package App\Repositories
 */
class AuthRepository extends RepositoryAbstract
{
    /**
     * Get model name
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Login
     *
     * @param  String  $request
     * @return boolean
     */
    public function login($request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = $this->model->where('email', $email)->first();

        if ($user) {
            $pass = password_verify($password, $user->password);
        }

        if ($user && $pass) {
            session()->put('login', true);
            session()->put('user_id', $user->id);

            return true;
        }
        return false;
    }

    /**
     * Login
     *
     * @return boolean
     */
    public function logout() {
        session()->forget(['login', 'user_id']);

        return true;
    }

    /**
     * Send mail reset password
     *
     * @return boolean
     */
    public function sendMailResetPassword($request, $token) {
        $details=[
            "email"=>$request->email,
            "token"=>$token,
        ];
        dispatch(new SendMail($details));
    }

    /**
     * Insert email and token to password_resets table
     *
     * @return boolean
     */
    public function insertEmailAndToken($request, $token) {
        DB::table('password_resets')->insert([
            'email'=> $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    /**
     * Check email exists
     *
     * @param  string  $email
     * @return boolean
     */
    public function checkEmailExists($email) {
        return $this->model->where('email', $email)->exists();
    }

    /**
     * Check email exists by token
     *
     * @param  string  $token
     * @return string
     */
    public function getEmailByToken($token) {
        $result = DB::table('password_resets')->where('token', $token)->first();

        if ($result) {
            return $result->email;
        }
    }

    /**
     * Check email exists by token
     *
     * @param  string  $email
     * @return void
     */
    public function updatePassword($email, $password) {
        $this->model->where('email', $email)
                    ->update(['password' => bcrypt($password)]);
    }

    /**
     * Delete token and email when reset password
     *
     * @param  string  $email
     * @return void
     */
    public function deleteTokenEmail($email) {
        DB::table('password_resets')->where('email', $email)->delete();
    }
}
