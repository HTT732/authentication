<?php

namespace App\Repositories;

use App\Jobs\SendMail;
use App\Jobs\JobVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use phpDocumentor\Reflection\Types\Collection;
use Illuminate\Http\Response;

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
     * Send mail reset password
     *
     * Param Token $token
     * @return boolean
     */
    public function verifyMailResgiter($email, $token) {
        $url = route('verify-email', ['token' => $token]);

        $details = [
            'email' => $email,
            'url' => $url,
            'expire' => Config::get('constants.expire')
        ];

        dispatch(new JobVerifyEmail($details));
    }

    /**
     * Active user if verified email
     *
     * Param Token $token
     * @return boolean
     */
    public function activeUser($token) {
        $row = $this->model->where('token', $token)->first();

        if (!$row) {
            return 'error';
        }

        if (empty($row->email_verified_at)) {
            $now = Carbon::now();
            $expire = Config::get('constants.expire');

            $minute = $now->diffInMinutes($row->updated_at);
            if ($minute < $expire) {
                $this->model->where('email', $row->email)
                    ->update(['email_verified_at' => $now]);
                return true;
            } else {
                return false;
            }
        } else {
            return 'verified';
        }
    }

    /**
     * Remember login
     *
     * Param null
     * @return void
     */
    public function rememberLogin($request) {
        $token = Str::random(64);

        $this->model->where('email', $request->email)
                    ->update(['remember_token' => $token]);

        // create cookie remember
        setcookie("remember_token", $token, (time()+3600)*24*365);

        // create session data use
        $user = $this->getData($request->email);

        if ($user) {
            session()->put('email', $user->email);
            session()->put('login', true);
        }

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
     * Get data from users by email
     *
     * @param  string  $token
     * @return string
     */
    public function getData($email) {
        $result = $this->model->where('email', $email)->first();

        return $result;
    }

    /**
     * Update token
     *
     * @param  string  $token
     * @return Collection
     */
    function updateToken($email, $token) {
        $update = $this->model->where('email', $email)
                    ->update(['token' => $token]);
        return $update;
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

    /**
     * Register use
     *
     * @param  $request
     * @return void
     */
    public function register($request, $token) {
        $exists = $this->checkEmailExists($request->mail);
        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'token' => $token,
            'password' => bcrypt($request->password),
            'created_at' => $created_at,
            'updated_at' => $updated_at
        ];
        if (!$exists) {
            return $this->model->create($data);
        }
    }
}
