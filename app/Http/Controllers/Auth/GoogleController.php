<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();
        } catch (\Exception $e) {
            return redirect('/login')
                ->withErrors('Gagal login dengan Google, silakan coba lagi.');
        }

        // cari berdasarkan id_google
        $user = User::where('id_google', $googleUser->id)->first();

        // kalau belum ada, cek email
        if (!$user) {
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                $user->update([
                    'id_google' => $googleUser->id
                ]);
            } else {
                // user baru
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'id_google' => $googleUser->id,
                    'password'  => bcrypt(Str::random(32)), // wajib untuk Breeze
                ]);
            }
        }

// OTP PART (SIMPLE VERSION)
$otp = rand(100000, 999999);

$user->update([
    'otp' => $otp,
]);

session(['otp_user_id' => $user->id]);

Mail::raw("Kode OTP kamu adalah: $otp", function ($message) use ($user) {
    $message->to($user->email)->subject('Kode OTP Login');
});

return redirect('/otp');

    }
}
 