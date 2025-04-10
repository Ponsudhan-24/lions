@extends('layouts.navbar')

@section('content')
<style>
    /* Apply style to upcoming event cards */

    :root {
        --purple: #603f8b;
        --aqua: #b4fee7;
        --violet: #a16ae8;
        --fuchsia: #fd49a0;
        --white: #efefef;
        --black: #222;
        --trueBlack: #000;
    }

    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    body {
        background-color: var(--black);
    }

    .main {
        max-width: 1200px;
        margin: 0 auto;
    }

    .cards {
        display: grid;
        width: 250px;
        flex-wrap: wrap;
        list-style: none;
        margin: 0;
        padding: 0;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .cards_item {
        display: flex;
    }

    .card_image {
        display: flex;
        height: 100px;
        border-radius: 9px;
        box-shadow: 0 50px 100px 0 #ffcc00;
        /* Updated color to #ffcc00 */
    }

    .card_image img {
        display: block;
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .card {
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        background-color: var(--purple);
        transition: transform 0.1s linear, box-shadow 0.2s;
    }

    .card_text:focus,
    .card:focus {
        outline: 2px dashed var(--aqua);
    }

    .card:focus,
    .card:hover {
        transform: scale(1.01);
        box-shadow: 0 10px 5px -5px rgba(0, 0, 0, 0.2);
    }

    .card_content {
        padding: 0.5rem 1rem 1rem;
        color: var(--white);
    }

    .card_title {
        position: absolute;
        top: 0;
        right: 0;
        width: 90%;

        height: auto;
        color: var(--white) !important;
        padding: 0.5rem;
        border-radius: 5px 0 0 5px;
        transform: rotate(-3.3deg);
        transform-origin: left top;
        font-family: Georgia, Times, serif;
        font-weight: 300;
        postition: relative;
        overflow: hidden;
        z-index: 1;
        background:#00338c;
        /* Updated background */
        animation: 0s 0s fly-in 0 reverse both;
    }

    @media (min-width: 535px) {
        .card_title {
            animation: 0.5s 0.25s fly-out 1 both;
        }
    }

    .card:focus .card_title,
    .card:hover .card_title {
        animation: 0.5s ease-in 0s fly-in 1 both;
    }

    .card_text {
        font-family: Segoe UI, Frutiger, Frutiger Linotype, Dejavu Sans, Helvetica,
            Helvetica Neue, Arial, sans-serif;
        line-height: 1.5;
        text-size-adjust: 0.2px;
        padding: 0 1rem;
    }

    .card_text p:first-of-type:first-letter {
        font-size: 1.8em;
        font-family: Georgia, Times, serif;
        margin-right: 0.05em;
    }

    @media (min-width: 480px) {
        .card_text {
            overflow: auto;
            max-height: 20rem;
            scrollbar-width: thin;
            scrollbar-color: var(--aqua) var(--violet);
        }

        .card_text::-webkit-scrollbar {
            width: 12px;
        }

        .card_text::-webkit-scrollbar-track {
            background: var(--violet);
        }

        .card_text::-webkit-scrollbar-thumb {
            background-color: var(--aqua);
        }
    }

    .card_text strong {
        color: var(--aqua);
    }

    .upcharge {
        position: relative;
        font-weight: 600;
        background-color: var(--violet);
        padding: 0.5rem 0.75rem;
        color: var(--trueBlack);
        border-radius: 0 10px;
        z-index: 0;
        overflow: hidden;
    }

    .upcharge::after,
    .upcharge::before {
        content: "+";
        display: block;
        line-height: 0;
        font-size: 3rem;
        position: absolute;
        color: var(--purple);
        z-index: -1;
        opacity: 0.3;
    }

    .upcharge::before {
        left: 0;
        top: 0.5rem;
    }

    .upcharge::after {
        right: 0;
        bottom: 1.25rem;
    }

    .note {
        display: block;
        text-align: center;
        padding: 0.5rem;
        font-weight: 900;
        background-image: linear-gradient(-45deg,
                transparent 10%,
                var(--aqua) 10.5%,
                var(--aqua) 90%,
                transparent 90.5%);
        color: var(--black);
        font-size: 1.3em;
        font-style: italic;
        margin-top: 1rem;
    }

    @keyframes fly-in {
        0% {
            top: 0;
            right: 0;
            font-size: 13px;
        }

        25% {
            top: 0;
            right: -200%;
            font-size: 13x;
        }

        26% {
            font-size: 13px;
        }

        100% {
            top: 2rem;
            right: 0;
            font-size: 13px;
        }
    }

    @keyframes fly-out {
        0% {
            top: 2rem;
            right: 0;
            font-size: 12px;
        }

        50% {
            top: 0;
            right: -200%;
            font-size: 12px;
        }

        100% {
            top: 0;
            right: 0;
            font-size: 12px;
        }
    }

    .member-heading {
        font-size: 19px !important;
        font-weight: bold !important;
        text-align: center !important;
        width: 100% !important;
        color: #333 !important;
        padding: 15px 0 !important;
        border-radius: 5px !important;
        margin-bottom: 15px !important;
    }

    /* Tabs should be in a single row and centered */
    .nav-pills {
        display: flex !important;
        flex-wrap: nowrap !important;
        justify-content: center !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        padding: 10px !important;
        border-radius: 5px !important;
    }

    /* Default tab styling - transparent background */
    .nav-pills .nav-link {
        color: #000 !important;
        background-color: transparent !important;
        border: .5px solid black !important;
        font-weight: 600;
        padding: 10px 15px;
    }

    /* Active tab styling */
    .nav-pills .nav-link.active {
        background-color: #003366 !important;
        color: #ffffff !important;
        font-weight: bold;
        border-bottom: 2px solid #003366 !important;
    }

    /* Tab Content Styling */
    .tab-content {
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        padding: 20px !important;
        border-radius: 5px !important;
        min-height: 200px !important;
        border: 1px solid #ddd !important;
    }

    /* Member Card Styling */
    .member-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        width: 200px;
    }

    .member-card:hover {
        transform: translateY(-5px);
    }

    .profile-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        /* Fixed missing value */
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .profile-img:hover {
        transform: scale(1.1);
    }

    .card {
        width: 100%;

        margin: auto;
    }

    .card-img-top {
        height: 120px;
        object-fit: cover;
    }

    .card-body {
        padding: 10px;
    }

    .card-title {
        font-size: 16px;
        font-weight: bold;
    }

    .card-text {
        font-size: 14px;
    }

    .tab-content {
        animation: fadeIn 0.5s ease-in-out;
    }

    .tab-pane p {
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.5s ease-out forwards;
        animation-delay: 0.2s;
    }





    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }



    #eventDetailsCard {
        position: absolute;
        top: 100px;
        /* Adjust based on header */
        right: 20px;
        /* Shift it to the right */
        width: 350px;
        max-height: 500px;
        overflow-y: auto;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        border-radius: 8px;
        display: none;
        /* Hidden initially */
        transition: all 0.3s ease-in-out;
        z-index: 1000;
        /* Ensure it appears above other elements */
    }

    .eventImagesContainer img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin: 5px;
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
    }

    .eventImagesContainer img:hover {
        transform: scale(1.2);
    }

    #mainContent {
        display: flex;
        transition: margin-right 0.3s ease-in-out;
        position: relative;
    }


    /* Ensure the parent containers allow sticky positioning */
    .container {
        position: relative;
    }

    /* Make the tab navigation sticky */
    #customTabs {
        position: sticky;
        top: 0;
        color: white;
        z-index: 100;
        /* Ensure a solid background */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Optional: Subtle shadow */
    }

    /* Ensure month navigation stays sticky below the tabs */
    .month-link {
        position: sticky;
        top: 60px;
        /* Adjust based on the tab height */
        z-index: 99;
        background-color: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Optional: Shadow effect */
    }


    .sticky-tabs {
        position: sticky;
        background: #fff;
        top: 0;
        border-radius: 5px;
        width: 1230px;

        transform: translateX(-56px);
    }

    #noUpcomingEvents {
        color: white !important;
    }

    .text-light {
        font-size: 13px;
    }

    /* Style the main event container */
    #eventDetailsContainer {
        background-color: #00509e;
        /* Gradient background */
        border-radius: 20px;
        /* Rounded corners */
        color: #000;
        /* White text */
        padding: 20px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        border-left: 4px solid #ffc107;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Card Styling */
    .event-card {
        background: #ffffff;
        border-radius: 15px;
        padding: 8px;
        width: 330px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Event Images */
    #eventImagesContainer {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    #eventImagesContainer img {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        /* Circular images */
        object-fit: fill;
        border: 3px solid #fff;
    }

    /* Text Styles */
    .event-card h5 {
        font-size: 15px;
        font-weight: bold;
        color: black;
    }

    /* Close Button */
    #closeEventDetails {
        background-color: rgba(255, 255, 255, 0.6);
        border-radius: 50%;
        padding: 5px;
    }


    p {
        margin-top: 0;
        margin-bottom: 1rem;
        text-align: justify;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        #eventDetailsContainer {
            width: 90%;
            margin-top: 150px;
        }

        .sticky-tabs {
            width: -webkit-fill-available;
          transform: translateX(0px);
          margin-bottom:5px;
            /* Remove horizontal shift */
        }

    /* Make the tab navigation sticky */
    #customTabs {
        width: fit-content;
        position: sticky;
        top: 0;
        color: white;
        z-index: 100;
        /* Ensure a solid background */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Optional: Subtle shadow */
    }

    }

    @media (min-width: 992px) {
        .col-lg-5th {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }
</style>

<style>
    @media (min-width: 992px) {
        #eventsContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        #eventsContainer .event-row {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

    @media (max-width: 991.98px) {
        #eventsContainer .event-row {
            flex: 0 0 48%;
            max-width: 48%;
        }
    }
</style>


<div class="container " style="max-width: 1400px !important;">
    <!-- Full-Width Heading -->
    <div class="container">
        <div class="d-flex justify-content-start sticky-tabs">
            <ul class="nav nav-pills flex-row ms-3" id="customTabs">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2-tab" data-bs-toggle="pill" href="#tab2">Upcoming Events</a>
                </li>
                &nbsp;
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1-tab" data-bs-toggle="pill" href="#tab1">Completed Events</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content">
        <!-- Completed Events Tab -->
        <div class="tab-pane fade {{ $activeTab === 'tab1' ? 'show active' : '' }}" id="tab1">
            <h3 class="fw-bold  text-white d-flex align-items-center">
                Completed Events
                @if($completedEvents->isNotEmpty())
                <span class="fw-bold text-white ms-3">{{ now()->year }}</span>
                @endif
            </h3>

            <!-- Month Navigation -->
            <div class="mb-3">
                @php
                $currentMonthIndex = now()->format('n'); // Current month number (1-12)
                $currentMonth = now()->format('F'); // Add this line
                $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
                ];
                @endphp


                @foreach($months as $index => $month)
                @if($index < $currentMonthIndex)
                    <a href="#" class="month-link btn btn-outline-primary btn-sm 
                {{ $month === now()->format('F') ? 'active' : '' }}"
                    data-month="{{ $month }}">
                    {{ $month }}
                    </a>
                    @endif
                    @endforeach
            </div>

            <!-- Completed Events List -->
            <div id="eventsContainer" class="row gx-3 gy-3">

                @forelse($completedEvents as $event)
                @php
                $eventMonth = \Carbon\Carbon::parse($event->event_date)->format('F');
                @endphp

                <div class="event-row cards_item col-6 col-lg-auto" data-month="{{ $eventMonth }}" style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
                    <div class="card completed-event-card  rounded shadow-sm  d-flex flex-column justify-content-center align-items-center"
                        tabindex="0"
                        style="width:225px; height:195px; cursor: pointer; border: 2px solid #ffcc00; background:#fff; transition: transform 0.3s ease-in-out;"
                        data-event-id="{{ $event->id }}"
                        data-event-name="{{ $event->event_name }}"
                        data-event-date="{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}"
                        data-event-venue="{{ $event->venue }}"
                        data-event-details="{{ $event->details }}"
                        data-event-images="{{ json_encode($event->images) }}"
                        onclick="showCompletedEventDetails(this)">

                        {{-- Optional: Display first image if exists --}}
                        @php
                        $images = is_array($event->images) ? $event->images : json_decode($event->images, true);
                        $firstImage = isset($images[0]) ? asset('storage/app/public/' . $images[0]) : null;
                        @endphp

                        @if($firstImage)
                        <div class="card_image">
                            <img src="{{ $firstImage }}" alt="Event Image" style="width:100%; height:100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        </div>
                        @endif

                        <div class="card_content text-center p-2">
                            <h2 class="card_title text-dark" style="font-size: 16px;">
                                {{ $event->event_name }}
                            </h2>
                            <p class="card_text text-muted" style="font-size: 14px; margin-bottom: 5px;">
                                {{ \Carbon\Carbon::parse($event->event_date)->format('l, M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-light">No completed events available.</p>
                @endforelse
            </div>


        </div>



        <!-- Upcoming Events Tab -->
        <div class="tab-pane fade {{ $activeTab === 'tab2' ? 'show active' : '' }}" id="tab2">
        <h3 class="fw-bold text-white d-flex align-items-center">
    Upcoming Events -
    <span class="fw-bold text-white ms-3">{{ now()->year }}</span>
</h3>



            <!-- Month Navigation -->
            <div class="mb-3">
                @php
                $currentMonth = now()->format('F');
                $currentMonthIndex = now()->format('n') - 1;
                $months = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
                @endphp

                @foreach($months as $index => $month)
                @if($index >= $currentMonthIndex)
                <a href="#" class="month-link btn btn-outline-primary btn-sm 
                    {{ $month === $currentMonth ? 'active' : '' }}"
                    data-month="{{ $month }}">
                    {{ $month }}
                </a>
                @endif
                @endforeach
            </div>

            <!-- Events List -->
            <div id="upcomingEventsList" class="row g-3">
                @php $hasEventsForCurrentMonth = false; @endphp

                @forelse($upcomingEvents as $event)
                @php
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $eventMonth = $eventDate->format('F');
                if ($eventMonth === $currentMonth) $hasEventsForCurrentMonth = true;

                $imagePath = $event->event_invitation
                ? 'storage/app/public/event_invitations/' . $event->event_invitation
                : 'assets/images/default1.png';
                @endphp

                <div class="event-row cards_item col-6 col-lg-5th" data-month="{{ $eventMonth }}" style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
                    <div class="card upcoming-event-card p-3 rounded shadow-sm mb-2 d-flex flex-column justify-content-center align-items-center"
                        tabindex="0"
                        style="height: auto; cursor: pointer; border: 2px solid #ffcc00; background:#fff; transition: transform 0.3s ease-in-out;"
                        data-name="{{ $event->event_name }}"
                        data-date="{{ $eventDate->format('M d, Y') }}"
                        data-image="{{ asset($imagePath) }}"
                        onclick="showUpcomingEventDetails(this)">

                        <div class="card_image">
                            <img src="{{ asset($imagePath) }}"
                                alt="Event Image"
                                style="width:100%; height:100%; object-fit: cover; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        </div>

                        <div class="card_content text-center p-2">
                            <h2 class="card_title text-dark" style="font-size:12px; font-weight: bold;">{{ $event->event_name }}</h2>
                            <p class="card_text text-muted" style="font-size:10px; margin-bottom: 5px;">
                                {{ $eventDate->format('l, M d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                @php $hasEventsForCurrentMonth = false; @endphp
                @endforelse
            </div>
        </div>




    </div>

</div>


<!-- Completed Event Details Modal Container -->
<div id="eventDetailsContainer" class="position-fixed top-0 end-0 shadow-lg p-4 d-none"
    style="width: 400px; height:60vh; z-index: 1055; overflow-y: auto; 
            margin-top:240px; 
             border-top-left-radius: 20px; border-bottom-left-radius: 20px;">

    <!-- Close Button -->
    <button class="btn-close position-absolute top-0 end-0 m-2" id="closeEventDetails" onclick="closeEventDetails()"></button>

    <!-- Card Wrapper -->
    <div class="event-card p-3 rounded shadow-sm bg-white">
        <!-- Event Images -->
        <div id="eventImagesContainer" class="d-flex justify-content-center gap-2 mb-3"></div>

        <h5 class="fw-bold text-center">Event Details</h5>

        <p><strong style="font-size:12px;">Name:</strong> <span id="detailEventName" style="font-size:12px;"></span></p>
        <p><strong style="font-size:12px;">Date:</strong> <span id="detailEventDate" style="font-size:12px;"></span></p>
        <p><strong style="font-size:12px;">Venue:</strong> <span id="detailEventVenue" style="font-size:12px;"></span></p>
        <p><strong style="font-size:12px;">Details:</strong> <span id="detailEventDetails" style="font-size:12px;"></span></p>
    </div>
</div>



<!-- Upcoming Event Details Modal -->
<div id="upcomingEventDetails" class="position-fixed top-0 end-0 shadow-lg p-4 d-none"
    style="width: 380px;  z-index: 1055; overflow-y: auto; 
            border-left: 4px solid #ffc107; margin-top:240px; 
            background-color:#fff; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">

    <!-- Close Button -->
    <button class="btn-close position-absolute top-0 end-0 m-2" id="closeUpcomingEventDetails"></button>

    <!-- Event Invitation Image -->
    <div id="upcomingEventInvitationContainer" class="mb-3 text-center">
        <img id="upcomingEventInvitationImage" src="" alt="Event Invitation"
            class="img-fluid rounded shadow-sm"
            style="width:170px; height:200px; object-fit: fill;">
    </div>

    <!-- Event Details Card -->
    <div class="card text-dark shadow-sm" style="background-color:linear-gradient(115deg, #ffffff, #eeeeee, #ffffff);">
        <div class="card-body">
            <p class="text-light"><strong>Event Name:</strong> <span id="upcomingEventName"></span></p>
            <p class="text-light"><strong>Event Date:</strong> <span id="upcomingEventDate"></span></p>
        </div>
    </div>


</div>






<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".event-card").forEach(card => {
            card.addEventListener("click", function() {
                console.log("Event card clicked!"); // Debugging

                let detailsContainer = document.querySelector("#eventDetailsContainer");

                // Populate event details
                document.getElementById("detailEventName").innerText = this.getAttribute("data-event-name");
                document.getElementById("detailEventDate").innerText = this.getAttribute("data-event-date");
                document.getElementById("detailEventVenue").innerText = this.getAttribute("data-event-venue") || "N/A";
                document.getElementById("detailEventDetails").innerText = this.getAttribute("data-event-details") || "N/A";

                // Populate images
                let imageContainer = document.getElementById("eventImagesContainer");
                imageContainer.innerHTML = ""; // Clear previous images
                let eventImages = JSON.parse(this.getAttribute("data-event-images") || "[]");
                let eventId = this.getAttribute("data-event-id");

                if (eventImages.length > 0) {
                    eventImages.forEach(imgSrc => {
                        let imgElement = document.createElement("img");
                        imgElement.src = `/storage/app/public/${imgSrc}`;
                        imgElement.classList.add("event-image");
                        imgElement.style.cursor = "pointer";
                        imgElement.style.width = "80px";
                        imgElement.style.height = "80px";
                        imgElement.style.borderRadius = "5px";
                        imgElement.style.margin = "5px";
                        imgElement.style.objectFit = "cover";

                        imgElement.addEventListener("click", function() {
                            let selectedImage = encodeURIComponent(imgSrc);
                            window.location.href = `/member-gallery/?highlight=${selectedImage}`;
                        });


                        imageContainer.appendChild(imgElement);
                    });
                }

                // Show details container
                detailsContainer.classList.remove("d-none");
            });
        });

        // Close event details
        document.getElementById("closeEventDetails").addEventListener("click", function() {
            document.getElementById("eventDetailsContainer").classList.add("d-none");
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tab => {
            tab.addEventListener("click", function() {
                let eventDetailsContainer = document.getElementById("eventDetailsContainer");
                if (eventDetailsContainer && !eventDetailsContainer.classList.contains("d-none")) {
                    eventDetailsContainer.classList.add("d-none");
                }
            });
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthLinks = document.querySelectorAll(".month-link");
        const eventRows = document.querySelectorAll(".event-row");

        function filterCompletedEvents(selectedMonth) {
            let hasEvents = false;

            eventRows.forEach(row => {
                if (row.getAttribute("data-month") === selectedMonth) {
                    row.style.display = "block";
                    hasEvents = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Remove any existing "No events" message
            document.getElementById("noCompletedEvents")?.remove();


        }

        monthLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove 'active' class from all month links
                monthLinks.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                // Get selected month and filter events
                const selectedMonth = this.getAttribute("data-month");
                filterCompletedEvents(selectedMonth);
            });
        });

        // Auto-select and filter the current month on page load
        const currentMonth = new Date().toLocaleString('default', {
            month: 'long'
        });
        const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

        if (currentMonthButton) {
            currentMonthButton.classList.add("active"); // Ensure it's marked active
            filterCompletedEvents(currentMonth); // Show only current month events
        }
    });
</script>



<script>
    function showUpcomingEventDetails(eventCard) {
        let eventName = eventCard.getAttribute("data-name");
        let eventDate = eventCard.getAttribute("data-date");
        let eventImageUrl = eventCard.getAttribute("data-image");

        document.getElementById("upcomingEventName").innerText = eventName;
        document.getElementById("upcomingEventDate").innerText = eventDate;

        let imgElement = document.getElementById("upcomingEventInvitationImage");

        if (eventImageUrl && eventImageUrl.trim() !== "") {
            imgElement.src = eventImageUrl;
            imgElement.onerror = function() {
                imgElement.src = 'assets/images/default-placeholder.jpeg';
            };
            document.getElementById("upcomingEventInvitationContainer").classList.remove("d-none");
        } else {
            document.getElementById("upcomingEventInvitationContainer").classList.add("d-none");
        }

        let detailsContainer = document.getElementById("upcomingEventDetails");
        detailsContainer.classList.remove("d-none");

        // Prevent multiple event listeners
        document.removeEventListener("click", closeDetailsOnOutsideClick);
        setTimeout(() => {
            document.addEventListener("click", closeDetailsOnOutsideClick);
        }, 100);
    }

    // Function to close the details when clicking outside
    function closeDetailsOnOutsideClick(event) {
        let detailsContainer = document.getElementById("upcomingEventDetails");
        let eventCards = document.querySelectorAll(".upcoming-event-card");

        let isClickInsideDetails = detailsContainer.contains(event.target);
        let isClickOnCard = Array.from(eventCards).some(card => card.contains(event.target));

        if (!isClickInsideDetails && !isClickOnCard) {
            detailsContainer.classList.add("d-none");
            document.removeEventListener("click", closeDetailsOnOutsideClick);
        }
    }

    // Close button functionality
    document.getElementById("closeUpcomingEventDetails").addEventListener("click", function() {
        document.getElementById("upcomingEventDetails").classList.add("d-none");
        document.removeEventListener("click", closeDetailsOnOutsideClick);
    });
</script>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        const monthLinks = document.querySelectorAll(".month-link");
        const eventRows = document.querySelectorAll(".event-row");
        const eventsContainer = document.getElementById("upcomingEventsList");

        function filterUpcomingEvents(selectedMonth) {
            let hasEvents = false;

            eventRows.forEach(row => {
                if (row.getAttribute("data-month") === selectedMonth) {
                    row.style.display = "block";
                    hasEvents = true;
                } else {
                    row.style.display = "none";
                }
            });

            // Remove existing "No events" message if present
            document.getElementById("noUpcomingEvents")?.remove();

            if (!hasEvents) {
                const noDataMessage = document.createElement("p");
                noDataMessage.id = "noUpcomingEvents";
                noDataMessage.className = "text-muted";
                noDataMessage.innerText = "No upcoming events available.";
                eventsContainer.appendChild(noDataMessage);
            }
        }

        monthLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove 'active' class from all month links
                monthLinks.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                // Get selected month and filter events
                const selectedMonth = this.getAttribute("data-month");
                filterUpcomingEvents(selectedMonth);
            });
        });

        // Auto-select and filter the current month on page load
        const currentMonth = new Date().toLocaleString('default', {
            month: 'long'
        });
        const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

        if (currentMonthButton) {
            currentMonthButton.classList.add("active"); // Ensure it's marked active
            filterUpcomingEvents(currentMonth); // Show only current month events
        }
    });
