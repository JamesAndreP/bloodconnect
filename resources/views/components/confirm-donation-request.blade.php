<div class="modal fade" id="confirmDonationRequestModal" tabindex="-1" aria-labelledby="confirmDonationRequestModalLable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="confirmDonationRequestModalLable">Confirm Donation Request?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form id="confirmDonationRequestForm" method="POST">
            @csrf
            {{-- <div class="modal-body row g-1">
                <div class="col-md-8">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="col-md-8">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" class="form-control" id="notes" name="notes" required>
                </div>
            </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn text-white" style="background-color:#800000;">Yes</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>