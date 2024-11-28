<?php

namespace App\Http\Middleware;
use JWTAuth;

use Closure;

class checkauthUser
{
    public function handle($request, Closure $next)
    {
        
        $token = $request->header('Authorization' );
        
        $user = JWTAuth::user();
        dd($user->active);
        $user->update(['google_device_token' => NULL]);
        JWTAuth::parseToken()->invalidate( $token );

        if(auth()->check())
        {
            if(auth()->user()->role->name == 'admin' || auth()->user()->role->name == 'super_admin')
            {
                return $next($request);
            }
            if(auth()->user()->role->name == 'teacher')
            {
                return redirect('admin.dashboard');
            }
        }
        return $next($request);
    }
}
