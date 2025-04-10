@extends('MasterAdmin.layout')

@section('content')
<style>

    .role{
margin-bottom: -33px !important;
    }

</style>

<!-- Role Modal Button at the Top -->
<div class="container mt-3 d-flex justify-content-end">
    <button class="btn btn-primary role" data-bs-toggle="modal" data-bs-target="#roleModal">
        Add Role
    </button>
</div>

<!-- Role Modal -->
<!-- Button to Open the Modal -->


<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Success Message -->
                <div id="successMessage" class="alert alert-success d-none fade show">
                    Role added successfully!
                </div>

                <!-- Role Form -->
                <form id="roleForm" action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="role_name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h4>Career Enquiries</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="enquiryTable" class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Preferred Contact</th>
                            <th>Preferred Time</th>
                            <th>Message</th>
                            <th>Date & Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>



                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal -->



<script>
    document.getElementById('roleForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var form = this;
        var formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let successMessage = document.getElementById('successMessage');
                successMessage.classList.remove('d-none'); // Show success message

                // Fade out the success message after 3 seconds
                setTimeout(function() {
                    successMessage.classList.add('fade');
                    successMessage.classList.add('d-none');
                }, 3000);

                form.reset(); // Clear form fields
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>



@endsection
