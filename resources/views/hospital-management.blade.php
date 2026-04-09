@extends('layouts.user_type.auth')

@section('content')

<div class="hospital-page-wrap"
     style="background-image: linear-gradient(135deg, rgba(65,0,0,0.45), rgba(128,0,0,0.30)), url('/assets/img/hospital-bg.jpg');">

    {{-- MODALS --}}
    <x-create-hospital />
    <x-update-hospital />
    <x-delete-hospital />

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mx-4 hospital-success-alert" role="alert">
            <span class="text-white">
                {{ session('success') }}
            </span>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert">x</button>
        </div>
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show mx-4 hospital-danger-alert" role="alert">
                <span class="text-white">{{ $error }}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert">x</button>
            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4 hospital-main-card">

                <div class="card-header pb-0 hospital-card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0 hospital-page-title">All Hospitals</h5>

                        <a href="#"
                           class="btn btn-sm hospital-new-btn"
                           data-bs-toggle="modal"
                           data-bs-target="#createHospitalModal">
                           + New
                        </a>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0 hospital-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Admin</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($data as $dat)
                                <tr>
                                    <td>{{$dat->id}}</td>
                                    <td>{{$dat->name}}</td>
                                    <td class="text-center">{{ explode('|',$dat->location)[0] }}</td>
                                    <td class="text-center">{{$dat->user->name}}</td>
                                    <td class="text-center">{{$dat->user->email}}</td>
                                    <td class="text-center">{{$dat->created_at->format('Y-m-d')}}</td>

                                    <td class="text-center">
                                        <a href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#updateHospitalModal"
                                           data-id="{{ $dat->id }}"
                                           data-hospital-name="{{ $dat->name }}"
                                           data-location="{{ $dat->location }}"
                                           data-user-id="{{ $dat->user->id }}"
                                           data-user-name="{{ $dat->user->name }}"
                                           data-user-email="{{ $dat->user->email }}"
                                           data-user-birth-date="{{ $dat->user->birth_date }}"
                                           data-user-gender="{{ $dat->user->gender }}"
                                           data-user-phone="{{ $dat->user->phone }}"
                                           data-user-status="{{ $dat->user->status }}">
                                           ✏️
                                        </a>

                                        <a href="#"
                                           data-bs-toggle="modal"
                                           data-bs-target="#deleteHospitalModal"
                                           data-id="{{ $dat->id }}"
                                           data-name="{{ $dat->name }}">
                                           🗑️
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>

                        @if(count($data) == 0)
                            <div class="text-center py-4">
                                No hospitals found.
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

<style>
.hospital-new-btn {
    background: linear-gradient(135deg, #dc2626, #7f1d1d) !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 12px !important;
    padding: 10px 20px !important;
    font-weight: 600 !important;

    box-shadow:
        0 4px 12px rgba(127, 29, 29, 0.4),
        0 0 0 rgba(220, 38, 38, 0);

    transition: all 0.25s ease-in-out;
}

.hospital-new-btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow:
        0 6px 18px rgba(127, 29, 29, 0.5),
        0 0 12px rgba(220, 38, 38, 0.6);
}

.hospital-new-btn:active {
    transform: scale(0.98);
    box-shadow:
        0 3px 8px rgba(127, 29, 29, 0.3);
}
</style>

<script>
async function geocodeAddress(method) {
    let address = method === 'create'
        ? document.getElementById("address").value
        : document.getElementById("update_address").value;

    if (!address) {
        alert("Please enter an address");
        return;
    }

    const url = `https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(address)}&limit=1`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.length > 0) {
            const lat = data[0].lat;
            const lon = data[0].lon;
            const formatted = address + '|' + lat + '|' + lon;

            if (method === 'create') {
                document.getElementById('hospital_location').value = formatted;
                document.getElementById("result").innerHTML =
                    `<p><b>Lat:</b> ${lat}</p><p><b>Lng:</b> ${lon}</p>`;
            } else {
                document.getElementById('update_hospital_location').value = formatted;
                document.getElementById("update_result").innerHTML =
                    `<p><b>Lat:</b> ${lat}</p><p><b>Lng:</b> ${lon}</p>`;
            }
        } else {
            alert("No results found");
        }
    } catch (error) {
        console.error(error);
        alert("Error fetching location");
    }
}

document.addEventListener("DOMContentLoaded", () => {

    const updateModal = document.getElementById('updateHospitalModal');
    const updateForm = document.getElementById('updateHospitalForm');

    updateModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;

        let id = button.getAttribute('data-id');

        document.getElementById('update_hospital_id').value = id;
        document.getElementById('update_hospital_name').value = button.getAttribute('data-hospital-name');
        document.getElementById('update_hospital_location').value = button.getAttribute('data-location');
        document.getElementById('update_user_id').value = button.getAttribute('data-user-id');
        document.getElementById('update_user_name').value = button.getAttribute('data-user-name');
        document.getElementById('update_user_email').value = button.getAttribute('data-user-email');
        document.getElementById('update_user_birth_date').value = button.getAttribute('data-user-birth-date');
        document.getElementById('update_user_gender').value = button.getAttribute('data-user-gender');
        document.getElementById('update_user_phone').value = button.getAttribute('data-user-phone');
        document.getElementById('update_user_status').value = button.getAttribute('data-user-status');

        updateForm.action = `/hospitals/${id}`;
    });

    const deleteModal = document.getElementById('deleteHospitalModal');
    const deleteForm = document.getElementById('deleteHospitalForm');

    deleteModal.addEventListener('show.bs.modal', event => {
        let button = event.relatedTarget;

        let id = button.getAttribute('data-id');
        let name = button.getAttribute('data-name');

        document.getElementById('delete_hospital_name').innerHTML =
            "Are you sure you want to delete <b>" + name + "</b>?";

        deleteForm.action = `/hospitals/${id}`;
    });

});
</script>