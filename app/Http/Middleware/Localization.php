<?php
namespace App\Http\Middleware;

use Closure;
use App;

class Localization
{
    public function handle($request, Closure $next)
    {
        
        if(session()->has('locale'))
        {
            App::setLocale(session()->get('locale'));
            return $next($request);
        }
        else
        {
            $lang = ($request->hasHeader('lang')) ? $request->header('lang') : app()->getLocale();
            app()->setLocale($lang);
            return $next($request);
        }
    }
}


?>
