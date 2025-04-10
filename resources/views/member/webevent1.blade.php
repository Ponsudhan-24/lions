@extends('layouts.navbar')

@section('content')
<style>
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
        border: none !important;
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
        background: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
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
        object-fit: cover; /* Fixed missing value */
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .profile-img:hover {
        transform: scale(1.1);
    }

    .card {
        width: 100%;
        max-width: 333px;
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

</style>
<style>  
#eventDetailsCard {
    width: 100%; /* Make the card take full width */
    max-width: 800px; /* Set a max width for a balanced look */
    min-height: 120px; /* Reduce height */
    transition: all 0.3s ease-in-out;
    opacity: 0;
    transform: translateY(-10px);
    padding: 10px; /* Reduce padding to make it more compact */
    border-radius: 8px; /* Slightly rounded corners for a modern look */
}

#eventDetailsCard.show {
    width:500px;
    opacity: 1;
    transform: translateY(0);
}

#eventImagesContainer img {
    width: 80px; /* Reduce image size */
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    transition: transform 0.3s ease-in-out; /* Smooth zoom effect */
}

.eventImagesContainer img:hover {
    transform: scale(1.5); /* Zoom image to 1.5x size */
    border-color: #007bff; /* Change border color on hover */
}

.rounded-table {
    border-radius: 12px;
    overflow: hidden;
    border-collapse: separate;
    border-spacing: 0;
    max-width: 800px; /* Restrict max width for a compact look */
}

.rounded-table thead tr:first-child th:first-child {
    border-top-left-radius: 12px;
}

.rounded-table thead tr:first-child th:last-child {
    border-top-right-radius: 12px;
}

.rounded-table tbody tr:last-child td:first-child {
    border-bottom-left-radius: 12px;
}

.rounded-table tbody tr:last-child td:last-child {
    border-bottom-right-radius: 12px;
}

.table td, .table th {
    padding: 10px; /* Reduce padding */
    font-size: 14px; /* Make text slightly smaller */
    white-space: nowrap; /* Prevent columns from taking extra space */
}

.shrink-table {
    width: 60% !important; /* Reduce the table width */
    margin-right: 350px; /* Move the table slightly to the left */
    transition: all 0.3s ease-in-out; /* Smooth transition */
}


</style>
<div class="container mt-4" style="max-width: 1400px !important;">
    <!-- Full-Width Heading -->
    <div class="row">
      
    </div>

    <!-- Tabs Navigation -->
    <div class="row mt-2">
        <div class="col-12">
            <ul class="nav nav-pills justify-content-center flex-row" id="customTabs">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab2' ? 'active' : '' }}" id="tab2-tab" data-bs-toggle="pill" href="#tab2">Upcoming Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'tab1' ? 'active' : '' }}" id="tab1-tab" data-bs-toggle="pill" href="#tab1">Completed Events</a>
                </li>

            </ul>
        </div>
    </div>


