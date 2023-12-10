<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVerificationPromtController extends Controller
{
    public function __invoke(Request $request)
    {
        return ($request->user()->hasVerifiedEmail())
        ? redirect()->back()
        : view('auth.verify-email');
    }
}
