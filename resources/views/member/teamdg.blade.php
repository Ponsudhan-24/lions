@extends('layouts.navbar')

@section('content')

<style>
    .col-lg-3 {
        flex: 0 0 auto;
        width: 18%;
    }   

    .custom-card {
        border-radius: 12px;
        background:#020061;
        width: 200px;
        margin: auto;
        height: 230px;
        transition: border 0.3s ease-in-out;
        cursor: pointer; /* ✅ Makes the card clickable */
    }

    .custom-card:hover {
        border: 3.7px solid #ffcc00;
    }

    .small {
        font-size:12px;
    }

    .text-light {
        font-size: 13px;
    }

    /* Mobile View */
    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .custom-card {
            width: 100% !important;
            height: 235px !important;
            padding: 15px;
        }
        .custom-card img {
            width: 120px !important;
            height: 100px !important;
        }
        .small, .text-light {
            font-size: 12px;
        }
    }
</style>

<div class="container mt-4" style="max-width: 1400px !important;">
    @include('member.tab')

    <div>
        <h3>DG Team</h3>

        <div class="row mb-4">
            @foreach($dgTeamMembers as $member)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center shadow-sm p-3 custom-card profile-card"
                        data-bs-toggle="modal"
                        data-bs-target="#profileModal"
                        data-name="{{ $member->first_name }} {{ $member->last_name }}"
                        data-member-id="{{ $member->member_id }}"
                        style="border-radius: 12px; background: #00509e; width:200px; height:250px; margin: auto;">
                        
                        <!-- Image -->
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                alt="{{ $member->first_name }}"
                                class="border border-white shadow-sm"
                                style="width:140px; height:115px; object-fit:fill; border-radius:10px;">
                        </div>

                        <!-- Info -->
                        <div class="p-3">
                            <h6 class="fw-bold text-light mb-1">{{ $member->first_name }} {{ $member->last_name }}</h6>
                            <p class="mb-1 text-light small">{{ $member->position }}</p>
                            <p class="mb-1 text-light small"><strong>{{ $member->member_id }}</strong></p>
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
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #003366;">
                <h5 class="modal-title" id="profileModalLabel" style="display: inline-block; text-align: center; width: 100%;" >Profile Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <p id="modalText">You need to log in to view <strong id="officerName"></strong>'s profile.</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <a href="{{ route('member.login') }}" class="btn btn-primary px-4"  style="background-color: #003366;">Login</a>
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- ✅ JavaScript to Handle Modal Data -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".profile-card").forEach(card => {
        card.addEventListener("click", function() {
            let officerName = this.getAttribute("data-name");
            document.getElementById("officerName").innerText = officerName;
        });
    });
});
</script>

@endsection
