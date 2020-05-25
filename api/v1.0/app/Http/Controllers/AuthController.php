<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\MasterUser;

class AuthController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {

        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:master_user',
            'dob' => 'required|before:18 years ago',
            'city' => 'required',
            'amount' => 'required',
            'phone' => 'required:max:10',
        ]);


        try {

            $user = new MasterUser;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
            $user->city = $request->input('city');
            $user->amount = $request->input('amount');
            $user->app_id = $request->headers->get('appid');
            $user->phone = $request->input('phone');
            $user->isd_code = '91';
            $user->register_ip = request()->ip();
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'Registration Completed successfully.','status' => true, 'code' => 201], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!', 'e' => $e ,'status' => false, 'code' => 409], 409);
        }

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
          //validate incoming request 
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized user!','status' => false, 'code' => 401], 401);
        }

        return $this->respondWithToken($token);
    }


}