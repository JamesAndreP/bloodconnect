@extends('layouts.user_type.guest')

@section('content')

<main class="main-content mt-0">
  <section class="bloodconnect-login-section">
    <div class="bloodconnect-page-overlay"></div>

    <div class="page-header min-vh-75 position-relative">
      <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center justify-content-between">

          <!-- LEFT LOGIN AREA -->
          <div class="col-xl-7 col-lg-7 col-md-10 d-flex flex-column mx-auto mx-lg-0">

            <div class="card card-plain mt-8">
              <div class="card-header pb-0 text-left bg-transparent">
                <h3 class="font-weight-bolder bloodconnect-red-title">Welcome back</h3>
                <p class="mb-0">Create a new account</p>
                <p class="mb-0">OR Sign in with your credentials:</p>
              </div>

              <div class="card-body">
                @if (session('success'))
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="alert-text text-white">{{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  </div>
                @endif

                <form role="form" method="POST" action="/session">
                  @csrf

                  <label>Email</label>
                  <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                    @error('email')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>

                  <label>Password</label>
                  <div class="mb-3 position-relative">
                    <input
                      type="password"
                      class="form-control"
                      name="password"
                      id="password"
                      placeholder="Password"
                    >

                    <span
                      class="position-absolute top-50 end-0 translate-middle-y me-3"
                      style="cursor: pointer;"
                      onclick="togglePassword()"
                    >
                      <i id="togglePasswordIcon" class="fa fa-eye"></i>
                    </span>

                    @error('password')
                      <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn bloodconnect-signin-btn w-100 mt-4 mb-0">
                      Sign in
                    </button>
                  </div>
                </form>
              </div>

              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <small class="text-muted">
                  Forgot your password?
                  <a href="/login/forgot-password" class="bloodconnect-link">
                    Reset here
                  </a>
                </small>

                <p class="mb-4 text-sm mx-auto">
                  Don't have an account?
                  <a href="register" class="bloodconnect-link">
                    Sign up
                  </a>
                </p>
              </div>
            </div>

          </div>

          <!-- RIGHT BRAND PANEL -->
          <div class="col-xl-4 col-lg-5 d-none d-lg-flex align-items-center justify-content-center">
            <div class="bloodconnect-brand-panel text-center text-white">
              <div class="bloodconnect-brand-title">BloodConnect</div>
              <p class="bloodconnect-brand-subtitle mb-0">
                AI-Powered Blood Donation and Matching Platform
              </p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- FULL WIDTH INFO SECTION -->
  <section class="bloodconnect-info-section">
    <div class="container">
      <div class="row justify-content-center g-4">

        <!-- ABOUT BLOODCONNECT -->
        <div class="col-lg-5 col-md-6">
          <div class="card info-card h-100">
            <div class="card-body">

              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-droplet text-danger me-2 about-bloodconnect-icon"></i>
                <h5 class="mb-0 fw-bold">
                  About <span class="text-danger">BloodConnect</span>
                </h5>
              </div>

              <p class="text-secondary mb-0">
                BloodConnect is an AI-powered blood donation and matching platform designed
                to connect donors, hospitals, and patients quickly and efficiently.
                The system helps identify compatible donors and notify them instantly
                during urgent blood requests.
              </p>

            </div>
          </div>
        </div>

        <!-- WHY DONATE BLOOD -->
        <div class="col-lg-5 col-md-6">
          <div class="card info-card h-100">
            <div class="card-body">

              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-droplet text-danger me-2 about-bloodconnect-icon"></i>
                <h5 class="mb-0 fw-bold">
                  Why Donate <span class="text-danger">Blood?</span>
                </h5>
              </div>

              <p class="mb-2">
                <i class="fa-solid fa-droplet text-danger me-2 small-drop-icon"></i>
                One donation can save up to <span class="text-danger fw-bold">3 lives</span>
              </p>

              <p class="mb-2">
                <i class="fa-solid fa-droplet text-danger me-2 small-drop-icon"></i>
                Blood is needed every day in hospitals
              </p>

              <p class="mb-2">
                <i class="fa-solid fa-droplet text-danger me-2 small-drop-icon"></i>
                Helps patients during surgery
              </p>

              <p class="mb-0">
                <i class="fa-solid fa-droplet text-danger me-2 small-drop-icon"></i>
                Supports emergency treatments
              </p>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

@endsection

@push('styles')
<style>
.bloodconnect-login-section {
  position: relative;
  min-height: 100vh;
  background-image: url('/assets/img/hospital-bg.jpg');
  background-position: center;
  background-size: cover;
  background-repeat: no-repeat;
  overflow: hidden;
}

.bloodconnect-page-overlay {
  position: absolute;
  inset: 0;
  background: rgba(245, 247, 250, 0.90);
  z-index: 1;
}

.bloodconnect-info-section {
  padding: 40px 0 60px 0;
  background: rgba(245, 247, 250, 0.90);
}

.card {
  background: rgba(255,255,255,0.92);
  backdrop-filter: blur(6px);
  border-radius: 18px;
}

.info-card {
  border-radius: 16px;
  border: 1px solid #e9ecef;
  box-shadow: 0 8px 20px rgba(0,0,0,0.05);
  background: rgba(255,255,255,0.92);
  padding: 10px;
  width: 100%;
}

.info-card p {
  font-size: 15px;
  line-height: 1.8;
}

.about-bloodconnect-icon {
  font-size: 22px;
}

.small-drop-icon {
  font-size: 11px;
}

.bloodconnect-brand-panel {
  background: rgba(218, 40, 46, 0.92);
  padding: 60px 40px;
  border-radius: 24px;
  max-width: 420px;
  width: 100%;
  box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
}

.bloodconnect-brand-title {
  font-size: 42px;
  font-weight: 700;
  line-height: 1.2;
}

.bloodconnect-brand-subtitle {
  margin-top: 12px;
  font-size: 18px;
  line-height: 1.7;
}

.bloodconnect-red-title {
  color: #da282e !important;
  background: none !important;
  -webkit-text-fill-color: #da282e !important;
}

.bloodconnect-signin-btn {
  background: #da282e !important;
  color: #ffffff !important;
  border: none !important;
  box-shadow: 0 6px 20px rgba(218,40,46,0.35);
  transition: all .25s ease;
}

.bloodconnect-signin-btn:hover {
  background: #b81f24 !important;
  color: #ffffff !important;
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(218,40,46,0.45);
}

.bloodconnect-link {
  color: #da282e !important;
  font-weight: 600;
  text-decoration: underline;
}

.bloodconnect-link:hover {
  color: #b81f24 !important;
}

@media (max-width: 991.98px) {
  .bloodconnect-login-section {
    background-position: center;
    min-height: auto;
    padding-bottom: 20px;
  }

  .bloodconnect-info-section {
    padding-top: 20px;
  }
}
</style>
@endpush

@push('scripts')
<script>
function togglePassword() {
  const passwordInput = document.getElementById('password');
  const icon = document.getElementById('togglePasswordIcon');

  if (passwordInput.type === 'password') {
    passwordInput.type = 'text';
    icon.classList.remove('fa-eye');
    icon.classList.add('fa-eye-slash');
  } else {
    passwordInput.type = 'password';
    icon.classList.remove('fa-eye-slash');
    icon.classList.add('fa-eye');
  }
}
</script>
@endpush