<!-- Tab Content -->
<div class="tab-content mt-3">
        <!-- Completed Events Tab -->
        <div class="tab-pane fade {{ $activeTab === 'tab1' ? 'show active' : '' }}" id="tab1">
            <h3 class="fw-bold d-flex align-items-center">
                Completed Events
                @if($completedEvents->isNotEmpty()) 
                    <span class="fw-bold text-white ms-3">{{ now()->year }}</span>
                @endif
            </h3>

            <!-- Month Navigation -->
            <div class="mb-3">
                @php
                    $currentMonth = now()->format('F');
                    $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                @endphp

                @foreach($months as $month)
                    <a href="#" class="month-link btn btn-outline-primary btn-sm {{ $month === $currentMonth ? 'active' : '' }}" data-month="{{ $month }}">
                        {{ $month }}
                    </a>
                @endforeach
            </div>

            <!-- Events Table -->
            <div class="table-responsive d-flex justify-content-center">
        <table class="table table-bordered  text-center" style="width: 70%;">
            <thead class="bg-primary text-white">
                <tr>
                    <th style="width: 20%;">Date</th>
                    <th style="width: 20%;">Day</th>
                    <th style="width: 60%;">Event Name</th>
                </tr>
            </thead>
            <tbody id="eventsTableBody">
            @forelse($completedEvents as $event)
        @php
            $eventDate = \Carbon\Carbon::parse($event->event_date);
        @endphp
        <tr class="event-row" 
            data-event-id="{{ $event->past_event_id }}" {{-- Use past_events.id here --}}
            data-event-name="{{ $event->event_name }}" 
            data-event-date="{{ $eventDate->format('M d, Y') }}" 
            data-event-venue="{{ $event->venue }}" 
            data-event-details="{{ $event->details }}" 
            data-event-images="{{ json_encode($event->images) }}"
            data-month="{{ $eventDate->format('F') }}"
            style="cursor: pointer;">
            <td>{{ $eventDate->format('M d, Y') }}</td>
            <td>{{ $eventDate->format('l') }}</td>
            <td class="text-primary fw-bold event-click">{{ $event->event_name }}</td>
        </tr>
    @empty
        <tr><td colspan="3" class="text-muted">No completed events available.</td></tr>
    @endforelse




    </tbody>

        </table>


        <!-- Event Details Modal Container -->
        <div id="eventDetailsContainer" class="position-fixed top-0 end-0 shadow-lg p-4 d-none" 
        style="width: 400px; height: 90vh; z-index: 1055; overflow-y: auto; 
                border-left: 3px solid #007bff; margin-top: 200px; 
                background-color: #e5e9ec; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
        <button class="btn-close position-absolute top-0 end-0 m-2" id="closeEventDetails"></button>
        <h5 class="fw-bold">Event Details</h5>
        <p><strong>Name:</strong> <span id="detailEventName"></span></p>
        <p><strong>Date:</strong> <span id="detailEventDate"></span></p>
        <p><strong>Venue:</strong> <span id="detailEventVenue"></span></p>
        <p><strong>Details:</strong> <span id="detailEventDetails"></span></p>
        <div id="eventImagesContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
    </div>
    </div>



        </div>

 <!-- Upcoming Events Tab -->
<div class="tab-pane fade {{ $activeTab === 'tab2' ? 'show active' : '' }}" id="tab2">
    <h3 class="fw-bold d-flex align-items-center">
        Upcoming Events
        @if($upcomingEvents->isNotEmpty()) 
            <span class="fw-bold text-white ms-3">{{ now()->year }}</span>
        @endif
    </h3>

    <!-- Month Navigation -->
    <div class="mb-3">
        @php
            $currentMonth = now()->format('F');
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                       'July', 'August', 'September', 'October', 'November', 'December'];
        @endphp

        @foreach($months as $month)
            <a href="#" class="month-link btn btn-outline-primary btn-sm 
                {{ $month === $currentMonth ? 'active' : '' }}" 
                data-month="{{ $month }}">
                {{ $month }}
            </a>
        @endforeach
    </div>

    <!-- Events List -->
    <div id="upcomingEventsContainer" class="d-flex flex-wrap gap-3">
        @forelse($upcomingEvents as $event)
            @php
                $eventDate = \Carbon\Carbon::parse($event->event_date);
                $eventMonth = $eventDate->format('F');
            @endphp

            <div class="event-row" data-month="{{ $eventMonth }}" 
                style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">

<!-- Event Card -->
<div class="event-wrapper d-flex flex-column align-items-start" 
    onclick="showUpcomingEventDetails(this)" 
    data-name="{{ $event->event_name }}" 
    data-date="{{ $eventDate->format('M d, Y') }}" 
    data-image="{{ asset('storage/event_invitations/' . $event->event_invitation) }}">



    <div class="event-card p-3 rounded shadow-sm mb-2 d-flex flex-column justify-content-center align-items-center"
        style="width: 150px; height: 150px; background-color:#00509e; cursor: pointer; color: #fff;">
        <div class="text-center">
            <span class="text-white" style="font-size: 14px;">
                {{ $eventDate->format('M d') }}
            </span>
        </div>
        <div class="d-flex flex-column text-center">
            <p class="mb-1 fw-bold text-break text-wrap"
                style="font-size: 14px; max-width: 130px; max-height: 36px; overflow: hidden; line-height: 18px;
                display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                {{ $event->event_name }}
            </p>
            <small class="text-white" style="font-size: 12px;">
                {{ $eventDate->format('l') }}
            </small>
        </div>
    </div>
