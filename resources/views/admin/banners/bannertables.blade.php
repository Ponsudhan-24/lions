<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


<style>
    .table {
        background-color: white;
    }
    .table-responsive{
        background-color: white;

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


</style>



<ul class="nav nav-tabs" id="pricingTabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#banner10000">
            {{ $bannerNames['10000'] ?? 'Banner 10,000' }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#banner5000">
            {{ $bannerNames['5000'] ?? 'Banner 5,000' }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#banner1000">
            {{ $bannerNames['1000'] ?? 'Banner 1,000' }}
        </a>
    </li>
</ul>






<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="banner10000">
        {{-- banner10000 --}}
        <div class="table-responsive mt-2">

    <div class="table-responsive">
    <table id="anniversariesTable" class="table table-striped table-bordered dt-responsive nowrap w-100">
        <thead style="background-color:#003366;">
            <tr>
                <th style="color: white; text-align: center; text-transform: capitalize;">S.No</th>
                <th style="color: white; text-align: center; text-transform: capitalize;">Banner Image</th>
                <th style="color: white; text-align: center; text-transform: capitalize;">Website Link</th>
                <th style="color: white; text-align: center; text-transform: capitalize;">Date & Time</th>
                <th style="color: white; text-align: center; text-transform: capitalize;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banner10000 as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="banner-img-container">
                            <img class="banner-img" src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" style="max-width: 100px;">
                        </div>
                    </td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <a href="{{ $banner->url }}" target="_blank" title="{{ $banner->url }}"
                           style="display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $banner->url }}
                        </a>
                    </td>
                    <td>
                        {{ $banner->created_at ? \Carbon\Carbon::parse($banner->created_at)->format('d-m-Y h:i A') : 'N/A' }}
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="10000">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        </div>
    </div>

    <div class="tab-pane fade" id="banner5000">
        {{-- banner5000 --}}
        <div class="table-responsive mt-2">
        <table id="bannerTable5000" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%; overflow-x: auto;">
            <thead style="background-color:#003366;">
                    <tr>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">S.No</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Banner Image</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Website Link</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Date & Time</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                        @foreach($banner5000 as $index => $banner)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="banner-img-container">
                               <img class="banner-img" src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" width="100">
                                    </div>
                            </td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
    <a href="{{ $banner->url }}" 
       target="_blank" 
       title="{{ $banner->url }}" 
       style="display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        {{ $banner->url }}
    </a>
</td>

                                <td>{{ $banner->created_at->format('d-m-Y h:i A') }}</td>

                                <td>

                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="5000">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="banner1000">
        {{-- banner1000 --}}
        <div class="table-responsive mt-2">
        <table id="bannerTable1000" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%; overflow-x: auto;">
        <thead>
                    <tr>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">S.No</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Banner Image</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Website Link</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Date & Time</th>
                    <th style=" color: white; text-align: center; text-transform: capitalize;">Action</th>
                    </tr>
                </thead>
                <tbody>

                        @foreach($banner1000 as $index => $banner)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="banner-img-container">
                                    <img class="banner-img" src="{{ url('/') }}/storage/app/public/{{ $banner->image_path }}" alt="Banner" width="100">
                                    </div>
                                </td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
    <a href="{{ $banner->url }}" 
       target="_blank" 
       title="{{ $banner->url }}" 
       style="display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
        {{ $banner->url }}
    </a>
</td>

                                <td>{{ $banner->created_at->format('d-m-Y h:i A') }}</td>

                                <td>

                                    <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $banner->id }}" data-title="1000">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Add jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // Initialize DataTables for all tables
        $('#bannerTable5000, #bannerTable1000').DataTable({
            "paging": true,
            "lengthMenu": [10, 25, 50],
            "searching": true,
            "ordering": false,
            "info": true,
            "responsive": true,
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoFiltered": "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>



<!-- Include jQuery and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        $('#bannerTable').DataTable({
            "paging": true,          // Enable pagination
            "lengthMenu": [10, 25, 50, 100], // Number of rows per page
            "ordering": false,       // Enable column sorting
            "info": true,            // Show info at the bottom
            "searching": true,       // Enable search box
            "language": {
                "search": "Filter Records:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>
