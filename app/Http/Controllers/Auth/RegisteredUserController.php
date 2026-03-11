<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $otp = rand(100000, 999999);
        $tempUser = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'otp' => $otp,
        ];
        Session::put('temp_user', $tempUser);

          Mail::raw("លេខកូដផ្ទៀងផ្ទាត់របស់អ្នកគឺ: $otp", function($message) use ($request) {
            $message->to($request->email)->subject('Account Verification Code');
        });

        return redirect()->route('otp.view');
    }

    public function otpView(): View
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate(['otp' => 'required']);
        $tempUser = Session::get('temp_user');

        if ($tempUser && $request->otp == $tempUser['otp']) {
            $user = User::create([
                'name' => $tempUser['name'],
                'email' => $tempUser['email'],
                'password' => $tempUser['password'],
                'email_verified_at' => now(),
            ]);

            Session::forget('temp_user');
            Auth::login($user);
            return redirect()->route('index');
        }

        return back()->withErrors(['otp' => 'Password Incorrect!']);
    }
}