</div>



            </div>
        @empty
            <p class="text-muted">No upcoming events available.</p>
        @endforelse
    </div>
</div>

<!-- Check if there are no events at all -->
@if($completedEvents->isEmpty() && $upcomingEvents->isEmpty())
    <div class="text-center text-muted fw-bold mt-4">No events available.</div>
@endif

</div>

<script>
    $(document).on('click', '#eventImagesContainer img', function () {
    let eventId = $('#eventDetailsContainer').data('event-id'); 
    if (eventId) {
        window.location.href = '/events/show/' + eventId;
    }
});

</script>



<!-- Updated Event Details Modal -->
<div id="upcomingEventDetails" class="position-fixed top-0 end-0 shadow-lg p-4 d-none" 
     style="width: 400px; height: 90vh; z-index: 1055; overflow-y: auto; 
            border-left: 3px solid #007bff; margin-top: 200px; 
            background-color: #e5e9ec; border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
    
    <!-- Close Button -->
    <button class="btn-close position-absolute top-0 end-0 m-2" id="closeUpcomingEventDetails"></button>
    
    <h5 class="fw-bold">Event Details</h5>
    
    <p><strong>Name:</strong> <span id="upcomingEventName"></span></p>
    <p><strong>Date:</strong> <span id="upcomingEventDate"></span></p>
    
    <!-- Event Invitation Image -->
    <div id="upcomingEventInvitationContainer" class="mt-3 d-none">
        <img id="upcomingEventInvitationImage" src="" alt="Event Invitation" 
             class="img-fluid rounded shadow-sm"
             style="max-width: 100%; max-height: 250px; object-fit: cover;"
             onerror="this.onerror=null; this.src='/default-placeholder.jpg';">
    </div>
</div>



<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.event-click').forEach(event => {
        event.addEventListener('click', function () {
            let row = this.closest('tr');
            let pastEventId = row.getAttribute('data-event-id'); // Now correctly fetching past_events ID
            
            console.log("Fetching event with ID:", pastEventId); // Debugging

            document.getElementById('eventDetailsContainer').setAttribute('data-event-id', pastEventId);
            document.getElementById('detailEventName').innerText = row.getAttribute('data-event-name');
            document.getElementById('detailEventDate').innerText = row.getAttribute('data-event-date');
            document.getElementById('detailEventVenue').innerText = row.getAttribute('data-event-venue');
            document.getElementById('detailEventDetails').innerText = row.getAttribute('data-event-details');

            let images = JSON.parse(row.getAttribute('data-event-images') || '[]');
            let imagesContainer = document.getElementById('eventImagesContainer');
            imagesContainer.innerHTML = '';

            if (images.length > 0) {
                images.forEach(img => {
                    let imgElem = document.createElement('img');
                    imgElem.src = '/storage/app/public/' + img; // Ensure correct path
                    imgElem.style.width = '100px';
                    imgElem.style.cursor = 'pointer';
                    imgElem.classList.add('rounded', 'm-1');

                    imgElem.addEventListener('click', function () {
    let selectedImage = encodeURIComponent(img); // Encode the image path
    console.log("Navigating to /member-gallery?highlight=" + selectedImage); // Debugging
    window.location.href = `/member-gallery?highlight=${selectedImage}`; // Navigate to gallery
});


                    imagesContainer.appendChild(imgElem);
                });
            } else {
                imagesContainer.innerHTML = '<p class="text-muted">No images available.</p>';
            }

            // Show event details
            document.getElementById('eventDetailsContainer').classList.remove('d-none');

            // Shrink the table
            document.querySelector('.table-responsive').classList.add('shrink-table');
        });
    });

    document.getElementById('closeEventDetails').addEventListener('click', function () {
        document.getElementById('eventDetailsContainer').classList.add('d-none');
        document.querySelector('.table-responsive').classList.remove('shrink-table');
    });
});

