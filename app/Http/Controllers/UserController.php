<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function registration()
    {
        return view('auth.registration');
    }

    public function create(RegistrationRequest $request)
    {
        User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
            ]
        );

        return redirect('/login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authorizeUser(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'auth' => '*Неверный логин или пароль'
            ]);
        }
        return redirect()->intended();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
