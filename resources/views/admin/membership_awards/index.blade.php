@extends('MasterAdmin.layout')
<style>

    /* Custom styles for the SweetAlert2 popup */
.small-popup {
    width: 400px !important;   /* Set the width of the popup */
    height: auto !important;    /* Set height to auto */
    padding: 20px !important;   /* Padding inside the popup */
}

/* Adjust the title size */
.small-title {
    font-size: 18px !important;  /* Reduce the font size of the title */
    text-align: center; /* Center the title text */
}

/* Adjust the content size */
.small-content {
    font-size: 14px !important;  /* Smaller font size for the content */
    padding: 10px !important;    /* Padding for content */
}

/* Adjust the size of the buttons */
.small-button {
    padding: 8px 16px !important;  /* Smaller padding for buttons */
    font-size: 14px !important;    /* Smaller font size for buttons */
    margin: 5px; /* Space between the buttons */
}

    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 25%;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }


    /* #submit,#add {
        border-radius: 24px;
        width: 70px;

    } */

    th,td {
    text-transform: capitalize!important; /* Ensures each word is capitalized */
}


.btn-close{
    margin-right: 13px !important;
    margin-top: -1px !important;
}

.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}

.table th{
    color: white !important;
    background-color:#003366 !important;
    font-size: 15px !important;
}

.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white; /* Ensures text is readable */
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px; /* Optional rounded edges */
    display: inline-block; /* Adjusts width to fit content */
    width: 100%; /* Ensures it spans across the container */
}

.card-header{
    font-size:20px;
}

</style>


@section('content')
<!-- Button to trigger the modal -->

<div class="container mt-4">

    <div class="white-container">

        <h3 class="mb-3 custom-heading">Membership Awards</h3>


    <!-- Membership Award Form -->
    <div class="card mb-4 ">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Add Membership Award Record</span>
            <!-- Add Award Button aligned to the right -->
            <button type="button" class="btn custom-btn" style=" border-radius: 24px; width:120px; color:white; " data-bs-toggle="modal" data-bs-target="#addAwardModal">
                + Add Award
            </button>
        </div>
        <div class="card-body">
            <form action="{{ route('membership.awards.storeMembershipAward') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">Member Name</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Enter the Name">
                    </div>

                    <div class="col-md-3">
                        <label for="award" class="form-label">Award</label>
                        <select class="form-control" id="award" name="awards_id" required>
                            <option value="">Select Award</option>
                            @foreach($awards as $award)
                            <option value="{{ $award->id }}">{{ $award->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="chapter" class="form-label">club</label>
                        <select class="form-control" id="chapter" name="chapter_id" required>
                            <option value="">Select Club</option>
                            @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}">{{ $chapter->chapter_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2  mt-4">
                        <button type="submit" id="submit" style="border-radius: 24px; width:100px; color:white;" class="btn custom-btn">Save</button>
                    </div>
                </div>

                <!-- <div class="d-flex justify-content-center">
            <button type="submit" id="submit" style="border-radius: 24px; width:100px;" class="btn custom-btn">Save</button>
        </div> -->
            </form>
        </div>

    </div>


    <!-- Modal for Adding New Award -->
    <div class="modal fade" id="addAwardModal" tabindex="-1" aria-labelledby="addAwardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAwardModalLabel">Add New Award</h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('membership.awards.storeAward') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="awardName" class="form-label">Award Name</label>
                            <input type="text" class="form-control" id="awardName" name="name" required>
                        </div>
                        <button type="submit" id="submit" style="border-radius: 24px;  color:white;" class="btn custom-btn">Save Award</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Display Membership Award Records -->
   <!-- Display Membership Award Records -->
<div class="card">
    <div class="card-header">Membership Award Records</div>
    <div class="card-body">
        <table id="imageTable1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Member Name</th>
                    <th>Award</th>
                    <th>Club</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    @foreach($records as $record)
    <tr>
        <td>{{ $loop->iteration }}</td> <!-- Serial Number -->
        <td>{{ $record->name }}</td>
        <td>{{ $record->award->name }}</td>

        <!-- Check if the chapter relationship exists -->
        <td>{{ $record->chapter ? $record->chapter->chapter_name : 'No Chapter' }}</td>

        <td>
            <!-- Delete Button -->
            <button type="button" class="btn btn-danger delete-btn" data-id="{{ $record->id }}" data-title="{{ $record->name }}">
                <i class="fas fa-trash"></i> <!-- Trash icon -->
            </button>
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
    // Event listener for delete buttons
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function() {
            const recordId = this.getAttribute("data-id");
            const recordTitle = this.getAttribute("data-title");

            // Show confirmation alert with custom class to reduce size
            Swal.fire({
                title: "Are you sure?",
                text: `You are about to delete the membership award record: "${recordTitle}"`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    popup: 'small-popup',  // Custom class for the popup size
                    title: 'small-title',  // Custom class for title size
                    content: 'small-content', // Custom class for content size
                    confirmButton: 'small-button', // Custom class for confirm button size
                    cancelButton: 'small-button'  // Custom class for cancel button size
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make Ajax DELETE request
                    fetch(`/membership-awards/${recordId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}", // CSRF token for security
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: data.success,
                                    icon: "success",
                                    confirmButtonColor: "#28a745"
                                }).then(() => {
                                    // Remove the row from the table on successful deletion
                                    const row = button.closest("tr");
                                    row.remove();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: data.error || "There was an error deleting the record.",
                                    icon: "error",
                                    confirmButtonColor: "#dc3545"
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: "Error!",
                                text: "There was an error processing your request.",
                                icon: "error",
                                confirmButtonColor: "#dc3545"
                            });
                        });
                }
            });
        });
    });
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

@endsection
