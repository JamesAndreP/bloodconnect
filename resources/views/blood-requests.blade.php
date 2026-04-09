@extends('layouts.user_type.auth')

@section('content')

<div class="blood-request-bg">
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
        {{-- @if($errors->any())
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>Validation Error:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    {{-- new blood request modal --}}
                    <x-create-blood-request />
                    {{-- fulfill blood request modal --}}
                    <x-fulfill-blood-request />
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
    <div>
        <h5 class="mb-0">Blood Requests</h5>
    </div>

    <div class="d-flex gap-2">
        <!-- SORT DROPDOWN -->
        <form method="GET" action="{{ url('/blood-requests') }}">
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Sort</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest to Oldest</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest to Newest</option>
            </select>
        </form>

        <!-- ONLY ONE NEW BUTTON -->
        <a href="#" class="btn bg-gradient-danger btn-sm mb-0"
           data-bs-toggle="modal"
           data-bs-target="#createBloodRequestModal">
            + New
        </a>
    </div>
</div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            ID
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Requester
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Location
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Blood Type
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Quantity
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Urgency Level
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Request Date
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Fulfilled By
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $dat)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->id}}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->hospital->name}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->hospital->user->email}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{explode('|', $dat->hospital->location)[0]}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->blood_type}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">{{$dat->quantity}}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->urgency_lvl}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->request_date->format('Y-m-d')}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->status}}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{$dat->confirmedBy ? $dat->confirmedBy->name : null }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a 
                                                href="#"
                                                class="mx-3 {{(Auth::user()->id === $dat->hospital->user->id || $dat->status === 'Fulfilled') ? 'disabled' : ''}}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#fulfillBloodRequestModal"
                                                data-bs-original-title="Edit user"
                                                data-id="{{ $dat->id }}"
                                            >
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                            {{-- <span>
                                                <a
                                                    href="#"
                                                    class="mx-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteHospitalModal"
                                                    data-bs-original-title="Delete user"
                                                    data-id="{{ $dat->id }}"
                                                    data-name="{{ $dat->name }}"
                                                >
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a>
                                            </span> --}}
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
</div>
@endsection

@push('styles')
<style>
.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}
a.disabled {
    pointer-events: none;   /* disables clicking */
    opacity: 0.5;           /* visual feedback */
    cursor: not-allowed;    /* shows disabled cursor */
    text-decoration: none;
}
.blood-request-bg {
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const fulfillBloodRequestModal = document.getElementById('fulfillBloodRequestModal');
    const fulfillBloodRequestForm = document.getElementById('fulfillBloodRequestForm');
    fulfillBloodRequestModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget; // the clicked button
        let id = button.getAttribute('data-id');

        fulfillBloodRequestForm.action = `/blood-requests/fulfill/${id}`;
    });
});
</script>
@endpush