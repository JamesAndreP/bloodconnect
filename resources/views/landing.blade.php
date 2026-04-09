<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>BloodConnect</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">

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
            background: #fff8f8;
            margin: 0;
            padding: 0;
         }

         .header_section {
            background: linear-gradient(135deg, #7a0f1d 0%, #b3172b 45%, #c92b3c 100%);
            position: relative;
            overflow: hidden;
         }

         .header_section::before {
            content: "";
            position: absolute;
            top: -110px;
            right: -90px;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            z-index: 1;
         }

         .header_section::after {
            content: "";
            position: absolute;
            bottom: -130px;
            left: -100px;
            width: 260px;
            height: 260px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            z-index: 1;
         }

         .navbar {
            background: transparent !important;
            padding-top: 20px;
            padding-bottom: 10px;
            position: relative;
            z-index: 9999;
         }

         .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 30px;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
         }

         .navbar-brand span {
            color: #fff !important;
         }

         .navbar-logo {
            height: 40px;
            width: auto;
            margin-right: 10px;
            object-fit: contain;
         }

         .navbar-nav .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-size: 15px;
            margin-left: 12px;
         }

         .navbar-nav .nav-link:hover {
            color: #ffffff !important;
         }

         .top_action_buttons {
            position: absolute;
            top: 30px;
            right: 15px;
            display: flex;
            gap: 12px;
            z-index: 10000;
         }

         .top_btn_login,
         .top_btn_register {
            display: inline-block;
            font-size: 14px;
            padding: 12px 26px;
            border-radius: 10px;
            text-transform: uppercase;
            font-weight: 700;
            text-decoration: none !important;
            position: relative;
            z-index: 10001;
            pointer-events: auto;
            transition: 0.3s ease;
         }

         .top_btn_login:hover,
         .top_btn_register:hover,
         .hero_btn_primary:hover,
         .hero_btn_secondary:hover,
         .cta_btn:hover {
            transform: translateY(-2px);
            text-decoration: none !important;
         }

         .top_btn_login {
            background: #ff1f2d;
            color: #fff;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
         }

         .top_btn_register {
            background: #ffffff;
            color: #7a0f1d;
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
         }

         .banner_section {
            padding: 80px 0 100px 0;
            position: relative;
            z-index: 2;
         }

         .carousel,
         .carousel-inner,
         .carousel-item {
            position: relative;
            z-index: 2;
         }

         .hero_glass {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 55px 45px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25);
            border: 1px solid rgba(255,255,255,0.18);
         }

         .banner_taital {
            font-size: 82px;
            line-height: 92px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 22px;
            text-align: center;
         }

         .banner_subtext {
            color: rgba(255,255,255,0.92);
            font-size: 24px;
            line-height: 38px;
            max-width: 780px;
            margin: 0 auto 35px auto;
            text-align: center;
         }

         .hero_buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            margin-top: 10px;
            justify-content: center;
         }

         .hero_btn_primary,
         .hero_btn_secondary {
            display: inline-block;
            padding: 16px 34px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 21px;
            text-decoration: none !important;
            transition: 0.3s ease;
         }

         .hero_btn_primary {
            background: #ff1f2d;
            color: #fff;
            box-shadow: 0 10px 24px rgba(0,0,0,0.12);
         }

         .hero_btn_secondary {
            background: #ffffff;
            color: #7a0f1d;
            box-shadow: 0 10px 24px rgba(0,0,0,0.12);
         }

         .carousel-control-prev,
         .carousel-control-next {
            width: 62px;
            height: 62px;
            background: #ffffff;
            border-radius: 50%;
            top: 45%;
            opacity: 1;
            z-index: 5;
            box-shadow: 0 8px 18px rgba(0,0,0,0.12);
         }

         .carousel-control-prev {
            left: 20px;
         }

         .carousel-control-next {
            right: 20px;
         }

         .carousel-control-prev i,
         .carousel-control-next i {
            color: #7a0f1d;
            font-size: 32px;
         }

         .about_section {
            background: #fff7f7;
            padding-top: 90px;
            padding-bottom: 90px;
         }

         .section_heading {
            text-align: center;
            margin-bottom: 50px;
         }

         .section_heading h2 {
            font-size: 46px;
            font-weight: 700;
            color: #8c1022;
            margin-bottom: 15px;
         }

         .section_heading p {
            font-size: 20px;
            color: #8a6a6f;
            margin: 0 auto;
            max-width: 850px;
         }

         .about_box {
            background: #ffffff;
            border-radius: 18px;
            padding: 35px 28px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(122, 15, 29, 0.08);
            height: 100%;
            transition: 0.3s ease;
         }

         .about_box:hover {
            transform: translateY(-5px);
         }

         .icon_circle {
            width: 95px;
            height: 95px;
            border-radius: 50%;
            background: #fdecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
         }

         .icon_circle i {
            font-size: 40px;
            color: #b02a37;
         }

         .faster_text {
            font-size: 30px;
            line-height: 38px;
            color: #8c1022;
            font-weight: 700;
            margin-bottom: 15px;
         }

         .lorem_text {
            font-size: 18px;
            line-height: 32px;
            color: #6f5a5d;
            margin: 0;
         }

         .how_it_works_section {
            background: #ffffff;
            padding: 90px 0;
         }

         .step_box {
            text-align: center;
            padding: 25px 20px;
         }

         .step_number {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px auto;
            border-radius: 50%;
            background: #ed1c24;
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
         }

         .step_title {
            font-size: 28px;
            font-weight: 700;
            color: #8c1022;
            margin-bottom: 10px;
         }

         .step_desc {
            font-size: 18px;
            line-height: 30px;
            color: #6f5a5d;
         }

         .cta_section {
            background: linear-gradient(135deg, #7a0f1d 0%, #b3172b 45%, #c92b3c 100%);
            padding: 70px 0;
            text-align: center;
         }

         .cta_title {
            color: #fff;
            font-size: 46px;
            font-weight: 700;
            margin-bottom: 15px;
         }

         .cta_text {
            color: rgba(255,255,255,0.9);
            font-size: 20px;
            margin-bottom: 30px;
         }

         .cta_btn {
            display: inline-block;
            padding: 16px 35px;
            border-radius: 12px;
            background: #ffffff;
            color: #8c1022;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none !important;
            transition: 0.3s ease;
         }

         .footer_section {
            background: #8c1022;
         }

         .footer_text,
         .footer_menu ul li a,
         .location_text ul li a,
         .dummy_text,
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
            .top_action_buttons {
               position: static;
               justify-content: center;
               margin-top: 10px;
               margin-bottom: 10px;
            }

            .banner_taital {
               font-size: 54px;
               line-height: 64px;
            }

            .banner_subtext {
               font-size: 18px;
               line-height: 30px;
            }

            .section_heading h2,
            .cta_title {
               font-size: 34px;
            }

            .hero_glass {
               padding: 35px 25px;
            }
         }

         @media (max-width: 767px) {
            .navbar-brand {
               font-size: 24px;
            }

            .navbar-logo {
               height: 34px;
            }

            .banner_taital {
               font-size: 42px;
               line-height: 52px;
            }

            .banner_subtext {
               font-size: 17px;
               line-height: 28px;
            }

            .hero_btn_primary,
            .hero_btn_secondary {
               width: 100%;
               text-align: center;
            }

            .carousel-control-prev,
            .carousel-control-next {
               display: none;
            }
            

            .hero_glass {
               padding: 28px 18px;
            }
         }
      </style>
   </head>
   <body>
      <div class="header_section">
         <div class="container" style="position: relative; z-index: 10;">
            <nav class="navbar navbar-expand-lg navbar-light">
               <a class="navbar-brand" href="/">
                  <img src="{{ asset('landing/images/bloodconnect-logo.png') }}" alt="BloodConnect Logo" class="navbar-logo">
                  <span>BloodConnect</span>
               </a>

               <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
               </button>

               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-auto">
                     <li class="nav-item active">
                        <a class="nav-link" href="/">Home</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="/hospital-list">Hospitals</a>
                     </li>
                  </ul>
               </div>
            </nav>

            <div class="top_action_buttons">
               <a href="/login" class="top_btn_login">Login</a>
               <a href="/register" class="top_btn_register">Register</a>
            </div>
         </div>

         <div class="banner_section">
            <div class="banner_static">
               
                  
                     <div class="container">
                        <div class="row justify-content-center">
                           <div class="col-md-10 col-lg-9">
                              <div class="hero_glass">
                                 <h1 class="banner_taital">Connecting Donors,<br>Saving Lives</h1>
                                 <p class="banner_subtext">
                                    BloodConnect helps hospitals, donors, and patients connect faster during urgent blood needs through a smart and reliable platform.
                                 </p>

                                 <div class="hero_buttons">
                                    <a href="/hospital-list" class="hero_btn_primary">Find a Hospital</a>
                                    <a href="/register" class="hero_btn_secondary">Register as Donor</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

               
               
              
            </div>
         </div>
      </div>

      <div class="about_section">
         <div class="container">
            <div class="section_heading">
               <h2>Why Choose BloodConnect?</h2>
               <p>
                  A smarter and faster way to connect blood donors, hospitals, and patients in times of urgent need.
               </p>
            </div>

            <div class="row">
               <div class="col-md-4 mb-4">
                  <div class="about_box">
                     <div class="icon_circle">
                        <i class="fa fa-bolt"></i>
                     </div>
                     <h3 class="faster_text">Fast Matching</h3>
                     <p class="lorem_text">
                        AI-powered matching helps connect the right donor to urgent blood requests quickly and efficiently.
                     </p>
                  </div>
               </div>

               <div class="col-md-4 mb-4">
                  <div class="about_box">
                     <div class="icon_circle">
                        <i class="fa fa-hospital-o"></i>
                     </div>
                     <h3 class="faster_text">Verified Hospitals</h3>
                     <p class="lorem_text">
                        Trusted hospital partners can securely post blood requests and manage donor communication.
                     </p>
                  </div>
               </div>

               <div class="col-md-4 mb-4">
                  <div class="about_box">
                     <div class="icon_circle">
                        <i class="fa fa-bell"></i>
                     </div>
                     <h3 class="faster_text">Emergency Alerts</h3>
                     <p class="lorem_text">
                        Real-time notifications help donors respond immediately when patients urgently need blood.
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="how_it_works_section">
         <div class="container">
            <div class="section_heading">
               <h2>How It Works</h2>
               <p>
                  A simple process designed to save time and help save lives.
               </p>
            </div>

            <div class="row">
               <div class="col-md-3 col-sm-6 mb-4">
                  <div class="step_box">
                     <div class="step_number">1</div>
                     <h4 class="step_title">Register</h4>
                     <p class="step_desc">Create an account as a donor or hospital partner.</p>
                  </div>
               </div>

               <div class="col-md-3 col-sm-6 mb-4">
                  <div class="step_box">
                     <div class="step_number">2</div>
                     <h4 class="step_title">Submit Request</h4>
                     <p class="step_desc">Hospitals post blood needs for patients in urgent situations.</p>
                  </div>
               </div>

               <div class="col-md-3 col-sm-6 mb-4">
                  <div class="step_box">
                     <div class="step_number">3</div>
                     <h4 class="step_title">Get Matched</h4>
                     <p class="step_desc">The system helps match qualified donors with the request.</p>
                  </div>
               </div>

               <div class="col-md-3 col-sm-6 mb-4">
                  <div class="step_box">
                     <div class="step_number">4</div>
                     <h4 class="step_title">Save Lives</h4>
                     <p class="step_desc">Donors respond faster and patients receive help on time.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="cta_section">
         <div class="container">
            <h2 class="cta_title">Be a part of saving lives today</h2>
            <p class="cta_text">
               Join BloodConnect and help make blood donation faster, smarter, and more accessible.
            </p>
            <a href="/register" class="cta_btn">Get Started</a>
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
                           <a href="/"><span class="angle_icon {{ request()->is('/') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Home</a>
                        </li>
                        <li class="{{ request()->is('login') ? 'active' : ''}}">
                           <a href="/login"><span class="angle_icon {{ request()->is('login') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Login</a>
                        </li>
                        <li class="{{ request()->is('register') ? 'active' : ''}}">
                           <a href="/register"><span class="angle_icon {{ request()->is('register') ? 'active' : ''}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></span> Register</a>
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
      <script src="{{ asset('landing/js/popper.min.js') }}"></script>
      <script src="{{ asset('landing/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('landing/js/jquery-3.0.0.min.js') }}"></script>
      <script src="{{ asset('landing/js/plugin.js') }}"></script>
      <script src="{{ asset('landing/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script src="{{ asset('landing/js/custom.js') }}"></script>
   </body>
</html>