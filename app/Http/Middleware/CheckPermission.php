<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       // return $next($request);
       // $rol=Auth::user()->rol_id
       // if(auth()->user()->rol_id == 3){
//        $users=User::find(2);
//        $user=$users->rol_id;
//        $rol=auth()->user()->rol_id;
        if(\auth()->user()['rol_id'] == 1){
            return $next($request);
        }elseif(\auth()->user()['rol_id'] == 2){
            return $next($request);
        }elseif(\auth()->user()['rol_id'] == 3){
            return redirect('home');

        }


    }
}
