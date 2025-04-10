@extends('memberlayout.sidebar')
@section('content')

<style>
    .card-container {
        display: flex;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 10px;
        width: 100%;
        max-width: 1200px;
        justify-content: space-between;
    }

    .card {
        width: 230px;
        height: 280px;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
        padding: 20px;
        color: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-size: 400% 400%;
        animation: fadeInUp 0.8s ease forwards, gradientShift 6s ease infinite;
        opacity: 0;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 100%;
        }

        50% {
            background-position: 100% 100%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .card:nth-child(1),
    .card:nth-child(2),
    .card:nth-child(3),
    .card:nth-child(4) {
        background-image: linear-gradient(135deg, #0c52ba, #eacb18, #0c52ba);
    }




    .card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .card:nth-child(2) {
        animation-delay: 0.3s;
    }

    .card:nth-child(3) {
        animation-delay: 0.5s;
    }

    .card:nth-child(4) {
        animation-delay: 0.7s;
    }

    .card .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card .chip {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        /* Ensures the image stays inside rounded corners */
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 21, 158, 0.1);
        /* Optional subtle background */
    }

    .card .chip img {
        width: 60px;
        height: 60px;
        object-fit: fill;
        /* Ensures the image fills the space nicely */
    }


    .card .card-number {
        font-size: 14px;
        font-weight: bold;
        opacity: 0.8;
    }

    .card .card-footer {
        border: 1px solid yellow;
        width: 100%;
        background: rgba(21, 40, 250, 0.2);
        backdrop-filter: blur(12px);
        border-radius: 10px;
        font-size: 12px;
        margin-top: 50px;
    }

    .card .balance {
        font-size: 22px;
        font-weight: bold;
    }

    .card .date {
        font-size: 14px;
        opacity: 0.9;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }


    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background: none;
        border-bottom: none;
    }


    @media screen and (max-width: 768px)
    {
        .card{
        margin-left:35px;
    }
    }


</style>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <div class="chip mx-auto">
                        <img src="{{asset('assets/images/logo.png')}}" alt="chip" />
                    </div>
                </div>
                <div class="card-footer">
                    <h6>Total Members</h6>
                    <p class="balance">{{ DB::table('add_members')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <div class="chip mx-auto">
                        <img src="{{asset('assets/images/logo.png')}}" alt="chip" />
                    </div>
                </div>
                <div class="card-footer">
                    <h6>Total Clubs</h6>
                    <p class="balance">{{ DB::table('chapters')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <div class="chip mx-auto">
                        <img src="{{asset('assets/images/logo.png')}}" alt="chip" />
                    </div>
                </div>
                <div class="card-footer">
                    <h6>District</h6>
                    <p class="balance">78</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card text-center">
                <div class="card-header">
                    <div class="chip mx-auto">
                        <img src="{{asset('assets/images/logo.png')}}" alt="chip" />
                    </div>
                </div>
                <div class="card-footer">
                    <h6>Notifications</h6>
                    <p class="balance">78</p>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection