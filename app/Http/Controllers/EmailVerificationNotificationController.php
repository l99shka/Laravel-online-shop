<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->back();
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Ссылка для подтверждения отправлена!');
    }
}
