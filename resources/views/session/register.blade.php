@extends('layouts.user_type.guest')

@section('content')

<section class="min-vh-100 mb-8">

  <!-- HEADER -->
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg"
       style="background-image: linear-gradient(rgba(90,10,10,0.55), rgba(122,15,26,0.70)), url('/assets/img/hospital-bg.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

    <span class="mask bg-gradient-dark opacity-6"></span>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 text-center mx-auto">

          <!-- 🔥 TITLE ONLY (NO LOGO) -->
          <h1 class="text-white mb-2 mt-4 text-center"
              style="font-weight:900; font-size:48px; letter-spacing:1px; text-shadow: 0px 4px 10px rgba(0,0,0,0.4);">
            Blood<span style="color:#ff4d4d;">Connect</span>
          </h1>

          <p class="text-white text-center mb-0" style="font-size:18px;">
            Create your account and help save lives.
          </p>

        </div>
      </div>
    </div>
  </div>

  <!-- FORM -->
  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">

        <div class="card shadow-lg" style="border-radius:20px; border:none;">

          <div class="card-header text-center pt-4 bg-transparent">
            <h4 style="color:#7b0f1a; font-weight:700;">Register</h4>
          </div>

          <div class="card-body">
            <form method="POST" action="/register">
              @csrf

              <!-- ADDRESS -->
              <div class="mb-3">
                <input type="text"
                       id="address"
                       class="form-control"
                       placeholder="Barangay, City/Municipality">
              </div>

              <!-- FIND ADDRESS -->
              <div class="text-center">
                <button type="button"
                        onclick="geocodeAddress()"
                        class="btn bg-gradient-dark w-100 mb-3"
                        style="background: linear-gradient(135deg,#7b0f1a,#a31521,#c1121f); color:white; border:none;">
                  Find Address
                </button>
              </div>

              <div id="result" class="mb-3"></div>

              <!-- NAME -->
              <div class="mb-3">
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Name"
                       value="{{ old('name') }}">
                @error('name')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- EMAIL -->
              <div class="mb-3">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Email"
                       value="{{ old('email') }}">
                @error('email')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- PASSWORD -->
              <div class="mb-3">
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Password">
                @error('password')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- BIRTHDATE -->
              <div class="mb-3">
                <input type="date"
                       name="birth_date"
                       class="form-control"
                       value="{{ old('birth_date') }}">
                @error('birth_date')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- GENDER -->
              <div class="mb-3">
                <select name="gender" class="form-control">
                  <option value="">-- Select Gender --</option>
                  <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                  <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                  <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- BLOODTYPE -->
              <div class="mb-3">
                <select name="blood_type" class="form-control">
                  <option value="">-- Select Blood Type --</option>
                  <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                  <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                  <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                  <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                  <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                  <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                  <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                  <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                </select>
                @error('blood_type')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- PHONE -->
              <div class="mb-3">
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Phone Number"
                       value="{{ old('phone') }}">
                @error('phone')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- LOCATION -->
              <div class="mb-3">
                <input type="text"
                       name="location"
                       id="location"
                       class="form-control"
                       placeholder="Location"
                       value="{{ old('location') }}"
                       readonly
                       required>
                @error('location')
                  <p class="text-danger text-xs">{{ $message }}</p>
                @enderror
              </div>

              <!-- AGREEMENT -->
              <div class="form-check">
                <input class="form-check-input"
                       type="checkbox"
                       name="agreement"
                       {{ old('agreement') ? 'checked' : '' }}>
                <label class="form-check-label">
                  I agree to Terms and Conditions
                </label>
                @error('agreement')
                  <p class="text-danger text-xs">Please accept terms</p>
                @enderror
              </div>

              <!-- SUBMIT -->
              <div class="text-center">
                <button type="submit"
                        class="btn bg-gradient-dark w-100 my-4"
                        style="background: linear-gradient(135deg,#7b0f1a,#a31521,#c1121f); color:white; border:none;">
                  Sign Up
                </button>
              </div>

              <p class="text-sm text-center">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
              </p>

            </form>
          </div>

        </div>

      </div>
    </div>
  </div>

</section>

<!-- SCRIPT -->
<script>
async function geocodeAddress() {
    const address = document.getElementById("address").value;
    const resultBox = document.getElementById("result");
    const locationInput = document.getElementById("location");

    if (!address) {
        alert("Please enter an address");
        return;
    }

    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}&limit=1`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.length > 0) {
            const lat = data[0].lat;
            const lon = data[0].lon;

            locationInput.value = address + '|' + lat + '|' + lon;

            resultBox.innerHTML = `
                <div class="alert alert-light">
                    <strong>Location found:</strong><br>
                    Lat: ${lat}<br>
                    Lon: ${lon}
                </div>
            `;
        } else {
            resultBox.innerHTML = `<div class="alert alert-warning">No results found</div>`;
            locationInput.value = '';
        }
    } catch (error) {
        console.error(error);
        alert("Error fetching location");
    }
}
</script>

@endsection