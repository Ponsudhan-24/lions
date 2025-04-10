@extends('MasterAdmin.layout')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>



<style>
    .nav-tabs .nav-item {
        margin-right: 1px;
    }

    .nav-tabs .nav-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        font-weight: bold;
        border-bottom: 3px solid yellow;
    }

    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }


    .image-preview {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .image-preview img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }

    /* Fix arrow alignment in DataTables dropdown */
    .dataTables_length select {
        appearance: none;
        /* Remove default arrow */
        -webkit-appearance: none;
        -moz-appearance: none;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23000"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        padding-right: 30px;
        /* Add padding for the arrow */
        cursor: pointer;
    }

    /* Ensure consistency in dropdown size and alignment */
    .dataTables_length label {
        display: flex;
        align-items: center;
    }

    .dataTables_length select:focus {
        outline: none;
        box-shadow: 0 0 5px #007bff;
        /* Add focus effect */
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: 52px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 10px;
        }

        .custom-btn {
            font-size: 14px;
            padding: 8px 16px;
            width: 100%;
            border-radius: 24px;
            margin-left: 0px;
        }

        .card {
            width: 100% !important;
            padding: 20px;
        }
    }

    .white-container {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        height: 115%;
    }

    .table th {
        color: white !important;
        font-size: 15px;
    }

    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        /* Ensures text is readable */
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        /* Optional rounded edges */
        display: inline-block;
        /* Adjusts width to fit content */
        width: 100%;
        /* Ensures it spans across the container */
    }

    /* Responsive adjustments for screens smaller than 768px */
@media only screen and (max-width: 768px) {
    /* Make tab navigation more readable */
    .nav-tabs .nav-link {
        padding: 10px 8px;
        font-size: 14px;
        text-align: center;
    }

    /* Adjust card widths */
    .card {
        width: 100% !important;
        margin: 10px 0 !important;
    }

    /* Make headings smaller */
    .custom-heading, h5 {
        font-size: 18px !important;
        text-align: center;
    }

    /* Improve spacing inside forms */
    .form-group label,
    .form-control,
    .form-check-label {
        font-size: 14px;
    }

    .form-control {
        padding: 10px;
    }

    /* Full-width submit button */
    .custom-btn {
        width: 48% !important;
        margin-top: 10px;
        margin-left: 65px;
    }

    /* Adjust table font and make it responsive */
    table {
        font-size: 14px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .dataTables_wrapper {
        overflow-x: auto;
    }

    /* Reduce padding/margins for compact layout */
    .p-4 {
        padding: 1rem !important;
    }

    .mt-4, .my-4 {
        margin-top: 1rem !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }
}



</style>

<div class="container mt-4 ">
    <div class="white-container">
        <h3 class="mb-3 custom-heading">Events</h3>
        @include('admin.partial.alerts')

        <ul class="nav nav-tabs d-flex flex-wrap" id="bannerTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#tab1">Add Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab2">Completed Event</a>
            </li>
        </ul>

        <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="tab1">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8">
                                <div class="card shadow-lg p-4" style="width: 68%; margin-left:109px;">
                                    <!-- Form -->
                                    <form action="{{ route('events_store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="eventName" class="form-label" style="font-size:16px;">Event Name</label>
                                            <input type="text" class="form-control" style="font-size:14px;" name="event_name" id="eventName" placeholder="Enter event name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eventDate" class="form-label" style="font-size:16px;">Event Date</label>
                                            <input type="date" class="form-control" style="font-size:14px;" name="event_date" id="eventDate" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="eventInvitation" class="form-label" style="font-size:16px;">Event Invitation Image</label>
                                            <input type="file" class="form-control" style="font-size:14px;" name="event_invitation" id="eventInvitation" accept="image/*">
                                        </div>
                                        <button type="submit" class="btn custom-btn w-40 upload">Submit</button> <!-- Full width button -->
                                    </form>
                                </div>

                                <!-- Table for Displaying Stored Events -->
                                <div class="card shadow-lg p-4 mt-4" style="width: 153%; margin-left: -170px;">
                                    <h5 class="text-center">Stored Events</h5>
                                    <div class="table-responsive">
                                        <table id="imageTable1" class="table table-bordered table-striped" style="width: 100%;">
                                            <thead style="background-color:#003366;">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Event Name</th>
                                                    <th>Event Date</th>
                                                    <th>Invitation</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($events as $event)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>

                                                    <td>{{ Str::title($event->event_name) }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</td>
                                                    <td>
                                                        @php
                                                            $imagePath = 'event_invitations/' . $event->event_invitation;
                                                            $defaultImage = 'event_invitations/default-invitation.png'; // must be in storage/app/public/event_invitations

                                                            // Decide which image to use
                                                            if ($event->event_invitation && Storage::disk('public')->exists($imagePath)) {
                                                                $imageToShow = asset('storage/app/public/' . $imagePath);
                                                            } else {
                                                                $imageToShow = asset('storage/app/public/' . $defaultImage);
                                                            }
                                                        @endphp

                                                        <img src="{{ $imageToShow }}" alt="Invitation" width="100">
                                                    </td>


                                                  <td>
    <!-- Edit Button -->
    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> <!-- Edit icon -->
    </a>

    <!-- Delete Form with SweetAlert -->
    <form id="delete-form-{{ $event->id }}" action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $event->id }})">
            <i class="fas fa-trash-alt"></i> <!-- Trash icon -->
        </button>
    </form>
