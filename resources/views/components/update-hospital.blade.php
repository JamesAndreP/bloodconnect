<div class="modal fade" id="updateHospitalModal" tabindex="-1" aria-labelledby="updateHospitalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        {{$hospital}}
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="updateHospitalLabel">Update Hospital & User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form method="POST" id="updateHospitalForm">
            @csrf
            @method('PATCH')
            <input type="text" id="update_hospital_id" name="hospital_id" hidden>
            <input type="text" id="update_user_id" name="user_id" hidden>
            <div class="modal-body row g-3">

            <div class="col-md-6">
                <label for="address" class="form-label">Enter Address</label>
                <input type="text" class="form-control" id="update_address" name="address" placeholder="e.g. Cebu City, Philippines">
                <button 
    onclick="geocodeAddress('update')"
    type="button" 
    class="btn text-white" style="background-color:#800000;">
    Find Address
</button>
            </div>
            <div id="update_result" class="mt-3"></div>
            <!-- Hospital Info -->
            <h6 class="text-uppercase text-secondary mb-3">Hospital Info</h6>

            <div class="col-md-6">
                <label for="hospital_name" class="form-label">Hospital Name</label>
                <input type="text" class="form-control" id="update_hospital_name" name="hospital_name" value="{{ old('hospital_name') }}" required>
                @error('hospital_name') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="hospital_location" class="form-label">Hospital Location</label>
                <input type="text" class="form-control" id="update_hospital_location" name="hospital_location" value="{{ old('hospital_location') }}" required readonly>
                @error('hospital_location') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <hr class="mt-4">

            <!-- User Info -->
            <h6 class="text-uppercase text-secondary mb-3">User Info</h6>

            <div class="col-md-6">
                <label for="user_name" class="form-label">Name</label>
                <input type="text" class="form-control" id="update_user_name" name="user_name" value="{{ old('user_name') }}" required>
                @error('user_name') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="user_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="update_user_email" name="user_email" value="{{ old('user_email') }}" required>
                @error('user_email') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="user_password" class="form-label">Password</label>
                <input type="password" placeholder="Remain this empty if you don't want to change the password" class="form-control" id="update_user_password" name="user_password">
                @error('user_password') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            

            <div class="col-md-6">
                <label for="user_phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="update_user_phone" name="user_phone" value="{{ old('user_phone') }}">
                @error('user_phone') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="col-md-6">
                <label for="user_status" class="form-label">Status</label>
                <select class="form-control" id="update_user_status" name="user_status" required>
                <option value="" disabled selected>-- Select Status --</option>
                <option value="Active" {{ old('user_status')=='Active'?'selected':'' }}>Active</option>
                <option value="Inactive" {{ old('user_status')=='Inactive'?'selected':'' }}>Inactive</option>
                </select>
                @error('user_status') <p class="text-danger text-xs mt-1">{{ $message }}</p> @enderror
            </div>

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