<div class="modal fade" id="confirmCancelDonationRequestModal" tabindex="-1" aria-labelledby="confirmCancelDonationRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="confirmCancelDonationRequestLabel">Confirm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form id="confirmCancelDonationForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-body row g-1">
                <div id="delete_hospital_name">Confirm cancellation of donation request?</div>
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