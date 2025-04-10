


<style>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var activeTab = "{{ session('activeTab') }}";
        if (activeTab) {
            var tabElement = new bootstrap.Tab(document.querySelector('[href="#' + activeTab + '"]'));
            tabElement.show();
        }
    });
</script>


<div class="row">
    <!-- Image Upload 1 -->
    <div class="d-flex justify-content-center align-items-center">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Popup Banner</h5>
                <form action="{{ route('popup.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="url" name="link" class="form-control mt-2" placeholder="Enter Website Link">
    <input type="file" name="image" required class="form-control mt-2">

    <button type="submit" class="btn custom-btn mt-2 upload">Upload</button>
</form>

            </div>
        </div>
    </div>
</div>

<div class="tab-content mt-3" id="imageTabsContent">
    <!-- Image 1 Tab -->
    <div class="tab-pane fade show active" id="image1" role="tabpanel">
        <!-- <div class="card"> -->
            <div class="card-body">

                <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="popbanner" style="width: 100%; overflow-x: auto;">
    <thead style="background-color:#003366; color: white;">
        <tr>
        <th style=" color: white; text-align: center; text-transform: capitalize;">S.No</th>
        <th style=" color: white; text-align: center; text-transform: capitalize;">Image</th>
        <th style=" color: white; text-align: center; text-transform: capitalize;">Link</th>
        <th style=" color: white; text-align: center; text-transform: capitalize;">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($popup->isEmpty())
            <tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>
        @else
            @foreach ($popup as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>

                    <td>
                        <img src="{{ asset('storage/app/public/' . $banner->image) }}" alt="Popup Image" width="100">
                    </td>

                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
    @if ($banner->link)
        <a href="{{ $banner->link }}" 
           target="_blank" 
           title="{{ $banner->link }}" 
           style="display: inline-block; max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
            {{ $banner->link }}
        </a>
    @else
        <span class="text-muted">No link</span>
    @endif
</td>


                    <td>
                        <!-- Delete Form -->
                        <form action="{{ route('popup.destroy', $banner->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm delete-button" data-id="{{ $banner->id }}">
                                <i class="fas fa-trash-alt"></i>
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
        <!-- </div> -->
    </div>
</div>


<script>
        $(document).ready(function() {
            $('#popbanner').DataTable({
                "pageLength": 10, // Set initial page length
                "ordering": false, // Disable sorting
                "searching": true, // Enable search
                "lengthChange": true, // Show "Show X entries" dropdown
                "info": true, // Show "Showing X of X entries"
                "lengthMenu": [10, 25, 50, 100] // Dropdown options
            });


        });



        document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const bannerId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    Swal.fire(
                        'Cancelled',
                        'The banner was not deleted.',
                        'error'
                    );
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
