<div class="modal fade" id="deleteHospitalModal" tabindex="-1" aria-labelledby="deleteHospitalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-radius-xl">
        <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="deleteHospitalLabel">Delete Hospital</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form -->
        <form method="POST" id="deleteHospitalForm">
            @csrf
            @method('DELETE')
            <div class="modal-body row g-1">
                <div id="delete_hospital_name"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn text-white" style="background-color:#800000;">Delete</button>
            </div>
        </form>
        <!-- End Form -->

        </div>
    </div>
</div>