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

        /* Active Tab */
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

        /* Hide inactive tabs */
        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.active {
            display: block;
        }

        /* Member Card */
        .member {
            background: #00509E;
            border-radius: 15px;
            color: white;
            text-align: center;
            width: 200px;
            height: 250px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            padding: 15px;
        }

        /* Profile Image */
        .image {
            width: 140px;
            height: 115px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Hover Effect */
        .member:hover {
            border: 2px solid #ffcc00;
        }

        /* Mobile View */
        @media (max-width: 767px) {

            .col-lg-3,
            .col-md-4,
            .col-sm-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            .member {
                width: 100%;
            }
        }
    </style>

    <div class="container mt-4" style="max-width: 1400px !important;">
        <div class="row">
            @include('member.tab')
        </div>

        <h3>Club Members</h3>

     <!-- Search + Dropdown -->
<div class="row align-items-center mb-3">
    <div class="col-md-6 d-flex justify-content-center">
        <select class="form-select w-75" id="chapterDropdown">
            <option value="all" selected>Show All Chapters</option>
            @foreach ($chapters as $chapter)
                <option value="#chapter-{{ Str::slug($chapter->chapter_name) }}">
                    {{ $chapter->chapter_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        <div class="input-group w-75">
            <input type="text" class="form-control" id="searchInput" placeholder="Search by name, member ID, or position...">
            <span class="input-group-text bg-white" id="searchIcon" style="cursor: pointer;">
                <i class="bi bi-search"></i>
            </span>
        </div>
    </div>
</div>

<!-- Members Content -->
<div class="tab-content mt-3 mb-3">
    @foreach ($chapters as $chapter)
        <div class="tab-pane fade show active chapter-tab" id="chapter-{{ Str::slug($chapter->chapter_name) }}">
            <!-- Leadership Section -->
            <div class="leadership-container">
                <h5 class="mt-4 leadership-title">{{ $chapter->chapter_name }} - Leadership</h5>
                <div class="row leader-section justify-content-center" style="gap: 2px;">
                    @foreach($members->where('account_name', $chapter->id)->whereIn('position', ['President', 'Secretary', 'Treasurer']) as $leader)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4" id="data1">
                            <div class="member profile-card1" data-bs-toggle="modal" data-bs-target="#profileModal"
                                data-name1="{{ $leader->first_name }} {{ $leader->last_name }}"
                                data-member-id1="{{ $leader->member_id }}"
                                data-memberposition="{{ $leader->position }}"
                                data-chapter="{{ $chapter->chapter_name }}">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $leader->profile_photo ? asset('storage/app/public/' . $leader->profile_photo) : asset('assets/images/default.png') }}"
                                        class="image object-fit-cover">
                                </div>
                                <h6 class="mt-3">{{ $leader->first_name }} {{ $leader->last_name }}</h6>
                                <p>{{ $leader->position }}</p>
                                <p><strong>{{ $leader->member_id }}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Members Section -->
            <div class="members-container">
                <h5 class="mt-4 members-title">{{ $chapter->chapter_name }} - Members</h5>
                <div class="row member-section justify-content-center">
                    @foreach($members->where('account_name', $chapter->id)->whereNotIn('position', ['President', 'Secretary', 'Treasurer']) as $member)
                        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4" id="data">
                            <div class="member profile-card" data-bs-toggle="modal" data-bs-target="#profileModal"
                                data-name="{{ $member->first_name }} {{ $member->last_name }}"
                                data-member-id="{{ $member->member_id }}">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $member->profile_photo ? asset('storage/app/public/' . $member->profile_photo) : asset('assets/images/default.png') }}"
                                        class="image img-fluid">
                                </div>
                                <h6 class="mt-3">{{ $member->first_name }} {{ $member->last_name }}</h6>
                                <p><strong>{{ $member->member_id }}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- No Results Message -->
            <div class="text-center mt-3 no-results d-none">
                <p class="text-danger">No search results found.</p>
            </div>
        </div>
    @endforeach
