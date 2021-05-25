<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use DB;
use phpDocumentor\Reflection\Types\Collection;

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
     * @return Model
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Create user
     * @param $request
     * @return boolean
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
     * @param $request
     * @param $id
     * @return Object $user
     */
    public function update($request, $id) {
        $user = $this->model->findOrFail($id);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);

        if ($request->status) {
            $user->email_verified_at = Carbon::now();
        } else {
            $user->email_verified_at = null;
        }
        $user->save();
        return $user;
    }

    /**
     * Search user
     * @param string $value
     * @return Collection
     */
    public function search($value) {
        return $this->model->like('email',trim($value));
    }
}
