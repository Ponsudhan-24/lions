@extends('MasterAdmin.layout')

<style>
    /* Hover effect for the cards */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        border-radius: 10px;
        overflow: hidden;
       
       
    }

    .gradient-card {
        background: linear-gradient(45deg, #4CAF50, rgba(24, 14, 225, 0.3),rgb(27, 27, 175), #FFFFFF);
        background-size: 800% 800%;
        animation: gradientBG 10s ease infinite;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 2rem; /* More padding inside */
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 280px; /* Increased height */   
        border-radius:300px;
    }

    .card-title {
        font-size: 1.5rem; /* Slightly bigger */
        font-weight: bold;
        color: white;
    }

    .card-text {
        font-size: 1.1rem;
        color: white;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    

</style>


@section('content')

<h2 class="text-center fw-bold" style="color:rgb(233, 232, 227); margin-top: 20px;">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Lions Club Logo" width="70" height="70" class="mb-1">
    Welcome to Lions Club Admin!
</h2>

<!-- Cards Section -->
<div class="container mt-5">
    <div class="row text-center">
  <!-- Card 1 -->
<div class="col-md-3 mb-4">
    <div class="card hover-zoom gradient-card">
        <div class="card-body">
            <h5 class="card-title">{{ $memberCount }}</h5>
            <p class="card-text">Total Members Registered</p>
        </div>
    </div>
</div>


        <!-- Card 2 -->
        <div class="col-md-3 mb-4">
            <div class="card hover-zoom gradient-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $chapterCount }}</h5>
                    <p class="card-text">Total Members Club</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-3 mb-4">
            <div class="card hover-zoom gradient-card">
                <div class="card-body">
                    <h5 class="card-title">73</h5>
                    <p class="card-text">Total Members District</p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-3 mb-4">
            <div class="card hover-zoom gradient-card">
                <div class="card-body">
                    <h5 class="card-title">99</h5>
                    <p class="card-text">Total Members Notifications</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

