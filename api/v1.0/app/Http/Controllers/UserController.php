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
        
        return response()->json(['users' =>  MasterUser::where('isdelete', '=', 0)->simplePaginate(20), 'status' => true, 'code' => 200], 200);
        
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

    public function update(Request $request)
    {   
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
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
            'amount.required' => ' The amount field is required.',
            'amount.numeric' => ' The amount field can not be string.',
            'phone.required' => ' The phone field is required.',
            'phone.numeric' => ' The phone field can not be string.',
          ]
        );

        try {

            $user = MasterUser::find($request->get('id'));
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->dob = $request->input('dob');
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
        Get all users by appid
    */

    public function getUsersByAppId(Request $request)
    {
        try {

            $users = MasterUser::where('isdelete', '=', 0)->where('app_id', '=', $request->headers->get('appid'))->simplePaginate(1);
            return response()->json(['users' => $users, 'status' => true, 'code' => 201], 201);

        } catch (\Exception $e) {

            return response()->json(['message' => 'Users not found!','status' => false, 'code' => 404], 404);
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

    /*
        Patch =  update a status more than one
    */
    public function updateDonor(Request $request)
    {
    //    \DB::table('master_user')->whereIn('id', $request->get('ids'))->update(['status' => 1]);
        MasterUser::whereIn('id', $request->get('ids'))->update(['status' => 1]);
        
        return response()->json(['message' => 'Donor updated succesfully', 'status' => true, 'code' => 200], 200);
    }

    public function deleteUser(Request $request)
    {
        MasterUser::where('id', $request->get('id'))->update(['isdelete' => 1]);
        
        return response()->json(['message' => 'Donor deleted succesfully', 'status' => true, 'code' => 200], 200);
    }

}