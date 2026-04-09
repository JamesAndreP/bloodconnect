<?php

namespace App\Http\Controllers;

use App\Enums\UserStatusEnum;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function create()
    {
        return view('session.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            // 'blood_type' => ['required'],
            'location' => ['required'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required'],
            'phone' => ['required'],
            'agreement' => ['accepted']
        ]);
        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['role'] = 'donor';
        $attributes['status'] = UserStatusEnum::Active;

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $attributes['otp'] = $otp;

        $user = User::create($attributes);
        session()->flash('success', 'Your account has been created.');

        // Auth::login($user);
        Mail::to($user->email)->queue(new OTPMail($user));
        return redirect()->route('otp', ['email' => $user->email]);
    }

    public function otp()
    {
        return view('session.otp');
    }

   public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => ['required', 'email', 'exists:users,email'],
        'otp'   => ['required', 'digits:6']
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'User not found.']);
    }

    // Check if OTP is correct
    if ($user->otp !== $request->otp) {
        return back()->withErrors(['otp' => 'Invalid OTP code.'])->withInput();
    }

    // Check if OTP is expired
    if ($user->otp_expires_at && now()->greaterThan($user->otp_expires_at)) {
        return back()->withErrors(['otp' => 'OTP expired. Please request a new one.'])->withInput();
    }

    // Verify the user
    $user->email_verified_at = now();
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();

    Auth::login($user);

    return redirect('/dashboard')->with('success', 'Your account has been verified.');
}
}