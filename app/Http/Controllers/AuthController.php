<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    public function createaccount(Request $request)
    {
        //validate incoming request
        $validate = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        //create  a user 
        $user = User::create(
            [
                'fullname' => $validate['fullname'],
                'phone' => $validate['phone'],
                'email' => $validate['email'],
                'password' => Hash::make($validate['password']),
            ]
        );
        //send a success  response  with status 200,user,token and message
        return response()->json([
            'message' => 'Account created successfully',
            'user' => $user,
            'token' => $user->createToken($validate['email'])->plainTextToken,
        ], 200);

    }

    public function login(Request $request){

        //validate incoming request
        $validate = $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        //find user by email
        $user = User::where('email', $validate['email'])->first();

        //check if user exists
        if(!$user){
            return response()->json([
                'message' => 'User does not exist',
            ], 404);
        }

        //check if password matches
        if(!Hash::check($validate['password'], $user->password)){
            return response()->json([
                'message' => 'Password does not match',
            ], 404);
        }

        //authenticate user
        $token = $user->createToken($validate['email'])->plainTextToken;

        //send a success  response  with status 200,user,token and message
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ], 200);

    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();

        //send a success  response  with status 200,user,token and message
        return response()->json([
            'message' => 'Logout successful',
        ], 200);

    }

}