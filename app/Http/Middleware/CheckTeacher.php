<?php

namespace App\Http\Middleware;

use Closure;

class CheckTeacher
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

        if(auth()->check())
        {
            if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'super_admin')
            {
                return redirect()->route('admin.dashboard');
            }
            if(auth()->user()->role->name == 'teacher')
            {
                return $next($request);
            }
        }
        return $next($request);
    }
}
