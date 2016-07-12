<?php

namespace App\Http\Middleware;

use Closure;
use User;


class EnsureAdmin
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
        if($request->user()->role == "regular"){
            return redirect("/");
        }

        return $next($request);
    }
}
