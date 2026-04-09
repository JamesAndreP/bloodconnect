@extends('layouts.user_type.guest')

@section('content')

<div class="page-header section-height-75">
    <div class="container">
        <div class="row">

            <!-- LEFT SIDE FORM -->
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                <div class="card card-plain mt-8">

                    @if($errors->any())
                        <div class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                                {{$errors->first()}}
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="m-3 alert alert-success alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                                {{ session('success') }}
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                                <i class="fa fa-close"></i>
                            </button>
                        </div>
                    @endif

                    <div class="card-header pb-0 text-left bg-transparent">
                        <h4 class="mb-0">
                            Forgot your password?
                        </h4>
                        <p class="text-sm text-secondary">
                            Enter your email to receive your password reset link.
                        </p>
                    </div>

                    <div class="card-body">

                        <form action="/forgot-password" method="POST">
                            @csrf

                            <label>Email</label>

                            <div class="mb-3">
                                <input
                                    id="email"
                                    name="email"
                                    type="email"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                >

                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-danger w-100 mt-3">
                                    Recover your password
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE BLOODCONNECT PANEL -->
            <div class="col-lg-7 d-none d-lg-flex align-items-center justify-content-center">

                <div class="bloodconnect-panel text-center">

                    <h1 class="bloodconnect-title">
                        BloodConnect
                    </h1>

                    <p class="bloodconnect-subtitle">
                        AI-Powered Blood Donation and <br>
                        Matching Platform
                    </p>

                </div>

            </div>

        </div>
    </div>
</div>


<style>

.bloodconnect-panel{
    width:100%;
    min-height:520px;
    background:#e53935;
    border-radius:30px;

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;

    padding:40px;

    box-shadow:0 20px 40px rgba(229,57,53,0.25);
}

.bloodconnect-title{
    color:white;
    font-size:50px;
    font-weight:800;
    margin-bottom:15px;
}

.bloodconnect-subtitle{
    color:white;
    font-size:20px;
    line-height:1.6;
}

</style>

@endsection