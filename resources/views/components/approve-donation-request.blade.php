<div class="modal fade" id="approveDonationRequestModal" tabindex="-1" aria-labelledby="approveDonationRequestModalLable" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="approveDonationRequestModalLable">Confirm Donation Request? Set a Schedule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form id="approveDonationRequestForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body row g-1">
                <div class="col-md-8">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="col-md-8">
                    <label for="notes" class="form-label">Notes</label>
                    <input type="text" class="form-control" id="notes" name="notes" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn text-white" style="background-color:#800000;">Yes</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>