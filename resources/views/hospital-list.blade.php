<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BloodConnect - Hospitals</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('landing/css/responsive.css') }}">
    <link rel="icon" href="{{ asset('landing/images/fevicon.png') }}" type="image/gif" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Sen:400,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('landing/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #7a0f1d 0%, #b3172b 45%, #c92b3c 100%);
            min-height: 100vh;
        }

        .top_navbar {
            background: linear-gradient(90deg, #7a0f1d 0%, #5e0c17 100%);
            padding: 18px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .brand_wrap {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand_logo {
            height: 38px;
            width: auto;
            object-fit: contain;
            margin-right: 10px;
        }

        .brand_text {
            color: #fff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
        }

        .login_btn_wrap {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .login_btn_wrap a {
            background: #ff2230;
            color: #fff;
            text-decoration: none;
            padding: 12px 26px;
            border-radius: 12px;
            font-weight: 700;
            display: inline-block;
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
            transition: 0.3s ease;
        }

        .login_btn_wrap a:hover {
            text-decoration: none;
            color: #fff;
            transform: translateY(-2px);
        }

        .hospital_section {
            padding: 70px 0 80px 0;
        }

        .page_heading {
            text-align: center;
            margin-bottom: 40px;
        }

        .page_heading h2 {
            color: #fff;
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .page_heading p {
            color: rgba(255,255,255,0.88);
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
        }

        .hospital-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px 24px;
            border-radius: 18px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            transition: 0.3s ease;
            height: 100%;
        }

        .hospital-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 32px rgba(0,0,0,0.16);
        }

        .hospital-card h4 {
            font-weight: 800;
            font-size: 28px;
            color: #7a0f1d;
            margin-bottom: 15px;
        }

        .hospital-card p {
            margin-bottom: 8px;
            font-size: 17px;
            color: #4b4b4b;
        }

        .footer_section {
            background: #8c1022;
        }

        .footer_text,
        .footer_menu ul li a,
        .location_text ul li a,
        .copyright_text {
            color: #ffffff !important;
        }

        .social_icon ul li a {
            background: rgba(255,255,255,0.14);
            color: #ffffff;
        }

        .social_icon ul li a:hover {
            background: #ffffff;
            color: #8c1022;
        }

        @media (max-width: 991px) {
            .brand_wrap {
                justify-content: center;
            }

            .login_btn_wrap {
                position: static;
                transform: none;
                margin-top: 15px;
                text-align: center;
            }

            .top_navbar .container {
                text-align: center;
            }
        }

        @media (max-width: 767px) {
            .brand_text {
                font-size: 22px;
            }

            .brand_logo {
                height: 32px;
            }

            .page_heading h2 {
                font-size: 30px;
            }

            .hospital-card h4 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="top_navbar">
        <div class="container position-relative">
            <div class="brand_wrap">
                <img src="{{ asset('landing/images/bloodconnect-logo.png') }}" alt="BloodConnect Logo" class="brand_logo">
                <h1 class="brand_text">BloodConnect</h1>
            </div>

            <div class="login_btn_wrap">
                <a href="/login">Login</a>
            </div>
        </div>
    </div>

    <div class="hospital_section">
        <div class="container">
            <div class="page_heading">
                <h2>Registered Hospitals</h2>
                <p>Explore our partner hospitals and connect faster during urgent blood requests.</p>
            </div>

            <div class="row">
                @forelse($hospitals as $hospital)
                    <div class="col-lg-4 col-md-6 d-flex">
                        <div class="hospital-card w-100">
                            <h4>{{ $hospital->name }}</h4>
                            <p>{{ explode('|', $hospital->location)[0] }}</p>
                            <p>Contact: {{ $hospital->user->phone ?? 'No contact available' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="hospital-card">
                            <h4>No Hospitals Found</h4>
                            <p>There are currently no registered hospitals available.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="footer_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h3 class="footer_text">Useful links</h3>
                    <div class="footer_menu">
                        <ul>
                            <li class="{{ request()->is('') ? 'active' : ''}}">
                                <a href="/"><span class="angle_icon {{ request()->is('') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a>
                            </li>
                            <li class="{{ request()->is('login') ? 'active' : ''}}">
                                <a href="/login"><span class="angle_icon {{ request()->is('login') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Login</a>
                            </li>
                            <li class="{{ request()->is('hospital-list') ? 'active' : ''}}">
                                <a href="/hospital-list"><span class="angle_icon {{ request()->is('hospital-list') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Hospital List</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4">
                    <h3 class="footer_text">Address</h3>
                    <div class="location_text">
                        <ul>
                            <li>
                                <a href="#">
                                    <span class="padding_left_10"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Mandaue City
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="footer_main">
                        <div class="social_icon">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright_section">
        <div class="container">
            <p class="copyright_text">© 2025 BloodConnect. All Rights Reserved.</p>
        </div>
    </div>

    <script src="{{ asset('landing/js/jquery.min.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>