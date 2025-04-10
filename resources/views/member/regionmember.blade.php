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
</style>

<div class="container mt-4" style="max-width: 1400px !important;">
    <div class="row">
        <!-- Tabs Navigation -->
        @include('member.tab')
    </div>
    <h3>Region Governors</h3>

    <!-- Region Tabs -->
    <div class="tab-container">
        <ul class="nav nav-tabs flex-nowrap" id="regionTabList">
            @foreach($regions as $regionName => $members)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#{{ Str::slug($regionName) }}">{{ $regionName }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <style>
        /* Member Card */
        .member-card {
            background: #00509E;
            border-radius: 15px;
            color: white;
            text-align: center;
            padding: 20px;
            width: 230px;
            height: 240px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            cursor: pointer; /* ✅ Makes card clickable */
        }

        /* Profile Image */
        .profile-box img {
            width: 140px;
            height: 115px;
            object-fit: fill;
            border-radius: 10px;
        }

        /* Hover Effect */
        .member-card:hover {
            border: 3.7px solid #ffcc00;
        }

        /* Mobile View: Two Cards Per Row */
        @media (max-width: 767px) {
            .col-sm-6 {
                flex: 0 0 54%;
                max-width: 55%;
            }
            .profile-box img {
                width: 115px;
                height: 100px;
            }
        }

        /* Responsive Tabs for Mobile */
        @media (max-width: 767px) {
            #regionTabList {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
            #regionTabList .nav-item {
                flex: 1 1 auto;
                text-align: center;
            }
            #regionTabList .nav-link {
                min-width: 120px;
            }
        }
    </style>

    <div class="tab-content mt-3 mb-3">
        @foreach($regions as $regionName => $members)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($regionName) }}">
                <div class="row">
                    @forelse($members as $member)
                        <div class="col-lg-2 col-md-3 col-sm-6 mb-4 d-flex justify-content-center">
                            <!-- ✅ Clickable Member Card -->
                            <div class="member-card profile-card"
                                data-bs-toggle="modal"
                                data-bs-target="#profileModal"
                                data-name="{{ $member->first_name }} {{ $member->last_name }}"
                                data-member-id="{{ $member->member_id }}">

                                <!-- Profile Image -->
                                <div class="profile-box">
                                    <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                        alt="{{ $member->first_name }} {{ $member->last_name }}">
                                </div>

                                <!-- Member Info -->
                                <div class="member-info">
                                    <h6>{{ $member->first_name }} {{ $member->last_name }}</h6>
                                    <p class="mb-1 small">{{ $member->position }}</p>
                                    <p class="mb-1 small"><strong>{{ $member->member_id }}</strong></p>
                                </div>

                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No members found for this region.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ✅ Bootstrap Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- ✅ Modal Header -->
            <div class="modal-header text-white" style="background-color: #003366;">
            <h5 class="modal-title" id="profileModalLabel"  style="display: inline-block; text-align: center; width: 100%;">Profile Access</h5>
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

<!-- ✅ JavaScript to Update Modal Content Dynamically -->
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
