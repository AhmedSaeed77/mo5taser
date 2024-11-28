<?php

namespace App\Http\Middleware;

use Closure;

class CustomLogin
{
    public function handle($request, Closure $next)
    {

        if(auth()->check())
        {
          return $next($request);
        }
        return redirect()->route('login');
    }
}
