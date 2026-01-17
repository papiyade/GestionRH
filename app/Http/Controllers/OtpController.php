<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\OtpCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function requestOtp()
    {
        $user = Auth::user();

        // Génération du code
        $code = rand(100000, 999999);

        // Suppression des anciens OTP
        OtpCode::where('user_id', $user->id)->delete();

        // Enregistrement
        OtpCode::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Envoi email
        Mail::to($user->email)->send(new SendOtpMail($code));

        return view('otp.verify')->with('message', 'Un code OTP vous a été envoyé.');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = OtpCode::where('user_id', Auth::id())
            ->where('code', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp' => 'Code OTP invalide ou expiré']);
        }

        // OTP validé
        session(['otp_verified' => true]);

        $otp->delete();

        return redirect(session('otp_target_route', '/'));
    }


    public function resendOtp()
    {
        return $this->requestOtp();
    }
}
