@extends('MasterAdmin.layout')

@section('content')

<style>
    
    /* Common styles for both tab sections */
    .nav-tabs .nav-item {
        margin-right: 1px;
        /* Adds space between tabs */
    }

    .nav-tabs .nav-link {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: white;
        border: none;
        padding: 10px 15px;
        /* Increases padding for better spacing */
        border-radius: 5px;
        /* Rounds corners slightly */
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        color: #fff;
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
        border-radius: 50%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }

    .banner-img-container {
        position: relative;
        display: inline-block;
    }

    .banner-img {
        width: 100px;
        /* Initial size */
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img-container:hover .banner-img {
        transform: scale(1.5);
        /* Zoom out */

    }

    table#complaintTable thead .sorting:after,
    table#complaintTable thead .sorting:before {
        display: none !important;
    }

    .table-responsive {
        background-color: #f8f9fa;
        /* Light background */
        color: black;
        padding: 20px;
        /* Adds space inside the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Subtle shadow effect */
        overflow: hidden;
        /* Ensures rounded corners work */

        border-radius: 10px;

    }

    /* Reduce the size of the "Show Entries" dropdown */
    .dataTables_length select {
        width: 70px !important;
        /* Reduced width */
        height: 30px;
        /* Smaller height */
        font-size: 12px;
        /* Smaller font */
        padding: 5px 10px;
        /* Adjust padding */
        border: 1px solid #ccc;
        /* Border styling */
        border-radius: 4px;
        /* Rounded corners */
        background: white;


        /* Custom arrow */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='gray' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8l-6 7a.5.5 0 0 1-.8 0l-6-7a.5.5 0 0 1-.1-.3z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 6px center;
        /* Adjust arrow position */
        background-size: 10px;
        /* Smaller arrow size */
    }

    /* On hover */
    .dataTables_length select:hover {
        border-color: #007bff;
        /* Highlight effect */
    }


    div.dataTables_wrapper div.dataTables_length select {
        width: 50px !important;
        display: inline-block;
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
        background-color: #003366;
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
</style>
<div class="container mt-4">
    <div class="white-container">
        <h5 class="text-center"> </h5>
        @include('admin.partial.alerts')

        <!-- Tab Buttons -->
        <ul class="nav nav-tabs" id="bannerTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#uploadBanners">Upload Banners</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab2">Upload Advertisement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab3">Upload Image</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab4">Upload Bottom Banners</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab5">Member Details</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#tab6">Popup Banner</a>
            </li>


        </ul>

        <!-- Edit Icon with Rotation Effect -->
        @php
        $gsb = \App\Models\Generalbanner::first() ?? new stdClass(); // Prevent null errors
        $bannerNames = [
        10000 => $gsb->{'10000'} ?? 'Default 10000',
        5000 => $gsb->{'5000'} ?? 'Default 5000',
        1000 => $gsb->{'1000'} ?? 'Default 1000'
        ];
        @endphp

        <!-- Edit Name Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Banner name update</h5>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <form id="editForm" action="{{ route('bannername') }}" method="POST">
    @csrf
    <input type="hidden" name="id" id="edit-id">
    <input type="hidden" name="banner_type" id="banner-type">

    <div class="modal-body">
        <label id="banner-label" for="banner-input">Banner</label>
        <input type="text" id="banner-input" name="banner_value" class="form-control" required>
    </div>

    <div class="modal-footer d-flex justify-content-center w-100">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary ms-2">Save Changes</button>
    </div>
</form>



                </div>
            </div>
        </div>

        <!-- Tab Content -->

        <div class="tab-content mt-3">
            <!-- Upload Banners Tab -->
            <div class="tab-pane fade show active" id="uploadBanners">
                <div class="row">


                    @foreach ([10000, 5000, 1000] as $banner)
                    <div class="col-12 col-md-4 mb-4"> <!-- Full width on mobile, 3 columns on larger screens -->
                        <div class="card h-100">
                            <div class="card-body">
                          <h5 class="card-title">
    {{$bannerNames[$banner]}} 
    <i class="fas fa-edit text-primary rotate-icon"
       data-bs-toggle="modal"
       data-bs-target="#editModal"
       data-banner="{{ $banner }}"
       data-value="{{ $gsb->{$banner} ?? '' }}"
       data-id="{{ $gsb->id ?? '' }}"
       style="cursor: pointer;">
    </i>
</h5>

                                <form action="{{ route('upload.banner') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="banner_type" value="{{ $banner }}">

                                    <div class="mb-3">
                                        <input type="file" name="image" required class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Banner URL (Optional)</label>
                                        <input type="url" name="url" class="form-control" placeholder="Enter link (optional)">
                                    </div>

                                    <button type="submit" class="btn custom-btn w-40 upload">Upload</button> <!-- Full width button -->
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @include('admin.banners.bannertables')
            </div>

            @include('admin.partial.Edit')

            <!-- Tab 2 Content -->
            <div class="tab-pane fade" id="tab2">
                <div class="row">
                    @include('admin.leftbanner')
                </div>
            </div>

            <!-- Tab 3 Content -->
            <div class="tab-pane fade" id="tab3" role="tabpanel">
                <div class="row">
                    @include('admin.rightbanner')
                </div>
            </div>

            <!-- Tab 4 Content -->
            <div class="tab-pane fade" id="tab4">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card mb-4" style="margin-top:-25px;">
                            <div class="card-body">
                                <h5 class="card-title text-center">Upload Bottom Banner</h5>
                                <!-- @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                                @endif -->
                                <form action="{{ route('upload.bottom.banner') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <small class="text-muted">Banner size should be 1353x180px</small>
                                    <input type="file" name="image" required class="form-control">
                                    <small class="text-muted">Banner URL optional</small>
                                    <input type="text" name="website_link" placeholder="Enter link (optional)" class="form-control mt-2">
                                    <button type="submit" class="btn custom-btn mt-2 upload">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Display Uploaded Banners in Table -->
                <div class="row mt-5">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered dt-responsive nowrap" id="uploadbanner" style="width: 100%; overflow-x: auto;">
                                <thead style="background-color:#003366;">
                                <tr>
            <th style=" color: white; text-align: center; text-transform: capitalize;">S.No</th>
            <th style=" color: white; text-align: center; text-transform: capitalize;">Image</th>
            <th style=" color: white; text-align: center; text-transform: capitalize;">Website Link</th>
            <th style=" color: white; text-align: center; text-transform: capitalize;">Created At</th>
            <th style=" color: white; text-align: center; text-transform: capitalize;">Actions</th>
        </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="banner-img-container">
                                                <img class="banner-img" src="{{ asset('storage/app/public/' . $banner->image) }}" width="150">
                                            </div>
                                        </td>
                                        <td>
    @if(!empty($banner->website_link))
        <a href="{{ $banner->website_link }}" target="_blank">{{ $banner->website_link }}</a>
    @else
        No Link
    @endif
</td>

                                        <td>{{ $banner->created_at->format('d-m-Y h:i:s') }}</td>
                                        <td>
                                            <form action="{{ route('delete.bottom.banner', $banner->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger sweet-delete" data-name="Banner #{{ $loop->iteration }}">

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
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

            <!-- Tab 5 Content (Moved Inside tab-content) -->
            <div class="tab-pane fade" id="tab5">
                <div class="row">
                    @include('admin.member')
                </div>
            </div>

            <!-- Tab 5 Content (Moved Inside tab-content) -->
            <div class="tab-pane fade" id="tab6">
                <div class="row">
                    @include('admin.popup')
                </div>
            </div>

        </div>
        <!-- Closing .tab-content properly -->
    </div>


    <!-- Include Bootstrap JS for Tabs Functionality -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tabGroups = ["#uploadTabs", "#pricingTabs"];

            tabGroups.forEach(groupId => {
                let tabLinks = document.querySelectorAll(`${groupId} .nav-link`);
                tabLinks.forEach(link => {
                    link.addEventListener("click", function() {
                        tabLinks.forEach(tab => tab.classList.remove("active"));
                        this.classList.add("active");
                    });
                });
            });
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.sweet-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    const name = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: `You are about to delete ${name}. This cannot be undone!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#uploadbanner').DataTable({
                "pageLength": 10, // Set initial page length
                "ordering": false, // Disable sorting
                "searching": true, // Enable search
                "lengthChange": true, // Show "Show X entries" dropdown
                "info": true, // Show "Showing X of X entries"
                "lengthMenu": [10, 25, 50, 100] // Dropdown options
            });


        });
    </script>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editModal');

    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const bannerType = button.getAttribute('data-banner');
        const bannerValue = button.getAttribute('data-value');
        const bannerId = button.getAttribute('data-id');

        // Set form values
        document.getElementById('banner-type').value = bannerType;
        document.getElementById('edit-id').value = bannerId;
        document.getElementById('banner-input').value = bannerValue;

        // Update label dynamically
        let label = '';
        if (bannerType == '10000') label = 'Banner One';
        else if (bannerType == '5000') label = 'Banner Two';
        else if (bannerType == '1000') label = 'Banner Three';

        document.getElementById('banner-label').innerText = label;
    });
});

    </script>


    @endsection