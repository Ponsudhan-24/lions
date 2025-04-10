@extends('MasterAdmin.layout')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
#memberDetailsBody th {
    text-transform: capitalize;
    font-size: 14px; /* Adjust header font size */
}

#memberDetailsBody td {
    font-size: 13px; /* Adjust data font size */
}

#memberDetailsContainer {
    font-size: 14px; /* Adjust overall font size */
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
    background-color:#003366;
    font-size: 15px;
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

.bg-primary{
    background-color: rgba(0, 0, 0, 0.151) !important;
}

.custom-btn {
    background: rgb(30,144,255);
    background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
    border: none;
    color: white;
    padding: 8px 17px;
    font-size: 16px;
    border-radius: 5%;
    transition: 0.3s;
}

.custom-btn:hover {
    background: linear-gradient(159deg, rgba(153,186,221,1) 0%, rgba(30,144,255,1) 100%);
    color: white;
}
</style>

<div class="container mt-4">
    <div class="white-container">

        <h3 class="mb-3 custom-heading">Member lists</h3>

    <div class="card shadow-lg">
        <div class="card-header text-white d-flex justify-content-between align-items-center bg-primary">

            <div class="d-flex align-items-center new">
                <!-- Import Form -->
                <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center me-2">
                    @csrf
                    <label for="" class="form-label mb-0 me-2 text-dark">Upload CSV/Excel</label>
                    <input type="file" name="import_file" id="import_file" class="form-control form-control-sm me-2" required>
                    <button type="submit" class="btn btn-light btn-sm me-2 custom-btn">Import</button>
                </form>

                <!-- Add Members Button -->
                <a href="{{ route('members.add') }}" class="btn btn-success btn-sm me-2 custom-btn">
                    <i class="bi bi-person-plus-fill"></i> Add Member
                </a>

                <!-- Settings Button -->
                <a href="{{ route('admin.settings.add') }}" class="btn btn-secondary btn-sm custom-btn">
                    <i class="bi bi-gear-fill"></i> Settings
                </a>
            </div>
        </div>



    @include('admin.partial.alerts')
    <div class="row">
    <!-- Members Table (Initially full width) -->
    <div id="tableContainer" class="col-md-12">
        <table id="membersTable" class="table table-bordered">
            <thead class="table-white" style="text-transform: capitalize;">
                <tr>
                    <th>S.No</th>
                    <th>Member ID</th>
                    <th>Name</th>
                    {{-- <th>Parent District</th> --}}
            <th>Account Name</th> <!-- New Column -->
            {{-- <th>Membership Full Type</th> <!-- New Column --> --}}
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $key => $member)
                <tr>
                    <td style="width: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $key + 1 }}</td>
                    <td  style="width: 20px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <a class="view-member" data-id="{{ $member->id }}">
                            {{ $member->member_id }}
                        </a>
                    </td>
                    <td style="width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    {{ $member->first_name }} {{ $member->last_name }}
</td>
{{-- <td>
                {{ $member->parentDistrict ? $member->parentDistrict->name : 'N/A' }}
            </td> --}}
            <td>{{ $member->account ? $member->account->chapter_name : 'N/A' }}</td> <!-- Account Name -->
            {{-- <td>{{ $member->membershipType ? $member->membershipType->name : 'N/A' }}</td> <!-- Membership Full Type --> --}}

<td style="width: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm border-0 text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm border-0 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onclick="return confirm('Are you sure?')">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Member Details (Initially hidden) -->
    <div id="memberDetailsContainer" class="col-md-4" style="display: none;">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Member Details</h5>
                <div id="profilePhotoContainer"></div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody id="memberDetailsBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


    </div>
</div>
</div>

<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $('#membersTable').DataTable({
        "paging": true,        // Enable pagination
        "searching": true,     // Enable search
        "ordering": false,     // Disable sorting
        "info": true,          // Show info text
        "lengthMenu": [250, 500, 750, 1000], // Control entries per page
    });

    // Reduce font size of table data
    $('#membersTable tbody td').css("font-size", "13px");  // Adjust size as needed

    // Capitalize table headers
    $('#membersTable thead th').css("text-transform", "capitalize");

    // Increase width of "Show Entries" dropdown box
    setTimeout(function () {
        $('select[name="membersTable_length"]').css("width", "100px");
    }, 500);
});
</script>



<!-- Initialize Bootstrap Tooltips -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>



@endsection
