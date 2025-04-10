@extends('memberlayout.sidebar')

@section('content')

<style>
    .member-details-container {
        position: fixed;
        top: 0;
        right: 0;
        width: 400px;
        height: 100%;
        background-color: white;
        box-shadow: -2px 0 8px rgba(0,0,0,0.2);
        z-index: 9999;
        overflow-y: auto;
        display: none;
        transition: all 0.3s ease;
        padding: 20px;
        margin-top: 100px;
        border-radius: 24px;
    }

    .member-details-content {
        padding: 10px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        background: transparent;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .tab-btn {
        margin: 0 5px;
        padding: 5px 10px;
        cursor: pointer;
        background: #f0f0f0;
        border: none;
        border-radius: 3px;
        font-size: 13px;
    }

    .tab-btn.active {
        background: #0f0b8c;
        color: white;
    }

    .tab-pane {
        display: none;
        margin-top: 15px;
    }

    .tab-pane.active {
        display: block;
    }

    .main-content {
        transition: margin-left 0.3s ease;
    }



    .member-card-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
    transition: grid-template-columns 0.3s ease;
}

.member-card {
    max-width: 160px;
    width: 100%;
    margin: 0 auto;
}


/* When sidebar (memberDetailsContainer) is active */
.member-card-grid.sidebar-active {
    grid-template-columns: repeat(4, minmax(160px, 0fr));
}




/* Card styling */
.member-card {
    transition: all 0.3s ease;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .member-card-grid {
        grid-template-columns: repeat(2, 1fr) !important; /* Always 2 per row on mobile */
        margin-left: -13px;
    }

    /* Even if sidebar is active, override to 2 columns */
    .member-card-grid.sidebar-active {
        grid-template-columns: repeat(2, 1fr) !important;
    }

    .member-details-container {
        width: 100%;
        border-radius: 0;
        margin-top: 0;
    }

    .main-content {
        margin-left: 0 !important;
    }

    .member-card {
        width: 100% !important;
    }
}



/* Default */
.search-box {
    width: 50%;
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
    transition: margin-left 0.3s ease;
}


.custom-input {
    border-radius: 5px;
    font-size: 12px;
    padding: 5px 30px 5px 10px; /* extra right padding for X icon */
    flex: 1;
    position: relative;
}

.custom-btn {
    background: #0f0b8c;
    color: white;
    border-radius: 5px;
    font-size: 12px;
    padding: 5px 10px;
    white-space: nowrap;
}

.custom-btn:hover {
    background: #0f0b8c;
    color: white;
}


/* ❌ Clear Button inside input */
.clear-btn {
    position: absolute;
    right: 90px; /* Adjust depending on button size */
    top: 50%;
    transform: translateY(-50%);
    font-size: 16px;
    color: #aaa;
    text-decoration: none;
    cursor: pointer;
    z-index: 10;
}

.clear-btn:hover {
    color: #000;
}

/* Base font size for all screen sizes */
.custom-input::placeholder {
    font-size: 9px; /* or any size you prefer */
    color: #888; /* optional: change color too */
}


.main-content {
    transition: margin-left 0.3s ease;
    width: 100%;
    max-width: 1400px;
    margin: auto;
}

@media (max-width: 768px) {
    .main-content {
        padding: 0 10px;
    }
}

@media (min-width: 1400px) {
    .main-content {
        max-width: 1400px;
    }
}

/* Default positioning */
.search-grid-wrapper {
  
  margin-left:270px;
  transition: all 0.3s ease;
}

/* When sidebar is active, push search to right */
.search-grid-wrapper.sidebar-active {
  margin-left:55px;
  width: 70%;
}
@media (max-width: 768px) {
    .search-grid-wrapper.sidebar-active {
        margin-left: 0 !important;
        width: 528px;
    }
}


@media (max-width: 768px) {
  .search-grid-wrapper {
   width: 528px;
    margin-left: 0 !important;
  }
}

@media (max-width: 768px) {
    .pagination {
        flex-wrap: wrap;
        justify-content: center !important;
    }

    .pagination .page-item {
        margin: 2px;
    }

    .pagination .page-link {
        padding: 6px 10px;
        font-size: 14px;
    }
}
.member-lounge-heading {
    font-weight: bold;
    color: white;
    font-size: 2rem; /* default desktop size */
    white-space: nowrap; /* keep text in one line */
}

@media (max-width: 768px) {
    .member-lounge-heading {
        font-size: 1.3rem; /* smaller size for mobile */
        text-align: center;
    }
}

</style>

<!-- Main Content Wrapper -->
<div class="d-flex justify-content-center align-items-start mt-4 px-2" style="overflow-x: hidden; width: 100%;">
<div class="main-content w-100 px-1 px-md-4" style="margin: 0 auto;">



    <div class="card shadow-lg p-4 bg-white rounded">

        <!-- Header -->
        <div class="text-center p-3 mb-4"
             style="background: linear-gradient(115deg, #0f0b8c, #77dcf5); color: white; border-radius: 10px;">
             <h2 class="mb-0 member-lounge-heading">Member Lounge</h2>

        </div>

        <!-- Search Bar -->
        <form action="{{ route('member.lounge') }}" method="GET" class="mb-4 ">
        <div class="search-grid-wrapper"> 
    <div class="input-group search-box position-relative">
        <input type="text" name="search" class="form-control custom-input"
               placeholder="Search by Name, club or Phone"
               value="{{ request('search') }}">

        @if(request('search'))
            <a href="{{ route('member.lounge') }}" class="clear-btn" title="Clear Search">
                &times;
            </a>
        @endif

        <button type="submit" class="btn custom-btn">Search</button>
    </div>
    </div>
