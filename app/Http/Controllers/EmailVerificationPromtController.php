<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationPromtController extends Controller
{
    public function __invoke(Request $request): View|Factory|RedirectResponse|Application
    {
        return ($request->user()->hasVerifiedEmail())
            ? redirect()->back()
            : view('auth.verify-email');
    }
}
