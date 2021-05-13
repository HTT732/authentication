<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function getEmail()
    {
        return view('auth.forgot-password');
    }

    public function postEmail(Request $request)
    {
        // Validate email 
        $this->validate($request,
            [
                'email' => 'required|email|exists:users'
            ],
            [
                'required' => 'Email is required',
                'email' => ' Invalidate email',
                'exists' => 'Email does not exist'
            ]
        );

        $token = Str::random(64);

        // Insert email and token 
        DB::table('password_resets')->insert([
            'email'=> $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Send mail reset password 
        Mail::send('auth.verify', ['token' => $token], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('message', 'We have e-mailed your password reset link !');
    }
}
