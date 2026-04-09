<?php

namespace App\Http\Controllers;

use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function store()
    {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $attributes['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email or password invalid.']);
        }

        if (is_null($user->email_verified_at)) {
            $otp = rand(100000, 999999);
            $user->otp = $otp;
            $user->save();
            Mail::to($user->email)->queue(new OTPMail($user));
            return redirect()->route('otp', ['email' => $user->email]);
        }

        if (Auth::attempt($attributes)) {
            session()->regenerate();
            return redirect('dashboard')->with(['success' => 'You are logged in.']);
        } else {

            return back()->withErrors(['email' => 'Email or password invalid.']);
        }
    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/')->with(['success' => 'You\'ve been logged out.']);
    }
}
