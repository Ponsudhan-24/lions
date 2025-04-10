@extends('MasterAdmin.layout')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
    /* Custom CSS for the tables and container */
    .container {
        padding: 20px;
    }

    h4 {
        margin-bottom: 20px;
        text-align: center;
    }

    table#districtsTable thead th {
        background-image: none !important;
        cursor: default !important;
    }

    table#districtsTable thead .sorting:after,
    table#districtsTable thead .sorting:before {
        display: none !important;
    }

    table#districtTable thead .sorting:after,
    table#districtTable thead .sorting:before {
        display: none !important;
    }

    table#chaptersTable thead .sorting:after,
    table#chaptersTable thead .sorting:before {
        display: none !important;
    }

    table#membershipTable thead .sorting:after,
    table#membershipTable thead .sorting:before {
        display: none !important;
    }



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
        color: #ffff;
        font-weight: bold;
        border-bottom: 3px solid yellow;
    }

    #districtsTable {
        width: 70%;
        /* Adjust as per your requirement */
        margin: auto;
        /* Center the table */
        overflow: hidden;
        /* Ensures corners are properly rounded */
        border-collapse: separate;
        border-spacing: 0;
        background-color: #f8f9fa;

    }

    .districtsTable th,
    .districtsTable td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .districtsTable thead th {
        background-color: #f8f9fa;

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
        width: 90%;
        border-radius: 10px;

    }

    /* Ensure pagination controls have rounded edges */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: #ffffff;
        border-radius: 5px;
        margin: 2px;
        padding: 5px 10px;
        border: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #ffffff;
    }

    /* Make the search input field rounded */
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 5px;
    }


    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
        font-size: 12px;
        padding: 2px 10px;
        appearance: none;
        /* Removes default arrow */
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray"><path d="M5 7l5 5 5-5H5z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 5px center;
        background-size: 20px;
    }

    .table th {
        text-transform: capitalize;
        ;
    }

    th,
    td {
        text-transform: capitalize !important;
        /* Ensures each word is capitalized */
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
        background-color: #003366 !important;
        font-size: 15px !important;
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

        <h3 class="mb-3 custom-heading">Setting Tables</h3>

        <div class="alert-container">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="width: 50%; margin: 0 auto;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="width: 50%; margin: 0 auto;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
</div><br>



        <!-- Nav Tabs -->
        <ul class="nav nav-tabs" id="myTabs">
            <li class="nav-item">
                <a class="nav-link active" id="districts-tab" data-bs-toggle="tab" href="#districts">Parents Multiple Districts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="district-tab" data-bs-toggle="tab" href="#district">Districts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chapters-tab" data-bs-toggle="tab" href="#chapters">Club</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="membership-tab" data-bs-toggle="tab" href="#membership">Membership Types</a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <!-- Parents Multiple Districts Tab -->
            <div class="tab-pane fade show active" id="districts">
                <div class="table-responsive" style="overflow-x: auto;">
                    <h4>Parents Multiple Districts</h4>
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="districtsTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($parentsMultipleDistricts as $district)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $district->name }}</td>

                                <td>
                                    <form action="{{ route('districts.delete', $district->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>


                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

            <!-- Districts Tab -->
            <div class="tab-pane fade" id="district">
                <div class="table-responsive" style="overflow-x: auto;">
                    <h4>Districts</h4>
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="districtTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>

                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($districts as $district)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $district->name }}</td>


                                <td>
                                    <form action="{{ route('districts.destroyDistrict', $district->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Chapters Tab -->
            <div class="tab-pane fade" id="chapters">
                <div class="table-responsive" style="overflow-x: auto;">
                    <h4>Chapters</h4>
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="chaptersTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Club Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chapters as $chapter)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $chapter->chapter_name }}</td>
                                <td>
                                    <form action="{{ route('admin.settings.deleteChapter', $chapter->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Membership Types Tab -->
            <div class="tab-pane fade" id="membership">
                <div class="table-responsive" style="overflow-x: auto;">
                    <h4>Membership Types</h4>
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="membershipTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Action</th> <!-- Add Action column for Delete -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($membershipTypes as $membership)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $membership->name }}</td>
                                <td>
                                    <!-- Delete Form -->
                                    <form action="{{ route('admin.settings.deleteMembership', $membership->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger delete-btn" title="Delete">
                                            <i class="bi bi-trash"></i>
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

<script>
    $(document).ready(function() {
        // Initializing DataTables for each table inside the container
        $('#districtsTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true
        });
        $('#districtTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true
        });
        $('#chaptersTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true
        });
        $('#membershipTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Trigger SweetAlert on delete button click
        $('.delete-btn').on('click', function(e) {
            e.preventDefault(); // Prevent form submission

            var form = $(this).closest('form'); // Get the closest form
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
</script>


@endsection