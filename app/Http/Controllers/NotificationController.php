<?php

namespace App\Http\Controllers;

use App\Notifications\SendMessageToUser;
use Illuminate\Http\Request;
use App\Models\User;
use Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function sendMessageToUser(Request $request) {
        $validate = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|email',
            'mess' => 'required'
        ]);

        if($validate->fails()) {
            return redirect()->route('home')->withErrors($validate->errors());
        }

        $user = User::where('email', $request->email)->first();

        $data = [
            'name' => $user->name,
            'mess' => $request->mess
        ];

        $user->notify(new SendMessageToUser($data));

        return redirect()->route('home')->with('success', trans('messages.has_been_send'));
    }
}
