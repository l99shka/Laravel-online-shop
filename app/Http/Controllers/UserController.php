<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Service\MessageService;
use Illuminate\Auth\Events\Registered;
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

    public function create(RegistrationRequest $request, MessageService $service)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
            'role'      => 'user'
            ]
        );

        if ($user) {
            Auth::login($user);
            $queue = 'Registration';
            $data = [
                'id' => $user->id
            ];
            $service->publish($queue, $data);

            return redirect()->route('verification.notice');
        }

        return redirect()->intended();
    }

    public function login()
    {
        return view('auth.login');
    }

    public function authorizeUser(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended();
        } else {
            throw ValidationException::withMessages([
                'auth' => '*Неверный логин или пароль'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
