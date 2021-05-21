<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Object_;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends AdminController
{
    /**
     * Global property or variable repository
     *
     * @var object
     */
    protected $userRepo;

    /**
     * Construct
     *
     * @param UserRepository $userRepository
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepo = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepo->getDataPaginate($this->limit);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $this->userRepo->create($request);

            return back()->with('successMess', trans('messages.create_success', ['name' => 'user']));
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                    'errorMessage' => trans(
                'messages.create_failed', ['name' => 'User'])
                ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userRepo->findById(($id));

            return view('admin.user.show', ['user' => $user]);
        } catch (ModelNotFoundException $e) {
            abort(404, trans('messages.not_found_id', ['id' => $id ]));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $user = $this->userRepo->findById($id);

            return view('admin.user.edit', ['user' => $user]);
        } catch (ModelNotFoundException $e) {
            abort(404, trans('messages.not_found_id', ['id' => $id ]));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            if ($request->validatePassword) {
                $validator = Validator::make($request->all(), [
                    'password' => 'required|min:6'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            $this->userRepo->update($request, $id);
            return redirect()->back()->with(['updateSuccess' => trans('messages.update_success', ['name' => 'User'])]);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['errorMessage' => trans('messages.update_failed', ['name' => 'User'])]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = $this->userRepo->delete($id);

            if ($delete) {
                return redirect()->back()->with(['successMessage' => trans('messages.delete_success')]);
            } else {
                return redirect()->back()->withErrors(['errorMessage' => trans('messages.delete_failed')]);
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withErrors(['errorMessage'=> trans('messages.not_found_id', ['id' => $id])]);
        }

    }

    public function searchUser(Request $request) {
        $users = $this->userRepo->search($request->value)->paginate($this->limit);

        if ($users->count()) {
            $messFound = trans('messages.search_found', ['total' => $users->count() , 'key' => $request->value]);

            return view('admin.user.index', compact('users', 'messFound'))->with(['oldInput' => $request->value]);
        } else {
            $messNotFound = trans('messages.search_not_found', ['key' => $request->value]);

            return view('admin.user.index')->with(['users' => $users, 'messNotFound' => $messNotFound, 'oldInput' => $request->value]);
        }
    }
}
