<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterUser;

class UserController extends Controller
{
     /**
     * Instantiate a new UserController instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all users
     * 
     */

    public function index()
    {   
        try {

            $users = MasterUser::where('isdelete', '=', 0)->simplePaginate(10);
            return response()->json(['users' => $users, 'status' => 'success', 'code' => 201], 201);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Users not found!','status' => false, 'HTTP_Status' => 404], 404);
        }
        
    }

    /*
        Get single user by id
    */

    public function show($id)
    {
        try {
            $user = MasterUser::findOrFail($id);

            return response()->json(['user' => $user], 200);

        } catch (\Exception $e) {

            return response()->json(['message' => 'User not found!','status'=>false, 'code' => 404], 404);
        }
    }


     /**
     * Update user.
     *
     * @return Response
     */

    public function update($id, Request $request)
    {   
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'dob' => 'required|date|before:18 years ago',
            'city' => 'required',
            'amount' => 'required',
            'phone' => 'required|numeric|phone_number|size:11',
        ]);

        try {

            $user = MasterUser::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->dob = date('Y-m-d', strtotime($request->input('dob')));
            $user->city = $request->input('city');
            $user->amount = $request->input('amount');
            $user->phone = $request->input('phone');
            $user->save();

            return response()->json(['user' => $user, 'message' => 'User updated succesfully', 'status' => true, 'code' => 201], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'error','error' => $e, 'status' => false, 'code' => 404], 404);

        }    
    }


    /*
        Update the active status of user
    */
    public function delete($id)
    {   
        $user = MasterUser::find($id);
        $user->isdelete = 1;
        $user->save();
        
        return response()->json(['message' => 'Deleted succesfully', 'status' => true, 'code' => 204], 204);
        
    }

    
    /*
        Get all users by app_id
    */

    public function getUsersByAppId(Request $request)
    {
        try {

            $users = MasterUser::where('isdelete', '=', 0)->where('app_id', '=', $request->headers->get('appid'))->simplePaginate(10);
            return response()->json(['users' => $users, 'status' => 'success', 'code' => 201], 201);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Users not found!','status' => false, 'HTTP_Status' => 404], 404);
        }
    }

    /*
        Patch =  update a status
    */

    public function updateStatus($id, Request $request)
    {
        $user = MasterUser::find($id);
        $user->status = $request->get('status');
        $user->save();

        return response()->json(['message' => 'Status updated succesfully', 'status' => true, 'code' => 200], 200);
    }
}