<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl blood-topbar" id="navbarBlur" navbar-scroll="true">
    <style>
        .blood-topbar {
            background: rgba(255, 255, 255, 0.35) !important;
            border: 1px solid rgba(179, 0, 0, 0.12);
            box-shadow: 0 8px 24px rgba(128, 0, 0, 0.08);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .blood-topbar .breadcrumb-item a {
            color: #8b0000 !important;
            font-weight: 500;
        }

        .blood-topbar .breadcrumb-item.active {
            color: #4a0d0d !important;
            font-weight: 600;
        }

        .blood-topbar h6 {
            color: #800000 !important;
            font-weight: 700;
        }

        .blood-topbar .nav-link {
            color: #7a1c1c !important;
            font-weight: 600;
            transition: 0.2s ease;
        }

        .blood-topbar .nav-link:hover {
            color: #b30000 !important;
        }

        .blood-topbar .fa-user {
            color: #ffffff !important;
        }

        .blood-topbar .sidenav-toggler-line {
            background: #800000 !important;
        }

        .blood-logout {
            background: rgba(179, 0, 0, 0.88);
            color: #ffffff !important;
            padding: 5px 10px !important;
            border-radius: 0.9rem;
            box-shadow: 0 8px 18px rgba(179, 0, 0, 0.18);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .blood-logout i,
        .blood-logout span {
            color: #ffffff !important;
        }

        .blood-logout:hover {
            background: rgba(128, 0, 0, 0.95);
            color: #ffffff !important;
            transform: translateY(-1px);
        }
    </style>

    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a href="javascript:;">Pages</a>
                </li>
                <li class="breadcrumb-item text-sm active text-capitalize" aria-current="page">
                    {{ str_replace('-', ' ', Request::path()) }}
                </li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            <ul class="navbar-nav justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="{{ url('/logout') }}" class="nav-link font-weight-bold px-0 blood-logout">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">Sign Out</span>
                    </a>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->