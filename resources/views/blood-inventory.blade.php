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
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                    <span class="text-white">
                        {{ session('error') }}
                    </span>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close">x</button>
                </div>
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
                    {{-- add inventory modal --}}
                    <x-add-inventory />
                    {{-- deduct inventory modal --}}
                    <x-deduct-inventory />
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Blood Inventory</h5>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="#" class="btn bg-gradient-success btn-sm mb-0"
                                data-bs-toggle="modal"
                                data-bs-target="#addInventoryModal">
                                    + Add
                                </a>
                                <a href="#" class="btn bg-gradient-danger btn-sm mb-0"
                                data-bs-toggle="modal"
                                data-bs-target="#deductInventoryModal">
                                    - Deduct
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                A+
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                A-
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                B+
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                B-
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                AB+
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                AB-
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                O+
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                O-
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['A+'] ?? 0}}</p>
                                                    <a href="/blood-inventory/A+" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['A-'] ?? 0}}</p>
                                                    <a href="/blood-inventory/A-" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['B+'] ?? 0}}</p>
                                                    <a href="/blood-inventory/B+" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['B-'] ?? 0}}</p>
                                                    <a href="/blood-inventory/B-" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['AB+'] ?? 0}}</p>
                                                    <a href="/blood-inventory/AB+" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['AB-'] ?? 0}}</p>
                                                    <a href="/blood-inventory/AB-" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['O+'] ?? 0}}</p>
                                                    <a href="/blood-inventory/O+" class="view-list">View List</a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column align-items-center gap-1">
                                                    <p class="text-center text-m font-weight-bold mb-0">{{$data['O-'] ?? 0}}</p>
                                                    <a href="/blood-inventory/O-" class="view-list">View List</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

.view-list {
    padding: 3px 8px;
    background-color: #56cc32;
    color: #fff;
    border-radius: 8px;
    font-size: 12px;
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