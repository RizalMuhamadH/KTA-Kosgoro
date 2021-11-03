<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthPWA
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
            return redirect()->route('pwa.index');
        }else{
            if(isset($request->email)){
                if(Auth::user()->email != $request->email){
                    return redirect()->route('pwa.index')->with('message','Silahkan Login Terlebih Dahulu');
                }
            }else if(isset($request->id)){
                if(Auth::user()->id != $request->id){
                    return redirect()->route('pwa.index')->with('message','Silahkan Login Terlebih Dahulu');
                }
            }else{
                return redirect()->route('pwa.profile',['email' => Auth::user()->email]);
            }
        }
        return $next($request);
    }
}
