@extends('layouts.navbar')

@section ('content')
<style>
.banner {
    background-image: url('assets/images/sample2.png');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}


textarea.form-control {
    resize: vertical;
    font-size: 16px;
    border-radius: 8px;
    width:380px;
}
    .custom-card {
    background: rgba(8, 8, 8, 0.527);
    background-size: cover;
    border: 2px solid #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    margin-top: 30px;
    width: 90%;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    padding: 15px;
}
.button {
margin-top:10px;
margin-left:705px;
gap: 3px; /* Space between buttons */

}

.button .btn-primary {
 background-color: #0052cc; /* Blue color like the "Join" button */
 color: white;
 padding: 10px 20px;
 border-radius: 5px;
 border: none;
 transition: background 0.3s;
}

.button .btn-primary:hover {
 background-color: #003da5; /* Darker blue on hover */
}

.button .btn-secondary {
 background-color: #ffcc00; /* Yellow color like the "Donate" button */
 color: black;

 padding: 10px 20px;
 border-radius: 5px;
 border: none;
 transition: background 0.3s;
}

.button .btn-secondary:hover {
 background-color: #e6b800; /* Darker yellow on hover */
}

@media (max-width: 768px) {
    .button {
        display: flex;
        transform: translateX(-5px);
        align-items: center;
        margin-left: 20px;
        gap: 15px;
    }


    .button .btn {
        width: 90%;
        max-width: 280px;
        text-align: center;
        font-size: 11px;
    }

    /* Responsive Card */
    .custom-card {
        width: 95%;
        max-width: 100%;
        margin: 20px auto;
        padding: 20px;
    }

    /* Textarea fix for smaller screens */
    textarea.form-control {
        width: 100%;
    }

    .banner .container {
        padding: 0 15px;
    }
}

</style>

<section  class="banner">
<div class="d-flex align-items-center justify-content-center">

<div class="container d-flex flex-column " >

    <div class="top-buttons button">
        <a href="{{ route('membership.form') }}" class="btn btn-primary">Join a club</a>
        <a href="{{ route('donation.form') }}" class="btn btn-secondary ">Donation Enquiry</a>
    </div>

   

    <!-- Donation Form Section -->
    <div class="row justify-content-center flex-grow-1">
        <div class="col-md-6">
            <div class="card p-4 custom-card py-3">
                <h4 class="text-center text-white">Donation Enquiry Form</h4>



                <form action="{{ route('donation.submit') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Name:</label>
                            <input type="text" name="name" class="form-control bg-light text-dark" required
                            oninput="lettersOnly(this)">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control bg-light text-dark" pattern="\d{10}" maxlength="10" required oninput="this.value = this.value.replace(/\D/g, '')">
                                <small class="text-warning d-none" id="PhoneError">Phone number must be exactly 10 digits.</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Email:</label>
                            <input type="email" name="email" class="form-control bg-light text-dark" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-white">Location:</label>
                            <input type="text" name="location" class="form-control bg-light text-dark" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6 col-12 mb-3">
                            <label class="text-white">Message:</label>
                            <textarea name="message" id="message" 
                                      class="form-control bg-light text-dark" 
                                      rows="3" maxlength="250" 
                                      oninput="updateCounter()"></textarea>
                            <small id="charCount" class="text-white">0 / 250</small>
                        </div>
                        


                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary border border-warning">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
</section>

<!-- SweetAlert2 -->

<!-- Include SweetAlert2 Library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Check for session success and trigger SweetAlert -->
@if(session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'success',
                title: 'Thanks for your interest in donating to Lions International District 3241 E!',
                text: 'One of our office bearers will contact you for further proceedings.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                width: '449px', // reduce width
            });
        });
    </script>
@endif

<script>
    function updateCounter() {
        var message = document.getElementById('message');
        var counter = document.getElementById('charCount');
        counter.textContent = message.value.length + ' / 250';
    }
    </script>
<script>
    function lettersOnly(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
    }
    </script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const phoneInput = document.getElementById("phone");
        const phoneError = document.getElementById("phoneError");

        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/\D/g, ''); // Allow only numbers
            if (this.value.length !== 10) {
                phoneError.classList.remove("d-none");
            } else {
                phoneError.classList.add("d-none");
            }
        });
    });
</script>
@endsection
