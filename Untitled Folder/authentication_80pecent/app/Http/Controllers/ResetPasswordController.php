<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function getPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, 
            [
                'password' => 'required|min:6|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'password.required' => 'Password is required',
                'min' => 'The minimum length is 6',
                'confirmed' => 'Passwords and password confirmation not match',
                'password_confirmation.required' => 'Password confirmation is required'
            ]
        );

        $result = DB::table('password_resets')->where('token', $request->token)->first();

        if(empty($result->email)) {
            return back()->with('error', 'Password reset failed, please try again!');
        }

        $user = DB::table('users')
                    ->where('email', $result->email)
                    ->update(['password' => bcrypt($request->password)]);

        if($user) {
            DB::table('password_resets')->where('email', $result->email)->delete();

            return redirect('/')->with('message', 'Your password has been changed!');
        }
    }
}
