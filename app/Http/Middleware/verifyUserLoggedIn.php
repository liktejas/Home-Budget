<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class verifyUserLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $req, Closure $next)
    {
        if(empty($req->session()->has('USER_NAME')))
        {
            return redirect('/');
        }
        return $next($req);
    }
}
