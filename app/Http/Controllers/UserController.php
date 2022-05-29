<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('username', $credentials['username_or_email'])
            ->orWhere('email', $credentials['username_or_email'])
            ->first();
        
        if (filled($user) && Hash::check($credentials['password'], $user->password))
        {
            auth()->login($user);

            return to_route('home');
        }

        return back()->withErrors(['password' => 'Invalid credentials']);
    }
}
