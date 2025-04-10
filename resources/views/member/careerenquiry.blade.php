@extends('layouts.navbar')

@section('content')

<style>
    /* Remove number input arrows in Chrome, Safari, Edge, and Opera */
    .no-spinner::-webkit-outer-spin-button,
    .no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remove number input arrows in Firefox */
    .no-spinner {
        -moz-appearance: textfield;
    }
</style>

<!-- SweetAlert Script for Success Message -->
@if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: 'success',
                title: 'Thank You!',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

<div class="container d-flex flex-column min-vh-100 mt-5 mb-5">
    <!-- Breadcrumbs Section -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('contact') }}">Contact</a></li>
            <li class="breadcrumb-item active" aria-current="page">Career Enquiry</li>
        </ol>
    </nav>

    <!-- Career Enquiry Form Section -->
    <div class="row justify-content-center flex-grow-1">
        <div class="col-md-6">
            <div class="card p-4" style="background: #00509e;">
                <h4 class="text-center text-white">Lions Club Career Enquiry Form</h4>

                <form action="{{ route('careerenquiry.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">First Name:</label>
                            <input type="text" name="first_name" class="form-control bg-light text-dark" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Last Name:</label>
                            <input type="text" name="last_name" class="form-control bg-light text-dark" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Email:</label>
                            <input type="email" name="email" class="form-control bg-light text-dark" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Phone:</label>
                            <input type="text" name="phone" class="form-control bg-light text-dark" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Position Interested In:</label>
                            <select name="position" class="form-control bg-light text-dark" required>
                                <option value="">Select a Role</option>
                                <option value="Volunteer">Volunteer</option>
                                <option value="Event Coordinator">Event Coordinator</option>
                                <option value="Fundraising Team">Fundraising Team</option>
                                <option value="Leadership Role">Leadership Role</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-white">Experience Level:</label>
                            <select name="experience" class="form-control bg-light text-dark">
                                <option value="No Experience">No Experience</option>
                                <option value="1-2 years">1-2 years</option>
                                <option value="3-5 years">3-5 years</option>
                                <option value="More than 5 years">More than 5 years</option>
                            </select>
                        </div>
                    </div>

                    <!-- Resume Upload & "How did you hear about us?" in the 4th row -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Upload Resume (Optional):</label>
                            <input type="file" name="resume" class="form-control bg-light text-dark">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">How did you hear about us?</label>
                            <select name="source" class="form-control bg-light text-dark">
                                <option value="Website">Website</option>
                                <option value="Social Media">Social Media</option>
                                <option value="Friend/Referral">Friend/Referral</option>
                                <option value="Event">Event</option>
                            </select>
                        </div>
                    </div>

                    <!-- Message box at the end -->
                    <div class="mb-3">
                        <label class="text-white">Why do you want to join Lions Club?</label>
                        <textarea name="motivation" class="form-control bg-light text-dark" rows="4" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary border border-warning">Submit Enquiry</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
