<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckRememberLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('remember_token');

        if ($token) {
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                session()->put('login', true);
                session()->put('email', $user->email);
                session()->put('name', $user->name);
            }
        }
        return $next($request);
    }
}
