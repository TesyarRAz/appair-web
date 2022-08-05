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
        $user = auth()->user();

        $user->customer->append('last_meter');

        return response($user);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('username', $credentials['username_or_email'])
            ->orWhere('email', $credentials['username_or_email'])
            ->first();

        if (filled($user) && Hash::check($credentials['password'], $user->password))
        {
            $token = $user->createToken('mobile')->plainTextToken;

            return response(['token' => $token], 200);
        }

        return response(['error' => 'Unauthorized'], 401);
    }
    
    public function changePassword(Request $request)
    {
        $data = $request->validate([ 
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        $user = $request->user();

        if (Hash::check($data['old_password'], $user->password))
        {
            $user->password = Hash::make($data['new_password']);
            $user->save();

            return response(['message' => 'Password changed successfully.'], 200);
        }

        return response(['error' => 'Old password is incorrect.'], 401);
    }
}
