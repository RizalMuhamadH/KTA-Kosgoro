<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
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
        if(Auth::user() == null){
            return redirect()->route('home');
        }else{
            if(Auth::user()->position_id == "3"){
                Auth::logout();
                return redirect()->route('home');
            }
        }
        return $next($request);
    }
}
