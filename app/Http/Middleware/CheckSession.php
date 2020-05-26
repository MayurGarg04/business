<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Http\Request;

class CheckSession
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
        $accessToken = $request->session()->has('access_token');

        if($accessToken)
        {  
            $next($request);            
        }
        else {
            return redirect()->route('loginget');
        }

        return $next($request);
    }
}
