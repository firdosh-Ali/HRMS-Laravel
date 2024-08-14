<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        return response()->json($user);
    }

    public function allusers(Request $request)
    {
        $user = User::all();
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'date_of_birth' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'user not found'
            ],4040);
        }

        $user->update($request->all());

        return response()->json([
            'message' => 'user updated successfully'
        ]);
    }

    public function destroy($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'user not found'
            ],404);
        }
        $user->delete();
        return response()->json([
            'message'=>'User deleted successfully'
        ],200);
    }

}



