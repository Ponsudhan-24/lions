@extends('layouts.navbar')

@section('content')

<style>
    .col-lg-3 {
        flex: 0 0 auto;
        width: 18%;
    }   

    .small {
        font-size: 13.5px;
    }

    /* Card Styling */
    .chairperson-card {
        background: #00509e; /* Dark Blue Background */
        border-radius: 15px;
        color: white;
        text-align: center;
        padding: 20px;
        width: 230px;
        height: 250px;
        box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.2);
        transition: 0.3s ease-in-out;
        border: 3px solid transparent;
        cursor: pointer; /* ✅ Makes the card clickable */
    }

    /* Profile Image */
    .profile-container img {
        width: 140px;
        height: 115px;
        object-fit: fill;
        border-radius: 10px;
    }

    /* Text Styling */
    .chairperson-info h6 {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .chairperson-info p {
        margin: 0;
        font-size: 0.85rem;
    }

    /* Hover Effect */
    .chairperson-card:hover {
        border: 3.7px solid #ffcc00; /* Yellow border on hover */
    }

    /* Mobile View Adjustments (Two Cards Per Row) */
    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 54%; /* Two cards per row */
            max-width: 52%;
        }
        .chairperson-card {
            width: 165px;
            height: 220px;
            padding: 15px;
        }
        .profile-container img {
            width: 110px !important;
            height: 90px !important;
        }
    }
</style>

<div class="container mt-4" style="max-width: 1400px !important;">
    <!-- Tabs Navigation -->
    <div class="row mt-2">
        <div class="col-12">
            @include('member.tab')
        </div>
    </div> 

    <div class="row">
        <h3>District Chairpersons</h3>
        <div class="row mb-4">
            @foreach($districtChairpersons as $chairperson)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex justify-content-center">
                <!-- ✅ Clickable Chairperson Card -->
                <div class="chairperson-card profile-card"
                    data-bs-toggle="modal"
                    data-bs-target="#profileModal"
                    data-name="{{ $chairperson->first_name }} {{ $chairperson->last_name }}"
                    data-member-id="{{ $chairperson->member_id }}">

                    <!-- Profile Image Box -->
                    <div class="profile-container">
                        <img src="{{ $chairperson->profile_photo ? asset('storage/app/public/' . $chairperson->profile_photo) : asset('assets/images/default.png') }}"
                            alt="{{ $chairperson->first_name }} {{ $chairperson->last_name }}">
                    </div>

                    <!-- Info -->
                    <div class="chairperson-info">
                        <h6>{{ $chairperson->first_name }} {{ $chairperson->last_name }}</h6>
                        <p class="mb-1 small">{{ $chairperson->position }}</p>
                        <p class="mb-1 small"><strong>{{ $chairperson->member_id }}</strong></p>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ✅ Bootstrap Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- ✅ Modal Header with Custom Background -->
            <div class="modal-header text-white" style="background-color: #003366;">
                <h5 class="modal-title" id="profileModalLabel" style="display: inline-block; text-align: center; width: 100%;">Profile Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <p id="modalText">You need to log in to view <strong id="officerName"></strong>'s profile.</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <a href="{{ route('member.login') }}" class="btn btn-primary px-4"   style="background-color: #003366;">Login</a>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript to Update Modal Dynamically -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.profile-card').forEach(card => {
            card.addEventListener('click', function() {
                let name = this.getAttribute('data-name');
                document.getElementById('officerName').innerText = name;
            });
        });
    });
</script>

@endsection
