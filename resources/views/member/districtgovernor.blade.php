@extends('layouts.navbar')

@section('content')

<style>
    /* Default Tab Style */
    .nav-tabs .nav-link {
        color: #000;
        background: #f8f9fa;
        border-radius: 5px;
        transition: background 0.3s ease-in-out, color 0.3s ease-in-out;
    }

    /* Active Tab Style */
    .nav-tabs .nav-link.active {
        background: #003366;
        color: #fff !important;
        font-weight: bold;
        border: none;
    }

    /* Hover Effect */
    .nav-tabs .nav-link:hover {
        background: #003366;
        color: #fff;
    }

    /* Mobile View - Tabs Scrollable */
    @media (max-width: 768px) {
        #districtTabList {
            flex-wrap: nowrap;
            overflow-x: auto;
            white-space: nowrap;
            display: flex;
        }
        #districtTabList::-webkit-scrollbar {
            display: none;
        }
    }
</style>

<div class="container mt-4" style="max-width: 1400px !important;">
    <!-- Tabs Navigation -->
    <div class="row mt-2">
        @include('member.tab')
    </div>

    <div>
        <h3>District Governors</h3>

        <!-- District Tabs -->
        <div id="districtTabsWrapper" class="d-flex align-items-center justify-content-center position-relative">
            <button class="btn btn-light position-absolute start-0 shadow-sm left" 
                    onclick="scrollDistrictTabs('left')" 
                    style="z-index: 10; border-radius: 50%; width: 40px; height: 40px; margin-left: 80px;">
                &lt;
            </button>

            <div id="districtTabs" class="position-relative" style="max-width:100%; overflow: hidden;">
                <div class="d-flex overflow-auto" id="districtTabContainer">
                    <ul class="nav nav-tabs flex-nowrap d-inline-flex" id="districtTabList" role="tablist">
                        @foreach($districts as $key => $district)
                            <li class="nav-item">
                                <a class="nav-link {{ $key == 0 ? 'active' : '' }}" 
                                   id="district-{{ $district->id }}-tab" 
                                   data-bs-toggle="tab" 
                                   href="#district-{{ $district->id }}" 
                                   role="tab">
                                    {{ $district->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <button class="btn btn-light position-absolute end-0 shadow-sm right" 
                    onclick="scrollDistrictTabs('right')" 
                    style="z-index: 10; border-radius: 50%; width: 40px; height: 40px; margin-right: 80px;">
                &gt;
            </button>
        </div>
    </div>

    <script>
        function scrollDistrictTabs(direction) {
            let container = document.getElementById("districtTabContainer");
            let scrollAmount = 100;
            if (direction === "left") {
                container.scrollLeft -= scrollAmount;
            } else {
                container.scrollLeft += scrollAmount;
            }
        }
    </script>

    <!-- Members Section -->
    <style>
        /* Main Card Design */
        .governor-card {
            background: linear-gradient(90deg, #00509e, #0072ce);
            border-radius: 15px;
            color: white;
            text-align: center;
            padding: 20px;
            width: 230px;
            height: 250px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease-in-out;
            cursor: pointer; /* ✅ Makes card clickable */
        }

        /* Profile Image */
        .profile-container img {
            width: 140px;
            height: 115px;
            object-fit: fill;
            border-radius: 10px;
        }

        /* Hover Effect */
        .governor-card:hover {
            border: 3.7px solid #ffcc00;
        }

        /* Mobile View - Display 2 Cards Per Row */
        @media (max-width: 768px) {
            .col-lg-3, .col-md-4, .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .left, .right {
                display: none;
            }
        }
    </style>

    <div class="tab-content mt-3 mb-3">
        @foreach($districts as $key => $district)
            <div class="tab-pane {{ $key == 0 ? 'show active' : '' }}" id="district-{{ $district->id }}" role="tabpanel">
                <div class="row">
                    @if(isset($groupedGovernors[$district->id]) && $groupedGovernors[$district->id]->isNotEmpty())
                        @foreach($groupedGovernors[$district->id] as $governor)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex justify-content-center">
                                <!-- ✅ Clickable Governor Card -->
                                <div class="governor-card profile-card"
                                    data-bs-toggle="modal"
                                    data-bs-target="#profileModal"
                                    data-name="{{ $governor->first_name }} {{ $governor->last_name }}"
                                    data-member-id="{{ $governor->member_id }}">

                                    <div class="profile-container">
                                        <img src="{{ $governor->profile_photo ? asset('storage/app/public/' . $governor->profile_photo) : asset('assets/images/default.png') }}"
                                             alt="{{ $governor->first_name }} {{ $governor->last_name }}">
                                    </div>

                                    <div class="governor-info">
                                        <h6>{{ $governor->first_name }} {{ $governor->last_name }}</h6>
                                        <p class="small">{{ $governor->position }}</p>
                                        <p class="mb-1 small"><strong>{{ $governor->member_id }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No members found for this district.</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ✅ Bootstrap Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- ✅ Modal Header with Custom Background -->
            <div class="modal-header text-white" style="background-color: #003366;">
                <h5 class="modal-title" id="profileModalLabel">Profile Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-center">
                <p id="modalText">You need to log in to view <strong id="officerName"></strong>'s profile.</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <a href="{{ route('member.login') }}" class="btn btn-primary px-4" style="background-color: #003366;">Login</a>
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
