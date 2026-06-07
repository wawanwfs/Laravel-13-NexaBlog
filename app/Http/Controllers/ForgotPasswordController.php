<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    public function sendLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Email tidak ditemukan dalam sistem kami.',
        ]);

        // Delete existing tokens for this email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => bcrypt($token),
            'created_at' => now(),
        ]);

        $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);

        // Send email via Laravel mail (logs to file in local env)
        Mail::send('emails.reset-password', ['resetUrl' => $resetUrl, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Password - NexaBlog');
        });

        return back()->with('success', 'Link reset password telah dikirim ke email Anda. Periksa inbox atau folder spam.');
    }
}
