@extends('layouts.navbar')

@section('content')

<style>
    .col-lg-3 {
        flex: 0 0 auto;
        width: 17%;
    }   

    .custom-card {
        border-radius: 12px;
        background: #00509e;
        width: 200px;
        margin: auto;
        height: 230px;
        transition: border 0.3s ease-in-out;
    }

    .custom-card:hover {
        border: 4px solid #ffcc00;
    }

    .small {
        font-size: 13px;
    }

    @media (max-width: 576px) {
        .col-sm-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
        .custom-card {
            width: 90%;
            height: auto;
            padding: 15px;
        }
        .custom-card img {
            width: 100px !important;
            height: 90px !important;
        }
        .small {
            font-size: 11px;
        }
        .footer {
            position: fixed;
        }
    }
</style>

<div class="container mt-4" style="max-width: 1400px !important;">
    @include('member.tab')

    <div>
        <h3>International Officers</h3>

        <div class="row mb-5">
            @foreach($internationalOfficers as $officer)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                    <!-- 🔥 Clickable Card -->
                    <div class="card text-center p-3 shadow-sm custom-card profile-card"  
                        data-bs-toggle="modal"
                        data-bs-target="#profileModal"
                        data-name="{{ $officer->first_name }} {{ $officer->last_name }}"
                        data-member-id="{{ $officer->member_id }}"
                        style="cursor: pointer;">
                        
                        <!-- Image -->
                        <div class="d-flex justify-content-center">
                            <img src="{{ $officer->profile_photo ? asset('storage/app/public/' . $officer->profile_photo) : asset('assets/images/default.png') }}"
                                alt="{{ $officer->first_name }}"
                                class="border border-white shadow"
                                style="width:140px; height:115px; object-fit:fill; border-radius:10px;">
                        </div>

                        <!-- Info -->
                        <div class="mt-2 text-white">
                            <h6 class="fw-bold">{{ $officer->first_name }} {{ $officer->last_name }}</h6>
                            <p class="mb-1 small">{{ $officer->position }}</p>
                            <p class="mb-1 small">
                                <i class="fas fa-phone-alt"></i> {{ $officer->member_id }}
                            </p>
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

<!-- ✅ JavaScript Fix: Remove Manual Modal Initialization -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".profile-card").forEach(card => {
        card.addEventListener("click", function() {
            let officerName = this.getAttribute("data-name");
            document.getElementById("officerName").innerText = officerName;
        });
    });

    // ✅ Ensure the modal closes when clicking "Cancel"
    document.querySelector('.btn-secondary[data-bs-dismiss="modal"]').addEventListener('click', function() {
        let profileModal = document.getElementById('profileModal');
        let modalInstance = bootstrap.Modal.getInstance(profileModal);
        if (modalInstance) {
            modalInstance.hide();
        }
    });
});
</script>





<!-- 🔥 Improved CSS for a Stylish Modal -->
<style>
    /* Custom Card Hover Effect */
    .custom-card {
        border-radius: 12px;
        background: #00509e;
        width: 200px;
        margin: auto;
        height: 230px;
        transition: transform 0.2s ease-in-out, border 0.3s ease-in-out;
    }

    .custom-card:hover {
        transform: scale(1.05);
        border: 3px solid #ffcc00;
    }

    /* Modal Enhancements */
    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .modal-body p {
        font-size: 16px;
        color: #333;
    }
</style>


<!-- ✅ JavaScript to Update Modal Dynamically -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileImages = document.querySelectorAll('.profile-img');
        profileImages.forEach(img => {
            img.addEventListener('click', function() {
                let name = this.getAttribute('data-name');
                let memberId = this.getAttribute('data-member-id');
                document.getElementById('modalText').innerText = `You need to log in to view ${name}'s profile (Member ID: ${memberId}).`;
            });
        });
    });
</script>

@endsection
