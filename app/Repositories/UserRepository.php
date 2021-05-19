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
    public function getDataPaginate($per_page) {
        return $this->model->paginate($per_page);
    }

    /**
     * Get data by id
     * Param string $id
     * @return collection
     */
    public function findById($id) {
        return $this->model->findOrfail($id);
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

    /**
     * Update user
     * Param Request $request, Id $id
     * @return collection
     */
    public function update($request, $id) {
        $user = $this->model->findOrFail($id);

        $user->email = $request->email;
        $user->name = $request->name;

        if($user->password != $request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->status) {
            $user->email_verified_at = Carbon::now();
        } else {
            $user->email_verified_at = null;
        }
        $user->save();
        return $user;
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
