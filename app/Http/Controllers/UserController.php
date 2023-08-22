<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function create()
    {
        return view('auth.registration');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'min:6', 'max:24'],
            'email' => ['required', 'string', 'email', 'unique:users', 'min:6', 'max:24'],
            'phone' => ['required', 'string', 'min:6', 'max:24'],
            'password' => ['required', 'confirmed' , 'min:8', 'max:24']
        ]);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
            ]
        );

        return redirect('/registration');
    }
}
