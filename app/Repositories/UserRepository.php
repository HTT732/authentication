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
// use App\Http\Repositories\AuthRepository;

/**
 * Class AuthRepository
 *
 * @package App\Repositories
 */
class UserRepository extends RepositoryAbstract
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
     * Get all data from users table
     * Param string $table
     * @return collection
     */
    public function getAllRow() {
        return $this->model->all();
    }

    /**
     * Create user
     * Param Request $request
     * @return collection
     */
    public function create($request) {
        $status = null;
        if ($request->status) {
            $status = Carbon::now();
        }

        $data = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->email),
            'email_verified_at' => $status
        ];

        return $this->model->create($data);
    }

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
