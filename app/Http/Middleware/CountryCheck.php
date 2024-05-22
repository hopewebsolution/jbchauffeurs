<?php

namespace App\Http\Middleware;
use Closure;

class CountryCheck
{
    public function handle($request, Closure $next)
    {
        $segment = $request->segment('1');
        if(!$segment){
            return redirect('/aus');
        }
        return $next($request);
    }
}
