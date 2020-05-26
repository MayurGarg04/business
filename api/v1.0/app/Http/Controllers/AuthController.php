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
            'dob' => 'required|date|before:18 years ago',
            'city' => 'required',
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
          ],
          [
            'name.required' => ' The name field is required.',
            'name.min' => ' The name must be at least 5 characters.',
            'name.max' => ' The name may not be greater than 35 characters.',
            'email.required' => ' The email field is required.',
            'dob.required' => ' The date of birth field is required.',
            'dob.date' => ' The date of birth is not valid.',
            'dob.before' => ' You must be at least 18 years old.',
            'city.min' => ' The city must be at least 5 characters.',
            'city.max' => ' The city may not be greater than 35 characters.',
            'amount.required' => ' The amount field is required.',
            'amount.numeric' => ' The amount field can not be string.',
            'phone.required' => ' The phone field is required.',
            'phone.numeric' => ' The phone field can not be string.',
          ]
        );


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
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized user!','status' => false, 'code' => 401], 401);
        }

        return $this->respondWithToken($token);
    }


}