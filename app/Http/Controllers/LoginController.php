<?php

namespace App\Http\Controllers;

use App\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);

        $users =User::where('email',$request->email)->first();

        if(!$users || !Hash::check($request->password,$users->password))
        {
            throw ValidationException::withMessages([
                'email' => ['This email is not Correct']
            ]);
        }

        return $users->createToken('Auth Token')->accessToken;
    }
}
