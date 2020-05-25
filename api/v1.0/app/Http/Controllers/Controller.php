<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {	
        return response()->json([
        	'status'=>'success',
        	'HTTP_Status'=>'200',
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'app_id' => Auth::user()->app_id
        ], 200);
    }
}
