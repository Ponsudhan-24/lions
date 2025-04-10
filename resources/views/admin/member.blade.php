<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>



<style>
    .member{
        border-radius: 24px !important;
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

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">Member Details</h2>

                <!-- Success Message -->
                @if(session('success'))
    <div class="alert alert-success text-center fade-message">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center fade-message">
        {{ session('error') }}
    </div>
@endif

<!-- Auto-close script -->
<script>
    setTimeout(function() {
        document.querySelectorAll('.fade-message').forEach(el => {
            el.style.transition = "opacity 0.5s";
            el.style.opacity = "0";
            setTimeout(() => el.remove(), 500); // Remove after fading out
        });
    }, 3000); // 3 seconds
</script>



                <!-- Member Form -->
                <form action="{{ route('admin.addMember') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role:</label>
                        <input type="text" name="role" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Image:</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn custom-btn w-50 member">Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Display Members -->
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">Member List</h2>
                <table class="table table-striped table-bordered dt-responsive nowrap" id="birthdaysTable" style="width: 100%; overflow-x: auto;">
            <thead style="background-color:#003366;">
        <tr>
            <th>Name</th>
            <th>Role</th>
            <th>Image</th>
            <th>Action</th> <!-- Add Action Column -->
        </tr>
    </thead>
    <tbody>
        @foreach($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->role }}</td>
                <td>
                    <img src="{{ asset('storage/app/public/' . $member->image) }}" width="50" height="50">
                </td>
                <td>
                <form action="{{ route('admin.deleteMember', $member->id) }}" method="POST" class="delete-member-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-sm sweet-delete" data-name="{{ $member->name }}">
        <i class="fas fa-trash-alt"></i>
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



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.sweet-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                const memberName = this.getAttribute('data-name');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete "${memberName}". This action cannot be undone!`,
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
@if (session('sweetalert'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '{{ session('sweetalert') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif


<script>
$(document).ready(function () {
    $('#birthdaysTable').DataTable({
        "pageLength": 10,                // Set initial page length
        "ordering": false,              // Disable sorting
        "searching": true,              // Enable search
        "lengthChange": true,           // Show "Show X entries" dropdown
        "info": true,                   // Show "Showing X of X entries"
        "lengthMenu": [10, 25, 50, 100]  // Dropdown options
    });

    $('#anniversariesTable').DataTable({
        "pageLength": 10,
        "ordering": false,
        "searching": true,
        "lengthChange": true,
        "info": true,
        "lengthMenu": [10, 25, 50, 100]
    });
});
</script>