</div>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropdown = document.getElementById('chapterDropdown');
        const searchInput = document.getElementById('searchInput');
        const searchIcon = document.getElementById('searchIcon');

        function updateView() {
            const selectedValue = dropdown.value;
            const keyword = searchInput.value.trim().toLowerCase();
            let anyMatchFound = false;

            document.querySelectorAll('.chapter-tab').forEach(tab => {
                const isChapterMatch = selectedValue === 'all' || tab.id === selectedValue.replace('#', '');
                let showTab = false;
                let leaderVisible = false;
                let memberVisible = false;

                if (isChapterMatch) {
                    const leaders = tab.querySelectorAll('.profile-card1');
                    const members = tab.querySelectorAll('.profile-card');

                    leaders.forEach(card => {
                        const name = (card.dataset.name1 || '').toLowerCase();
                        const id = (card.dataset.memberId1 || '').toLowerCase();
                        const position = (card.dataset.memberposition || '').toLowerCase();
                        const match = keyword === '' || name.includes(keyword) || id.includes(keyword) || position.includes(keyword);
                        const wrapper = card.closest('#data1');
                        if (wrapper) wrapper.style.display = match ? 'block' : 'none';
                        if (match) {
                            showTab = true;
                            leaderVisible = true;
                            anyMatchFound = true;
                        }
                    });

                    members.forEach(card => {
                        const name = (card.dataset.name || '').toLowerCase();
                        const id = (card.dataset.memberId || '').toLowerCase();
                        const match = keyword === '' || name.includes(keyword) || id.includes(keyword);
                        const wrapper = card.closest('#data');
                        if (wrapper) wrapper.style.display = match ? 'block' : 'none';
                        if (match) {
                            showTab = true;
                            memberVisible = true;
                            anyMatchFound = true;
                        }
                    });

                    // Toggle Leadership and Member titles
                    const leadershipTitle = tab.querySelector('.leadership-title');
                    const leadershipContainer = tab.querySelector('.leadership-container');
                    const membersTitle = tab.querySelector('.members-title');
                    const membersContainer = tab.querySelector('.members-container');
                    if (leadershipContainer) leadershipContainer.style.display = leaderVisible ? 'block' : 'none';
                    if (membersContainer) membersContainer.style.display = memberVisible ? 'block' : 'none';

                    // Toggle no result message
                    const noResults = tab.querySelector('.no-results');
                    if (noResults) noResults.classList.toggle('d-none', showTab);

                    tab.classList.toggle('show', showTab);
                    tab.classList.toggle('active', showTab);
                } else {
                    tab.classList.remove('show', 'active');
                    tab.querySelectorAll('.profile-card1, .profile-card').forEach(card => {
                        const wrapper = card.closest('#data1') || card.closest('#data');
                        if (wrapper) wrapper.style.display = 'none';
                    });
                    const noResults = tab.querySelector('.no-results');
                    if (noResults) noResults.classList.add('d-none');
                    const leadershipContainer = tab.querySelector('.leadership-container');
                    const membersContainer = tab.querySelector('.members-container');
                    if (leadershipContainer) leadershipContainer.style.display = 'none';
                    if (membersContainer) membersContainer.style.display = 'none';
                }
            });

            // Show no result message globally if needed
            if (!anyMatchFound) {
                const activeTab = document.querySelector('.chapter-tab');
                if (activeTab) {
                    activeTab.classList.add('show', 'active');
                    const noResults = activeTab.querySelector('.no-results');
                    if (noResults) noResults.classList.remove('d-none');
                }
            }
        }

        dropdown.addEventListener('change', updateView);
        searchInput.addEventListener('input', updateView);
        searchIcon.addEventListener('click', updateView);

        updateView();
    });
</script>









        <!-- ✅ Bootstrap Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
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
                        <a href="{{ route('member.login') }}" class="btn btn-primary px-4"
                            style="background-color: #003366;">Login</a>
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