</script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const monthLinks = document.querySelectorAll(".month-link");
    const tableRows = document.querySelectorAll("#eventsTableBody tr");

    function filterEvents(selectedMonth) {
        let hasEvents = false;

        // Loop through table rows and show only matching months
        tableRows.forEach(row => {
            if (row.getAttribute("data-month") === selectedMonth) {
                row.style.display = "table-row";
                hasEvents = true;
            } else {
                row.style.display = "none";
            }
        });

        // Remove any existing empty row
        document.getElementById("emptyRow")?.remove();

        // If no events are found, show a message
        if (!hasEvents) {
            const tbody = document.getElementById("eventsTableBody");
            const noDataRow = document.createElement("tr");
            noDataRow.id = "emptyRow";
            noDataRow.innerHTML = `<td colspan="3" class="text-muted">No completed events available.</td>`;
            tbody.appendChild(noDataRow);
        }
    }

    monthLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Remove 'active' class from all month links
            monthLinks.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");

            // Get selected month and filter events
            const selectedMonth = this.getAttribute("data-month");
            filterEvents(selectedMonth);
        });
    });

    // Auto-select and filter the current month on page load
    const currentMonth = new Date().toLocaleString('default', { month: 'long' });
    const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);
    
    if (currentMonthButton) {
        currentMonthButton.classList.add("active"); // Ensure it's marked active
        filterEvents(currentMonth); // Show only current month events
    }
});


</script>

<script>  

document.addEventListener("DOMContentLoaded", function () {
    const monthLinks = document.querySelectorAll(".month-link");
    const eventCards = document.querySelectorAll("#upcomingEventsContainer .event-row");

    function filterUpcomingEvents(selectedMonth) {
        let hasEvents = false;

        eventCards.forEach(card => {
            if (card.getAttribute("data-month") === selectedMonth) {
                card.style.display = "block";
                hasEvents = true;
            } else {
                card.style.display = "none";
            }
        });

        // Remove any existing "No upcoming events" message
        document.getElementById("noUpcomingEvents")?.remove();

        // if (!hasEvents) {
        //     const container = document.getElementById("upcomingEventsContainer");
        //     const noDataMessage = document.createElement("p");
        //     noDataMessage.id = "noUpcomingEvents";
        //     noDataMessage.className = "text-muted";
        //     noDataMessage.innerText = "No upcoming events available.";
        //     container.appendChild(noDataMessage);
        // }
    }

    monthLinks.forEach(link => {
        link.addEventListener("click", function (e) {
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
    const currentMonth = new Date().toLocaleString('default', { month: 'long' });
    const currentMonthButton = document.querySelector(`.month-link[data-month="${currentMonth}"]`);

    if (currentMonthButton) {
        currentMonthButton.classList.add("active"); // Ensure it's marked active
        filterUpcomingEvents(currentMonth); // Show only current month events
    }
});




</script>













</div>


<script>
function showUpcomingEventDetails(eventCard) {
    let eventName = eventCard.getAttribute("data-name");
    let eventDate = eventCard.getAttribute("data-date");
    let eventImageName = eventCard.getAttribute("data-image"); // Only filename stored

    document.getElementById("upcomingEventName").innerText = eventName;
    document.getElementById("upcomingEventDate").innerText = eventDate;

    if (eventImageName && eventImageName.trim() !== "") { 
        let correctedImagePath = `storage/app/public/${eventImageName}`;  // Full path

        console.log("Final Image Path:", correctedImagePath); // Debugging

        let imgElement = document.getElementById("upcomingEventInvitationImage");
        imgElement.src = correctedImagePath;

        imgElement.onerror = function() {
            console.error("Image failed to load, using placeholder.");
            imgElement.src = 'assets/images/default-placeholder.jpeg'; 
        };

        document.getElementById("upcomingEventInvitationContainer").classList.remove("d-none");
    } else {
        console.log("No valid event image found.");
        document.getElementById("upcomingEventInvitationContainer").classList.add("d-none");
    }

    document.getElementById("upcomingEventDetails").classList.remove("d-none");
}

// Close button functionality for upcoming events
document.getElementById("closeUpcomingEventDetails").addEventListener("click", function() {
    document.getElementById("upcomingEventDetails").classList.add("d-none");
});


</script>







@endsection
