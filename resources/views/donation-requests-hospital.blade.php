@extends('layouts.user_type.auth')

@section('content')

<div class="donation-bg"> <!-- ✅ ADDED WRAPPER -->

<div>
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                <span class="text-white">
                    {{ session('success') }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
    @endif
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <span class="text-white">
                    {{ $error }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                {{-- approve donation request modal --}}
                <x-approve-donation-request />
                {{-- confirm cancellation of donation request modal --}}
                <x-confirm-cancel-donation-request />

                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between align-items-center">
    <div>
        <h5 class="mb-0">Donation Requests</h5>
    </div>

    <!-- ONLY DROPDOWN (NO BUTTON) -->
    <form method="GET" action="{{ url('/donation-requests/hospital') }}">
        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Sort</option>
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
        </select>
    </form>
</div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creation Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dat)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->user->email}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->user->location)[0]}}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->created_at->format('Y-m-d')}}</span>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->status}}</p>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="#"
                                            class="mx-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#approveDonationRequestModal"
                                            data-id="{{ $dat->id }}"
                                        >
                                            <i class="fa-solid fa-thumbs-up"></i>
                                        </a>
                                        <span>
                                            <a
                                                href="#"
                                                class="mx-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmCancelDonationRequestModal"
                                                data-id="{{ $dat->id }}"
                                            >
                                                <i class="fa-solid fa-thumbs-down"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</div> <!-- ✅ END WRAPPER -->

@endsection

@push('styles')
<style>
.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

/* ✅ ONLY ADDED THIS BACKGROUND */
.donation-bg {
    min-height: 100vh;
    padding-top: 10px;
    border-radius: 15px;
    background-image:
        linear-gradient(rgba(255,255,255,0.90), rgba(255,255,255,0.90)),
        url('/assets/img/hospital-bg.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const approveModal = document.getElementById('approveDonationRequestModal');
    const approveForm = document.getElementById('approveDonationRequestForm');
    const deleteModal = document.getElementById('confirmCancelDonationRequestModal');
    const deleteForm = document.getElementById('confirmCancelDonationForm');

    approveModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        approveForm.action = `/donation-requests/approve/${id}`;
    });

    deleteModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        deleteForm.action = `/donation-requests/cancel/${id}`;
    });
});
</script>
@endpush