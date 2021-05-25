<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\PasswordReset;
use Carbon\Carbon;
use DB;

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
     * @return Model
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Login
     *
     * @param  Object  $request
     * @return boolean
     */
    public function login($request)
    {
        $email = $request->email;
        $password = $request->password;
        $pass = false;

        $user = $this->model->where('email', $email)->first();

        if (!$user)
            return false;

        $active = $user->email_verified_at;
        if (!$active) {
            return config('constants.INACTIVE');
        }

        if ($user) {
            $pass = password_verify($password, $user->password);
        }

        if ($user && $pass) {
            return config('constants.LOGIN_SUCCESS');
        }
        return false;
    }

    /**
     * Active user if verified email
     *
     * @param $token
     * @return boolean
     */
    public function activeUser($token) {
        $row = $this->model->where('token', $token)->first();
        $now = Carbon::now();

        if (!$row) {
            return config('constants.ERROR');
        }

        if (empty($row->email_verified_at)) {
            if ($this->checkExpireToken($row->updated_at, $now)) {
                $this->model->where('email', $row->email)
                    ->update(['email_verified_at' => $now]);
                return config('constants.LOGIN_SUCCESS');
            }
            return false;
        }
        return config('constants.VERIFIED');
    }

    /**
     * Check time life of token
     *
     * @param Date $start
     * @param Date $end
     * @return boolean
     */
    public function checkExpireToken($start, $end) {
        $expire = config('constants.expire');
        $minute = $end->diffInMinutes($start);

        return $minute < $expire;
    }

    /**
     * Get data from table password-resets
     *
     * @param string $token
     * @return boolean
     */
    public function getDataPasswordReset($token) {
        return PasswordReset::where('token', $token)->first();
    }

    /**
     * Remember login
     *
     * @param Object $request
     * @return void
     */
    public function rememberLogin($request, $token) {
        return $this->model->where('email', $request->email)
                    ->update(['remember_token' => $token]);
    }

    /**
     * Insert email and token to password_resets table
     *
     * @param Object $request
     * @param String $token
     * @return boolean
     */
    public function insertEmailAndToken($request, $token) {
        $data = [
            'email' => $request->email,
            'token' => $token
        ];
        return PasswordReset::insert($data);
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
     * @return boolean
     */
    public function getEmailByToken($token) {
        $result = PasswordReset::where('token', $token)->first();

        if ($result) {
            return $result->email;
        }
        return false;
    }

    /**
     * Get data from users by email
     *
     * @param string $email
     * @return boolean
     */
    public function getData($email) {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Update token
     *
     * @param string $email
     * @param string $token
     * @return boolean
     */
    function updateToken($email, $token) {
        return $this->model->where('email', $email)
                    ->update(['token' => $token]);
    }

    /**
     * Update remember_token
     *
     * @param string $email
     * @param string $token
     * @return boolean
     */
    function updateRememberToken($email, $token) {
        return $this->model->where('email', $email)
            ->update(['remember_token' => $token]);
    }

    /**
     * Check email exists by token
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function updatePassword($email, $password) {
        return $this->model->where('email', $email)
                    ->update(['password' => bcrypt($password)]);
    }

    /**
     * Delete token and email when reset password
     *
     * @param  string  $email
     * @return void
     */
    public function deleteTokenEmail($email) {
        return PasswordReset::where('email', $email)->delete();
    }

    /**
     * Register use
     *
     * @param  $request
     * @return boolean
     */
    public function register($request, $token) {
        $exists = $this->checkEmailExists($request->email);

        if (!$exists) {
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
        return false;
    }
}