</form>


        <!-- Member Cards Grid -->
        <div id="memberCardGrid" class="member-card-grid">
            @foreach($members as $member)
            <div class="member-card" style="width: 100%;">

                    <div class="card text-center shadow-sm border-0 d-flex flex-column justify-content-between"
                         onclick="showMemberDetails({!! htmlspecialchars(json_encode([
                            'profile' => $member->profile_photo,
                            'firstName' => $member->first_name,
                            'lastName' => $member->last_name,
                            'role' => $member->role ?? '',
                            'memberId' => $member->member_id,
                            'salutation' => $member->salutation ?? '',
                            'suffix' => $member->suffix ?? '',
                            'spouseName' => $member->spouse_name ?? '',
                            'dob' => $member->dob ? \Carbon\Carbon::parse($member->dob)->format('d M Y') : '',
'anniversary' => $member->anniversary_date ? \Carbon\Carbon::parse($member->anniversary_date)->format('d M Y') : '',

                            'email' => $member->email_address ?? '',
                            'preferredEmail' => $member->preferred_email ?? '',
                            'workEmail' => $member->work_email ?? '',
                            'alternateEmail' => $member->alternate_email ?? '',
                            'phone' => $member->phone_number ?? '',
                            'preferredPhone' => $member->preferred_phone ?? '',
                            'workNumber' => $member->work_number ?? '',
                            'homeNumber' => $member->home_number ?? '',
                            'multipleDistrict' => $member->parentMultipleDistrict->name ?? '',
                            'district' => $member->parentDistrict->name ?? '',
                            'accountName' => $member->account->chapter_name ?? '',
                            'membershipType' => $member->membership_type ?? '',
                            'membershipFullType' => $member->membershipType->name ?? '',
                         ]), ENT_QUOTES, 'UTF-8') !!})"
                         style="cursor:pointer; background-color: #ffffff; background-image: linear-gradient(315deg, #ffffff 0%, #1e90ff 74%); color: #fff; border-radius: 10px; height: 260px;">

                        <div class="card-body p-2">
                            <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                 alt="Profile Picture"
                                 class="mb-2 shadow-sm"
                                 style="height: 120px; width: 120px; object-fit: fill; border-radius: 5px; border: 3px solid white;">

                            @php
                                $fullName = trim($member->first_name . ' ' . $member->last_name);
                                $displayName = strlen($fullName) > 15 ? substr($fullName, 0, 15) . '...' : $fullName;
                            @endphp

                            <h6 class="card-title" style="font-size: 12px;" title="{{ $fullName }}">
                                {{ $displayName }}
                            </h6>

                            <p class="mb-1" style="font-size: 11px;"><strong>ID:</strong> {{ $member->member_id }}</p>
                            <p class="mb-1" style="font-size: 10px;"><strong>{{ $member->account->chapter_name ?? 'N/A' }}</strong></p>
                            <p class="mb-1" style="font-size: 10px;"><i class="fa fa-phone"></i> {{ $member->phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $members->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
</div>

<!-- Member Detail Side Container -->
@include('member.memberlounge.member_details')


<script>
    function showMemberDetails(member) {
        // Display container
        document.getElementById('memberDetailsContainer').style.display = 'block';
        

        // Shift content and grid layout
        document.querySelector('.main-content').classList.add('shift-left');
        document.getElementById('memberCardGrid').classList.add('sidebar-active');
document.querySelector('.search-grid-wrapper').classList.add('sidebar-active');


        // Set image
        document.getElementById('profilePic').src = member.profile ? `/storage/app/public/${member.profile}` : '/assets/images/default.png';

        // Basic info
        document.getElementById('firstName').innerText = member.firstName + ' ' + member.lastName;
        document.getElementById('memberRole').innerText = member.role;

        // Account tab
        document.getElementById('multipleDistrict').innerText = member.multipleDistrict || '';
        document.getElementById('district').innerText = member.district || '';
        document.getElementById('accountName').innerText = member.accountName || '';

        // Personal tab
        document.getElementById('memberId').innerText = member.memberId || '';
        document.getElementById('salutation').innerText = member.salutation || '';
        document.getElementById('firstName').innerText = member.firstName || '';
        document.getElementById('lastName').innerText = member.lastName || '';
        document.getElementById('suffix').innerText = member.suffix || '';
        document.getElementById('spouseName').innerText = member.spouseName || '';
        document.getElementById('dob').innerText = member.dob || '';
        document.getElementById('anniversary').innerText = member.anniversary || '';

        // Contact tab
        document.getElementById('preferredEmail').innerText = member.preferredEmail || '';
        document.getElementById('email').innerText = member.email || '';
        document.getElementById('workEmail').innerText = member.workEmail || '';
        document.getElementById('alternateEmail').innerText = member.alternateEmail || '';
        document.getElementById('preferredPhone').innerText = member.preferredPhone || '';
        document.getElementById('phone').innerText = member.phone || '';
        document.getElementById('workNumber').innerText = member.workNumber || '';
        document.getElementById('homeNumber').innerText = member.homeNumber || '';

        // Membership tab
        document.getElementById('membershipType').innerText = member.membershipType || '';
        document.getElementById('membershipFullType').innerText = member.membershipFullType || '';

        // Default tab
        showTab('personal');
    }

    function closeMemberDetails() {
        document.getElementById('memberDetailsContainer').style.display = 'none';
        document.querySelector('.main-content').classList.remove('shift-left');
        document.getElementById('memberCardGrid').classList.remove('sidebar-active');
        document.querySelector('.search-grid-wrapper').classList.remove('sidebar-active');
    }

    function showTab(tabName, event) {
        document.querySelectorAll('.tab-pane').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
        if (event) event.target.classList.add('active');
    }
</script>

@endsection
