<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

 public function register(Request $request)
 {
     $validateUser = Validator::make(
         $request->all(),
         [
             'name' => 'required',
             'contact' => 'required',
             'email' => 'required|email|unique:users',
             'address' => 'required',
             'date_of_birth' => 'required',
             'password' => 'required',
         ]
     );

     if ($validateUser->fails()) {
         return response()->json([
             'status' => false,
             'message' => 'Validation error',
             'errors' => $validateUser->errors()->all()
         ], 401);
     }

     $user = User::create([
         'name' => $request->name,
         'contact' => $request->contact,
         'email' => $request->email,
         'address' => $request->address,
         'date_of_birth' => $request->date_of_birth,
         'password' => $request->password,
     ]);

     if ($user) {
         return response()->json([
             'status' => true,
             'messagge' => 'User created successfully',
             'user' => $user,
         ], 200);
     } else {
         return response()->json([
             'message' => 'something went wrong',
             'errors' => $user->errors()->all(),
         ], 401);
     }
 }

     public function login(Request $request)
 {
     $validateUser = Validator::make(
         $request->all(),
         [
             'email' => 'required|email',
             'password' => 'required',
         ]
     );

     if ($validateUser->fails()) {
         return response()->json([
             'status' => false,
             'message' => 'Authentification failed',
             'errors' => $validateUser->errors()->all()
         ], 404);
     }

     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
         $authUser = Auth::user();
         return response()->json([
             'status' => true,
             'messagge' => 'User logged in Successfully',
             'token' => $authUser->createToken("Api Token")->plainTextToken,
             'token_type' => 'bearer'
         ], 200);
     } else {
         return response()->json([
             'status' => false,
             'message' => 'Email and password doesnot match'
         ], 401);
     }
 }

 public function logout(Request $request){
     $user = $request->user();
     $user->tokens()->delete();

     return response()->json([
         'status' => true,
         'user' =>$user,
         'message' => 'user logged out Successfully',
     ],200);
 }

}
