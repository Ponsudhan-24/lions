
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<style>
    .upload{
        border-radius: 24px;
    }

    .banner-img-container {
    position: relative;
    display: inline-block;
    }

    .banner-img {
        width: 100px; /* Initial size */
        height: auto;
        transition: transform 0.3s ease-in-out;
    }

    .banner-img-container:hover .banner-img {
        transform: scale(1.5); /* Zoom out */
    }


    /* Table Styles */
table#complaintTable thead th {
    background-image: none !important;
    cursor: default !important;
}

table#complaintTable thead .sorting:after,
table#complaintTable thead .sorting:before {
    display: none !important;
}
table#Table thead .sorting:after,
table#Table thead .sorting:before {
    display: none !important;
}
/* Styles for DataTable container */
.table-responsive {
background-color: #f8f9fa; /* Light background */
color:black;
padding: 20px; /* Adds space inside the container */
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
overflow: hidden; /* Ensures rounded corners work */
width:100%;
border-radius: 10px;

margin-top:-36px;

}
.table-responsive th,td{
    text-align:center !important;
}

/* Styles for the DataTable */
#complaintTable {
overflow: hidden; /* Ensures proper edge handling */
}

/* Ensuring the table header has a proper background */
#complaintTable thead th,#Table thead th
{
background-color: #ffffff; /* Dark background for better contrast */
color: rgb(0, 0, 0); /* White text */
}

/* Table row hover effect */
#complaintTable tbody tr:hover {
background-color: #e9ecef; /* Light grey hover effect */
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
appearance: none; /* Removes default arrow */
-webkit-appearance: none;
-moz-appearance: none;
background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="gray"><path d="M5 7l5 5 5-5H5z"/></svg>');
background-repeat: no-repeat;
background-position: right 5px center;
background-size: 20px;
}

.dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_paginate {
        color: black !important;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_paginate {
        color: black !important;
    }

    /* Add borders to table */
    table.dataTable {
        border-collapse: collapse !important;
        width: 100%;
    }

    table.dataTable th,
    table.dataTable td {
        border: 1px solid black !important;
        padding: 8px;
    }

     /* Make the page length dropdown (select) text black */
     .dataTables_length select {
        color: black !important;
    }

    /* Also, make the label text black */
    .dataTables_length label {
        color: black !important;
    }

</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="col-12 col-md-6 mb-4"> <!-- Full width on mobile, 2 columns on larger screens -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Upload Advertisement Image 1</h5>
            <form action="{{ route('upload.ad') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ad_type" value="ad1">
                
                <div class="mb-3">
                    <input type="file" name="image" required class="form-control">
                </div>

                <div class="mb-3">
                    <input type="url" name="website_link" placeholder="Enter Website URL" required class="form-control">
                </div>

                <button type="submit" class="btn custom-btn w-40 upload">Upload</button> <!-- Full width button -->
            </form>
        </div>
    </div>
</div>

<div class="col-12 col-md-6 mb-4"> <!-- Same for the second card -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Upload Advertisement Image 2</h5>
            <form action="{{ route('upload.ad') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ad_type" value="ad2">

                <div class="mb-3">
                    <input type="file" name="image" required class="form-control">
                </div>

                <div class="mb-3">
                    <input type="url" name="website_link" placeholder="Enter Website URL" required class="form-control">
                </div>

                <button type="submit" class="btn custom-btn w-40 upload">Upload</button>
            </form>
        </div>
    </div>
</div>

<ul class="nav nav-tabs mt-4" id="adTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ad1-tab" data-bs-toggle="tab" data-bs-target="#ad1" type="button" role="tab">Advertisement Image 1</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="ad2-tab" data-bs-toggle="tab" data-bs-target="#ad2" type="button" role="tab">Advertisement Image 2</button>
    </li>
</ul>

<div class="tab-content mt-3" id="adTabsContent">
    <div class="tab-pane fade show active" id="ad1" role="tabpanel">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="ad1Table" style="width: 100%; overflow-x: auto;">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Image</th>
                    <th>Website Link</th>
                    <th>Action</th>
                </tr>
            </thead>
         <tbody>
    @if(isset($adimage) && count($adimage) > 0)
        @foreach($adimage as $index => $image)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- Loop counter -->
                <td>
                    <div class="banner-img-container">
                        <img class="banner-img" src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image" width="100">
                    </div>
                </td>
                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    @if(!empty($image->website_link))
        <a href="{{ $image->website_link }}" target="_blank">{{ $image->website_link }}</a>
    @else
        No Link
    @endif
</td>


                <td>
                    <form action="{{ route('delete.ad.image', ['id' => is_array($image) ? $image['id'] : $image->id, 'ad_type' => 'ad1']) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>

        </table>
    </div>

 <div class="tab-pane fade" id="ad2" role="tabpanel">
    <table class="table table-striped table-bordered dt-responsive nowrap" id="ad2Table" style="width: 100%; overflow-x: auto;">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Image</th>
        <th>Website Link</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
    @if(isset($adimage2) && count($adimage2) > 0)
        @foreach($adimage2 as $index => $image)
            <tr id="row-{{ $image->id }}"> <!-- ✅ Unique ID for JavaScript -->
                <td>{{ $index + 1 }}</td> <!-- S.No -->

                <td>
                    <div class="banner-img-container">
                        <img class="banner-img" src="{{ asset('storage/app/public/' . $image->image_path) }}" alt="Ad Image" width="100">
                    </div>
                </td>

                <td>
                    @if(!empty($image->website_link))
                        <a href="{{ $image->website_link }}" target="_blank">{{ $image->website_link }}</a>
                    @else
                        No Link
                    @endif
                </td>

                <td>
                    <!-- Action: delete form -->
                    <form action="{{ route('delete.ad.image', ['id' => $image->id, 'ad_type' => 'ad2']) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>



        </table>
    </div>
</div>

<script>
    // Attach the click event to all delete buttons
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the form from submitting immediately
            
            const form = this.closest('form'); // Find the closest form to the clicked button
            
            // Show SweetAlert confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit the form if confirmed
                    form.submit();
                }
            });
        });
    });
</script>

@if (session('sweetalert'))
    <script>
        Swal.fire({
           
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        $('#ad1Table').DataTable({
            responsive: true,
            ordering: false, 
            pageLength: 10
        });

        $('#ad2Table').DataTable({
            responsive: true,
            ordering: false, 
            pageLength: 10
        });
    });
</script>
