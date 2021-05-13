<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $login = Auth::attempt(['email'=> $request->email, 'password' => $request->password]);

        if ($login) {
            return redirect('/');
        } else {
            return redirect('/')->withErrors('Incorrect password or email!');
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
