<div class="modal fade" id="createHospitalModal" tabindex="-1" aria-labelledby="createHospitalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="createHospitalLabel">Register Hospital & User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('hospitals.store') }}">
            @csrf
            <div class="modal-body row g-3">

            <div class="col-md-6">
                <label for="address" class="form-label">Enter Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="e.g. Cebu City, Philippines">
                <button 
    onclick="geocodeAddress('create')"
    type="button" 
    class="btn text-white" style="background-color:#800000;">
    Find Address
</button>
            </div>
            <div id="result" class="mt-3"></div>
            <!-- Hospital Info -->
            <h6 class="text-uppercase text-secondary mb-3">Hospital Info</h6>

            <div class="col-md-6">
                <label for="hospital_name" class="form-label">Hospital Name</label>
                <input type="text" class="form-control" id="hospital_name" name="hospital_name" value="{{ old('hospital_name') }}" required>
                @error('hospital_name') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="hospital_location" class="form-label">Hospital Location</label>
                <input type="text" class="form-control" id="hospital_location" name="hospital_location" value="{{ old('hospital_location') }}" required readonly>
                @error('hospital_location') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <hr class="mt-4">

            <!-- User Info -->
            <h6 class="text-uppercase text-secondary mb-3">User Info</h6>

            <div class="col-md-6">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" required>
                @error('user_name') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="{{ old('user_email') }}" required>
                @error('user_email') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="user_password" class="form-label">Password</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
                @error('user_password') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

          

            

            <div class="col-md-6">
                <label for="user_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="user_phone" name="user_phone" value="{{ old('user_phone') }}">
                @error('user_phone') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- <div class="col-md-6">
                <label for="user_status" class="form-label">Status</label>
                <select class="form-control" id="user_status" name="user_status" required>
                <option value="" disabled selected>-- Select Status --</option>
                <option value="active" {{ old('user_status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ old('user_status')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
                @error('user_status') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div> --}}

            </div>

            <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn text-white" style="background-color:#800000;">SAVE HOSPITAL</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>