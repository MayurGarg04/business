<?php

namespace App\Http\Middleware;

use Closure;

class CheckApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function boot(Router $router)
    {
        parent::boot($router);

        $router->model('user', '\App\User');
    }

    public function handle($request, Closure $next)
    {	
        // return response()->json(['user' => $request->headers->get('app_id')]);

        //return response()->json(['message' => $request->get('app_id')]);

        $app_id = $request->headers->get('appid');

        if( $app_id == null ) {
        	return response()->json(['message' => 'App id is missing!','status' => false, 'code' => 401], 401);
        } else {

        	$user = \App\User::where('app_id', $app_id)->first();

	    	if (!$user) {
	            return response()->json(['message' => 'App id is not invalid!','status' => false, 'code' => 401], 401);
	        }
        }

    	
        return $next($request);
    }
}
