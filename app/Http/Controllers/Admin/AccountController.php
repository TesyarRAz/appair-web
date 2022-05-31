<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account.index');
    }

    public function password(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:5',
            'username' => 'required',
        ], [
            'new_password.min' => 'Password baru harus lebih dari 5 karakter'
        ]);

        $new_password = $request->new_password;
        $username = $request->username;

        if (!Hash::check($request->old_password, auth()->user()->password))
        {
            return back()->with('status', 'Password lama salah');
        }

        $new_password = bcrypt($new_password);

        auth()->user()->update(['password' => $new_password,'username' => $username]);

        return back()->with('status', 'Berhasil ganti password');
    }
}
