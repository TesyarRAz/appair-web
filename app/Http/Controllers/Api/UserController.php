<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        auth()->user()->load('customer');

        return response(auth()->user());
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('username', $credentials['username_or_email'])
            ->orWhere('email', $credentials['username_or_email'])
            ->first();

        if (filled($user) && Hash::check($credentials['password'], $user->password))
        {
            $token = $user->createToken('AppAir-Mobile')->plainTextToken;

            return response(['token' => $token], 200);
        }

        return response(['error' => 'Unauthorized'], 401);
    }
}
