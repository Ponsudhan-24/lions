<!doctype html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/x-icon">
    <title>Member Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/loginform/css/style.css') }}">
</head>
<!-- Add CSS for Blur Effect and Custom Button -->
<style>
    body {
        overflow-y: hidden;
    }


    /* Animated Glowing Border */
    @keyframes glowingBorder {
        0% {
            box-shadow: 0 0 5px #0033cc, 0 0 10px #ffcc00;
        }

        50% {
            box-shadow: 0 0 20px #ffcc00, 0 0 30px #0033cc;
        }

        100% {
            box-shadow: 0 0 5px #0033cc, 0 0 10px #ffcc00;
        }
    }

    .login-card {
        position: relative;
        background: rgba(51, 51, 51, 0.85);
        /* Dark semi-transparent */
        backdrop-filter: blur(10px);
        /* Glassmorphism effect */
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        color: white;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.7);
        overflow: hidden;
        animation: glowingBorder 2.5s infinite alternate ease-in-out;
    }

    /* Gradient Animated Border */
    .login-card::before {
        content: "";
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: linear-gradient(90deg, #0033cc, #ffcc00, #0033cc);
        z-index: -1;
        border-radius: 12px;
        animation: borderMove 3s linear infinite;
    }

    /* Inner Layer to Keep Content Readable */
    .login-card::after {
        content: "";
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        background: rgba(51, 51, 51, 0.95);
        border-radius: 8px;
        z-index: 0;
    }

    /* Button Customization */
    .custom-btn {
        background-color: #0033cc;
        /* Blue */
        border: 2px solid #ffcc00;
        /* Yellow */
        width: 50%;
        color: white;
        border-radius: 13px;
        transition: all 0.3s ease-in-out;
        text-transform: capitalize;
    }

    .custom-btn:hover {
        color: black;
        border-radius: 13px;
        background-color: #ffcc00;
        /* Yellow */
        border-color: #0033cc;
    }


    /* Ensure content is above the overlay */
    .login-card .card-body {
        position: relative;
        z-index: 1;
    }



    /* Input Field Styling */
    .custom-input {
        background: rgba(255, 255, 255, 0.15);
        border: 2px solid transparent;
        color: white;
        height: 40px;
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .custom-input:focus {
        border-color: #ffcc00;
        background: rgba(255, 255, 255, 0.2);
    }

    /* Password Toggle Icon */
    .field-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #ffcc00;
    }

    /* Heading Styling */
    .heading-section {
        font-weight: bold;
        font-size: 22px;
        letter-spacing: 1px;
    }


    /* Mobile View Adjustments */
    @media (max-width: 768px) {

        body {
            background-size: cover !important;
            background-position: center !important;
            background-repeat: no-repeat !important;
            height: 100vh;
        }

        .container {
            margin-top: 100px !important;
            padding: 0 15px;
        }

        .login-card {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .custom-btn {
            width: 100%;
            font-size: 16px;
            padding: 10px;
        }

        .custom-input {
            height: 35px;
            font-size: 14px;
            padding: 8px;
        }

        .heading-section {
            font-size: 20px;
        }

        .field-icon {
            right: 10px;
        }

        .checkbox-wrap {
            font-size: 14px;
        }
    }
</style>


<style>
    /* Sticky Header */
    .header {
        position: sticky;
        top: 0;
        background-color: #003366;
        z-index: 1000;
        padding: 10px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        height: 67px;
    }

    /* Sticky Navigation Menu */
    .nav-container {
        position: sticky;
        top: 260px;
        background-color: #003366;
        z-index: 998;
        padding: 2px;
    }

    .header img {
        max-width: 100px;
        margin-right: 0px;
        transition: transform 0.3s ease-in-out;
    }

    .mainlogo img {
        margin-left: 20px;
        width: 50px !important;
        height: 50px !important;
    }

    .zoom-image1{
        transform: translateX(-265px);
    }


    
    .zoom-image{
        transform: translateX(265px);
    }

    .zoom-image:hover {
        transform: scale(3.2) translateY(31%) translateX(30px);
        transform-origin: center;
    }

    .zoom-image1:hover {
        transform: scale(3.2) translateY(135%) translateX(-100px);
        transform-origin: center;
    }

    .mobilescreen,
    #mobilescreen {
        display: none;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    @media (max-width: 768px) {

        .mobile,
        #mobile {
            display: none;
        }


        .mobilescreen,
        #mobilescreen {
            display: block;
        }

        .stickyhead {
            position: sticky;
            top: 0;
            /* Adjusted to follow after the navigation bar */
            background-color: white;
            z-index: 997;
            padding: 10px;

            text-align: center;

        }

        .zoom-image:hover {
            transform: scale(2.2) translateY(7%) translateX(30px);
            transform-origin: center;
        }

        .zoom-image1:hover {
            transform: scale(2.2) translateY(7%) translateX(-20px);
            transform-origin: center;
        }
    }
</style>

<body class="img js-fullheight" style="background-image: url('{{ asset('assets/images/Member Login.png') }}');">

<div class="header mobile p-3 col-lg-12 d-flex align-items-center justify-content-between" style="gap: 10px;">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="zoom-image" loading="lazy" style="height:100px; width:100px;" />

    <h1 class="m-0 text-center flex-grow-1 text-light" style="font-size:35px; white-space: nowrap;">Lions International District 3241 E</h1>

    <div class="mainlogo">
        <img src="{{ asset('assets/images/lo4.png') }}" alt="Logo" class="zoom-image1" loading="lazy" style="height:100px; width:100px;" />
    </div>
</div>


    <section class="ftco-section d-flex justify-content-end">
        <div class="container" style="margin-top: 50px;">
            <div class="row justify-content-end">
                <div class="col-md-6 col-lg-4">
                    <div class="login-card">
                        <div class="card-body">
                            <h5 class="heading-section text-center">Member Login</h5>
                            <form action="{{ route('member.login') }}" method="POST" class="signin-form">
                                @csrf

                                <!-- Member ID Field -->
                                <div class="form-group">
                                    <input type="text" name="member_id" class="form-control custom-input" placeholder="Member ID" required>
                                </div>

                                <!-- Password Field -->
                                <div class="form-group position-relative">
                                    <input id="password-field" type="password" name="password" class="form-control custom-input" placeholder="Password" required>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>

                                <!-- Sign In Button -->
                                <div class="form-group text-center">
                                    <button type="submit" class="btn custom-btn">Login</button>
                                </div>

                                <!-- Remember Me Checkbox -->
                                <div class="form-group d-md-flex">
                                    <div class="w-60">
                                        <label class="checkbox-wrap checkbox-primary">Remember Me
                                            <input type="checkbox" name="remember">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <script src="{{ asset('assets/loginform/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/popper.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/loginform/js/main.js') }}"></script>
</body>

</html>