</script>

<script>
    function showCompletedEventDetails(card) {
        // Get event details from the clicked card
        const eventId = card.getAttribute('data-event-id');
        const eventName = card.getAttribute('data-event-name');
        const eventDate = card.getAttribute('data-event-date');
        const eventVenue = card.getAttribute('data-event-venue');
        const eventDetails = card.getAttribute('data-event-details');
        const eventImages = JSON.parse(card.getAttribute('data-event-images'));

        // Populate the modal with event details
        document.getElementById('detailEventName').textContent = eventName;
        document.getElementById('detailEventDate').textContent = eventDate;
        document.getElementById('detailEventVenue').textContent = eventVenue;
        document.getElementById('detailEventDetails').textContent = eventDetails;

        // Show images in the modal if any
        const imagesContainer = document.getElementById('eventImagesContainer');
        imagesContainer.innerHTML = ''; // Clear existing images
        eventImages.forEach(image => {
            const imgElement = document.createElement('img');
            imgElement.src = `{{ asset('storage/app/public/') }}/${image}`;
            imgElement.alt = 'Event Image';
            imgElement.style = 'width: 100px; height: 100px; object-fit: cover; margin: 5px;';
            imagesContainer.appendChild(imgElement);
        });

        // Show the modal
        document.getElementById('eventDetailsContainer').classList.remove('d-none');
    }

    function closeEventDetails() {
        // Hide the modal
        document.getElementById('eventDetailsContainer').classList.add('d-none');
    }
</script>






@endsection