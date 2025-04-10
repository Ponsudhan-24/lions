@extends('MasterAdmin.layout')

@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
    .custom-heading {
        text-align: center;
        white-space: nowrap;
        padding: 10px;
        color: white;
        background: linear-gradient(115deg, #0f0b8c, #77dcf5);
        border-radius: 5px;
        display: inline-block;
        width: 100%;
    }

    .custom-btn {
        background: rgb(30,144,255);
        background: linear-gradient(159deg, rgba(30,144,255,1) 0%, rgba(153,186,221,1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
        width:140px;
    }
    .custom-btn:hover {
        opacity: 0.9;
    }


    .custom-table-header th {
    background-color: #003366;
    color: white;
    text-align: center;
}



  

</style>

<div class="container mt-4">

    <div class="card shadow rounded p-3">
    <h2 class="mb-4 custom-heading">Banner Click Statistics</h2>


        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.banner.clicks') }}" class="row g-3 mb-4" id="filterForm">
    <div class="col-md-3">
        <label>Banner Type</label>
        <select name="type" class="form-select filter-control">
            <option value="">All</option>
            <option value="top" {{ request('type') == 'top' ? 'selected' : '' }}>Top</option>
            <option value="bottom" {{ request('type') == 'bottom' ? 'selected' : '' }}>Bottom</option>
            <option value="left" {{ request('type') == 'left' ? 'selected' : '' }}>Left</option>
            <option value="right" {{ request('type') == 'right' ? 'selected' : '' }}>Right</option>
            <option value="popup" {{ request('type') == 'popup' ? 'selected' : '' }}>Popup</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control filter-control" value="{{ request('start_date') }}">
    </div>
    <div class="col-md-3">
        <label>End Date</label>
        <input type="date" name="end_date" class="form-control filter-control" value="{{ request('end_date') }}">
    </div>
    <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary w-50">Filter</button>
    </div>
</form>



        <!-- Chart -->
        <div class="mb-4">
            <canvas id="clickChart" height="100"></canvas>
        </div>

<!-- Export CSV -->
<div class="text-end mb-3">
    <a href="{{ route('admin.banner.clicks.export', request()->query()) }}" class="btn custom-btn">
        <i class="fas fa-download me-1"></i> Export CSV
    </a>
</div>



        <!-- Table -->
        <div class="table-responsive p-3">
        <table id="bannerTable" class="table table-bordered table-striped align-middle text-center">
    <thead class="custom-table-header">
        <tr>
            <th style="width: 60px;">S.No</th> <!-- Narrow S.No column -->
            <th>Banner Type</th>
            <th>Image</th>
            <th>Redirect URL</th>
            <th>Click Count</th>
            <th>Last Clicked</th>
            <th>Date & Time</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($clicks as $click)
    <tr>
        <td>{{ $loop->iteration }}</td> <!-- This gives you 1, 2, 3... -->
        <td>{{ ucfirst($click->banner_type) }}</td>
        <td>
        <img src="{{ asset('storage/app/public/' . $click->image_path) }}" class="img-thumbnail" style="width: 100px; height: 100px;">

        </td>
      <td style="max-width: 200px; word-break: break-all;">
    <a href="{{ $click->redirect_url }}" target="_blank">{{ $click->redirect_url }}</a>
</td>

        <td>{{ $click->click_count }}</td>
        <td>{{ $click->updated_at->diffForHumans() }}</td>
        <td>{{ $click->updated_at->format('d-m-Y h:i A') }}</td>

    </tr>
@endforeach

    </tbody>
</table>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<!-- jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    const ctx = document.getElementById('clickChart').getContext('2d');
    const clickChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($clickSummary->pluck('banner_type')) !!},
            datasets: [{
                label: 'Click Count',
                data: {!! json_encode($clickSummary->pluck('total_clicks')) !!},
                backgroundColor: '#4e73df',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<script>
    // Automatically submit the form when a filter changes
    document.querySelectorAll('.filter-control').forEach(input => {
        input.addEventListener('change', function () {
            document.getElementById('filterForm').submit();
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#bannerTable').DataTable({
            responsive: true,
            ordering:false,
            pageLength: 10,
            columnDefs: [
                { targets: [0, 1, 2, 3, 4, 5], className: 'text-center' }
            ]
        });
    });
</script>

@endsection
