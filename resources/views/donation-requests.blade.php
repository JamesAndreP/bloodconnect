@extends('layouts.user_type.auth')

@section('content')

<div class="donation-request-page-bg">
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
    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                <span class="text-white">
                    {{ session('error') }}
                </span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                {{-- confirm creation of new donation request modal --}}
                <x-confirm-create-donation-request :nearbyHospitals="$nearbyHospitals" />
                {{-- reschedule request modal --}}
                <x-reschedule-request />
@php
    $latestPendingRequest = collect($data->donations)
        ->where('status', 'Pending')
        ->sortByDesc('created_at')
        ->first();

    $latestApprovedRequest = collect($data->donations)
        ->where('status', 'Approved')
        ->sortByDesc('created_at')
        ->first();

    $eligibleDate = null;
    $blockMessage = null;

    if ($latestPendingRequest) {
        $blockMessage = 'You already have a pending donation request.';
    } elseif ($latestApprovedRequest) {
        $eligibleDate = strtoupper($data->gender) === 'MALE'
            ? $latestApprovedRequest->created_at->copy()->addMonths(4)
            : $latestApprovedRequest->created_at->copy()->addMonths(3);

        if ($eligibleDate->isFuture()) {
            $blockMessage = 'You can donate again on ' . $eligibleDate->format('F d, Y') . '.';
        }
    }

    $hasBlockingRequest = $latestPendingRequest || ($eligibleDate && $eligibleDate->isFuture());
@endphp
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Donation Requests</h5>
                        </div>
                        @if(!$hasBlockingRequest)
    <a href="#" class="btn btn-danger btn-sm mb-0"
       data-bs-toggle="modal"
       data-bs-target="#confirmCreateDonationRequestModal">
       +&nbsp; New
    </a>
@else
    <div class="text-end">
        <button class="btn btn-secondary btn-sm mb-0" disabled>
            +&nbsp; New
        </button>

        @if(isset($blockMessage))
            <div>
                <small class="text-danger fw-bold">
                    {{ $blockMessage }}
                </small>
            </div>
        @endif
    </div>
@endif
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0" style="overflow-x: auto;">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hospital</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hospital Location</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creation Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Scheduled Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Requested Date Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->donations as $dat)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{$data->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$data->email}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{explode('|', $data->location)[0]}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{$dat->hospital->name}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->hospital->location)[0]}}</p>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->created_at->format('Y-m-d')}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->date}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{$dat->latestActiveSchedule?->status ?? $dat->status}}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $dat->latestRescheduleRequest ? $dat->latestRescheduleRequest?->date :  $dat->latestDeclinedRescheduleRequest?->date}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $dat->latestRescheduleRequest ? $dat->latestRescheduleRequest?->status :  $dat->latestDeclinedRescheduleRequest?->status}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="#"
                                            class="mx-3 {{!$dat->latestActiveSchedule?->date ? 'disabled': ''}}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rescheduleRequestModal"
                                            data-id="{{ $dat->id }}"
                                        >
                                            <i class="fas fa-user-edit text-secondary"></i>
                                        </a>
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

@endsection

@push('styles')
<style>
.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

a.disabled {
    pointer-events: none;
    opacity: 0.5;
    cursor: not-allowed;
    text-decoration: none;
}

.donation-request-page-bg {
    min-height: 100vh;
    padding-top: 10px;
    border-radius: 15px;
    background-image:
        linear-gradient(rgba(255,255,255,0.88), rgba(255,255,255,0.88)),
        url('/assets/img/hospital-bg.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

/* ✅ TABLE FIX ONLY */
.table th,
.table td {
    white-space: nowrap;
    vertical-align: middle;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const rescheduleRequestModal = document.getElementById('rescheduleRequestModal');
    const rescheduleRequestForm = document.getElementById('rescheduleRequestForm');

    rescheduleRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');

        rescheduleRequestForm.action = `/donation-requests/reschedule/${id}`;
    });
});
</script>
@endpush