</td>

                                                </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- completed event form  -->
            <div class="tab-pane fade" id="tab2">
                <div class="container mt-1">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8">
                            <div class="card shadow-lg p-4">
                                <h4 class="mb-4 text-center">Event Details Form</h4>

                                <!-- Event Form -->
                                <form action="{{ route('store_completed_event') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="eventSelect" class="form-label">Select Event</label>
                                            <select class="form-select" name="event_id" id="eventSelect">
                                                @foreach(\App\Models\Event::where('event_date', '<', now())->latest()->get() as $event)
                                                    <option value="{{ $event->id }}">
                                                        {{ $event->event_name }} - {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                                    </option>
                                                    @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-6">
                                            <label for="venue" class="form-label">Event Venue</label>
                                            <input type="text" class="form-control" name="venue" id="venue" placeholder="Enter Event Venue" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="details" class="form-label">Event Details</label>
                                            <textarea class="form-control" name="details" id="details" rows="4" placeholder="Enter Event Details" required></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Add Photos (Max 3)</label>
                                            <input type="file" class="form-control" name="images[]" multiple accept="image/*" id="imageUpload" onchange="validateImages()">
                                            <small class="text-danger" id="imageError"></small>
                                        </div>
                                    </div>

                                    <script>
                                        function validateImages() {
                                            let input = document.getElementById('imageUpload');
                                            let errorMsg = document.getElementById('imageError');

                                            if (input.files.length > 3) {
                                                errorMsg.textContent = "You can upload a maximum of 3 images.";
                                                input.value = ""; // Clear the input field
                                            } else {
                                                errorMsg.textContent = ""; // Clear error message if valid
                                            }
                                        }
                                    </script>

                                    <button type="submit" class="btn custom-btn w-40 upload">Submit</button> <!-- Full width button -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- View Table -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="card shadow-lg p-4">
                                <h4 class="text-center mb-4">Completed Events</h4>
                                <div class="table-responsive">
                                    <table id="completedEventsTable" class="table table-bordered table-striped">
                                        <thead style="background-color:#003366;">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Event Name</th>
                                                <th>Venue</th>
                                                <th>Details</th>
                                                <th>Images</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($completedEvents as $index => $event)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ Str::title($event->event->event_name ?? 'N/A') }}</td>
                                                <td>{{ Str::title($event->venue) }}</td>
                                                <td>{{ Str::title($event->details) }}</td>
                                                <td>
                                                    @php
                                                    // Check if images field is an array or JSON string
                                                    $images = is_string($event->images) ? json_decode($event->images, true) : $event->images;
                                                    @endphp

                                                    @if(is_array($images) && !empty($images))
                                                    @foreach($images as $image)
                                                    <img src="{{ asset('storage/app/public/' . $image) }}" alt="Event Image" width="100" class="m-1">
                                                    @endforeach
                                                    @else
                                                    <span>No images</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form id="delete-form-{{ $event->id }}" action="{{ route('completed-events.delete', $event->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $event->id }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No completed events found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>


                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("imageUpload").addEventListener("change", function(event) {
                    const previewContainer = document.getElementById("imagePreview");
                    const files = event.target.files;
                    previewContainer.innerHTML = "";

                    if (files.length > 3) {
                        document.getElementById("imageLimitMsg").classList.remove("d-none");
                        event.target.value = "";
                        return;
                    } else {
                        document.getElementById("imageLimitMsg").classList.add("d-none");
                    }

                    Array.from(files).forEach(file => {
                        const imgElement = document.createElement("img");
                        imgElement.src = URL.createObjectURL(file);
                        previewContainer.appendChild(imgElement);
                    });
                });

                const dateInput = document.getElementById("eventDate");
                const today = new Date().toISOString().split("T")[0];
                dateInput.setAttribute("min", today);
            });
        </script>

        <!-- SweetAlert CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function confirmDelete(eventId) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${eventId}`).submit();
                    }
                });
            }
        </script>

        <script>
            $(document).ready(function() {
                $('#imageTable1').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "pageLength": 10
                });
            });
        </script>

<script>
    $(document).ready(function () {
        $('#completedEventsTable').DataTable({
            responsive: true,
            autoWidth: false,
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: false,
            info: true,
            pageLength: 10
        });
    });
</script>



        @endsection
