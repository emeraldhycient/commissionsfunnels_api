<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    
    public function createaccount(Request $request)
    {
        $validate = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create(
            [
                'fullname' => $validate['fullname'],
                'phone' => $validate['phone'],
                'email' => $validate['email'],
                'password' => Hash::make($validate['password']),
            ]
        );

        

    }

}