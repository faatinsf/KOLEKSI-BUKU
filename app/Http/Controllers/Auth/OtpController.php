<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function index()
    {
        return view('auth.otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = User::find(session('otp_user_id'));

        if (!$user || $user->otp !== $request->otp) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }

        // OTP benar
        $user->update(['otp' => null]);

        Auth::login($user);
        session()->forget('otp_user_id');

        return redirect('/home');
    }
}

