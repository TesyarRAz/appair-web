<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Settings\GeneralSetting;
use App\Settings\StyleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function home()
    {
        return view('admin.dashboard.index');
    }

    public function login()
    {
        return view('auth.login', [
            'general' => resolve(GeneralSetting::class),
            'style' => resolve(StyleSetting::class),
        ]);
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('username', $credentials['username_or_email'])
            ->orWhere('email', $credentials['username_or_email'])
            ->role('admin')
            ->first();
        
        if (filled($user) && Hash::check($credentials['password'], $user->password))
        {
            auth()->login($user);

            return to_route('home');
        }

        return back()->withErrors(['password' => 'Invalid credentials']);
    }

    public function logout()
    {
        auth()->logout();

        return to_route('login');
    }
}
