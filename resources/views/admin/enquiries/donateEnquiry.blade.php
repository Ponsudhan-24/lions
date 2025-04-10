@extends('MasterAdmin.layout')

@section('content')


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<style>
    /* Reduce the size of the "Show Entries" dropdown */
.dataTables_length select {
    width: 70px !important;               /* Reduced width */
    height: 30px;                         /* Smaller height */
    font-size: 12px;                      /* Smaller font */
    padding: 5px 10px;                    /* Adjust padding */
    border: 1px solid #ccc;               /* Border styling */
    border-radius: 4px;                   /* Rounded corners */
    background: white;


    /* Custom arrow */
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='gray' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8l-6 7a.5.5 0 0 1-.8 0l-6-7a.5.5 0 0 1-.1-.3z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 6px center; /* Adjust arrow position */
    background-size: 10px;                 /* Smaller arrow size */
}

/* On hover */
.dataTables_length select:hover {
    border-color: #007bff;                /* Highlight effect */
}


div.dataTables_wrapper div.dataTables_length select {
    width: 50px !important;
    display: inline-block;
}

.table-responsive {
    background-color: #f8f9fa; /* Light background */
    color:black;
    padding: 20px; /* Adds space inside the container */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
    overflow: hidden; /* Ensures rounded corners work */

    border-radius: 10px;

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
.table th{
    color: white !important;
    font-size: 15px;
}

.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height:115%;
}
</style>

<div class="container mt-4">
    <div class="white-container">
        <div class="card-header text-center">
            <h3 class="mb-3 custom-heading">Donation Enquiries</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="enquiryTable" class="table table-bordered table-striped">
                    <thead style="background-color:#003366;">
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Amount</th>
                            <th>Message</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($donations->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center" style="color:black !important;">No donation enquiries found.</td>
                            </tr>
                        @else
                            @foreach($donations as $key => $donation)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $donation->name }}</td>
                                    <td>{{ $donation->email }}</td>
                                    <td>{{ $donation->phone }}</td>
                                    <td>{{ $donation->location }}</td>
                                    <td>₹ {{ number_format($donation->amount) }}</td>
                                    <td>{{ $donation->message }}</td>
                                    <td>{{ $donation->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('donation.destroy', $donation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
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
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        // Suppress DataTable warning messages
        $.fn.dataTable.ext.errMode = 'none';

        setTimeout(function() {
            if ($('#enquiryTable tbody tr').length > 1 || $('#enquiryTable tbody tr td').text().trim() !== "No data available") {
                $('#enquiryTable').DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "pageLength": 10
                });
            }
        }, 500);
    });
</script>




@endsection
