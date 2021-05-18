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
