<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $data = [
            'email' => $request->email,
            'password' =>$request->password
        ];

        if (auth()->attempt($data)) {

            return response()->json([
               'token' => auth()->user()->createToken('client'),
            ]);
        }

        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return [
            'token' => $user->createToken('client')
        ];
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json($user);
    }

}
