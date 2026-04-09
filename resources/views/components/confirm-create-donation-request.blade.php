@props(['nearbyHospitals' => collect()])

<div class="modal fade" id="confirmCreateDonationRequestModal" tabindex="-1" aria-labelledby="confirmCreateDonationRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="confirmCreateDonationRequestLabel">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="POST" action="/donation-requests">
                @csrf

                <div class="modal-body pt-2">
                    @if(count($nearbyHospitals) > 1)
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Select Hospital</label>
                            <select name="hospital_id" class="form-select rounded-3" required>
                                <option value="">-- Choose Hospital --</option>
                                @foreach($nearbyHospitals as $hospital)
                                    <option value="{{ $hospital->id }}">
                                        {{ $hospital->name }} ({{ round($hospital->distance, 2) }} km)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif(count($nearbyHospitals) == 1)
                        <input type="hidden" name="hospital_id" value="{{ $nearbyHospitals[0]->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Hospital</label>
                            <input type="text" class="form-control rounded-3" value="{{ $nearbyHospitals[0]->name }}" readonly>
                        </div>
                    @endif

                    <p class="text-muted mb-0">Confirm creation of new donation request?</p>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-3">Yes</button>
                </div>
            </form>

        </div>
    </div>
</div>