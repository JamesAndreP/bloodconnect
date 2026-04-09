@extends('layouts.user_type.guest')

@section('content')
<section class="min-vh-100 mb-8">
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg"
       style="background-image: linear-gradient(rgba(90,10,10,0.60), rgba(122,15,26,0.80)), url('/assets/img/curved-images/curved14.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center mx-auto">
          <h1 class="text-white mb-2 mt-5"
              style="font-weight:900; text-shadow: 0px 4px 10px rgba(0,0,0,0.4);">
            Verify Your <span style="color:#ff4d4d;">Account</span>
          </h1>
          <p class="text-lead text-white">
            Enter the 6-digit verification code sent to your email.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0 shadow-lg" style="border-radius:20px; border:none;">
          <div class="card-header text-center pt-4 bg-transparent">
            <h4 style="color:#7b0f1a; font-weight:700;">Email Verification</h4>
          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('otp.verify') }}">
              @csrf
              <input type="hidden" name="email" value="{{ request('email') }}">

              <div class="mb-3">
                <input type="text"
                       maxlength="6"
                       class="form-control text-center"
                       placeholder="Enter OTP Code"
                       name="otp"
                       id="otp"
                       required>
                @error('otp')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                @error('email')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              <div class="text-center">
                <button type="submit"
                        class="btn w-100 my-4 mb-2"
                        style="background: linear-gradient(135deg,#7b0f1a,#a31521,#c1121f); color:white; border:none;">
                  VERIFY ACCOUNT
                </button>
              </div>

              {{-- <p class="text-sm text-center mt-3 mb-0">
                Didn’t receive the code?
                <a href="{{ route('login') }}" class="text-dark font-weight-bolder">
                  Resend Code
                </a>
              </p> --}}
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection