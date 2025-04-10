@extends('MasterAdmin.layout')

@section('content')

<!-- DataTables & SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.dataTables_length select {
    width: 70px !important;
    height: 30px;
    font-size: 12px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background: white;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='gray' viewBox='0 0 16 16'%3E%3Cpath d='M1.5 5.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8l-6 7a.5.5 0 0 1-.8 0l-6-7a.5.5 0 0 1-.1-.3z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 6px center;
    background-size: 10px;
}
.dataTables_length select:hover {
    border-color: #007bff;
}
.table-responsive {
    background-color: #f8f9fa;
    color: black;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border-radius: 10px;
}
.custom-heading {
    text-align: center;
    white-space: nowrap;
    padding: 10px;
    color: white;
    background: linear-gradient(115deg, #0f0b8c, #77dcf5);
    border-radius: 5px;
    width: 100%;
}
.table th {
    color: white !important;
    font-size: 15px;
}
.white-container {
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    height: 115%;
}
</style>

<!-- CSRF Meta -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <div class="white-container">
        <div class="card-header text-center">
            <h3 class="mb-3 custom-heading">Membership Enquiries</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="enquiryTable" class="table table-bordered table-striped">
                    <thead style="background-color:#003366;">
                        <tr>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">S.No.</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Name</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Email</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Phone</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Preferred Contact</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Preferred Time</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Message</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Date & Time</th>
                          <th style=" color: white; text-align: center; text-transform: capitalize;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($enquiries->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center" style="color:black !important;">No data available</td>
                            </tr>
                        @else
                            @foreach($enquiries as $key => $enquiry)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $enquiry->first_name }} {{ $enquiry->last_name }}</td>
                                    <td>{{ $enquiry->email }}</td>
                                    <td>{{ $enquiry->phone }}</td>
                                    <td>{{ ucfirst($enquiry->preferred_contact_method) }}</td>
                                    <td>{{ ucfirst($enquiry->preferred_time) }}</td>
                                    <td>{{ $enquiry->comment }}</td>
                                    <td>{{ $enquiry->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $enquiry->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $enquiry->id }}" action="{{ route('enquiry.destroy', $enquiry->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable if there's data
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

        // SweetAlert delete confirmation
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This enquiry will be deleted permanently.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        });
    });
</script>

<!-- Flash success message -->
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Deleted!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

@endsection
