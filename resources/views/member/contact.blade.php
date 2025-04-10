@extends('layouts.navbar')

@section('content')

<div class="custom-bg d-flex align-items-center justify-content-center"
    style="background: url('{{ asset('assets/images/sample.png') }}') no-repeat center top; background-size: cover; min-height:70vh;">

    <div class="d-flex justify-content-end button">
        <a href="{{ route('membership.form') }}" class="btn btn-primary m-2">Join a club</a>
        <a href="{{ route('donation.form') }}"  class="btn btn-secondary m-2">Donation Enquiry</a>
    </div>

    <div class="card p-4 text-center custom-card"
    style="background: rgba(255, 255, 255, 0.2); border-radius: 50px;  backdrop-filter: blur(10px);">
    <h4 class="text-white">Our Address</h4>
    <p class="text-white">
        T3, 4th Floor, Ruby Manor Apartments,<br>
        208A, Velachery Main Road, Selaiyur,<br>
        Chennai 60073.
    </p>
</div>
</div>

<style>
.button {
    gap: 3px; /* Space between buttons */
    margin-top: -369px;
    margin-left:22%;
    transform:translateX(370px);

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

/* Responsive Design */
@media (max-width: 768px) {

    .button {
        gap: 3px;
        margin-top: -559px;
        margin-left: -58%;
        transform: translateX(285px);
    }

}
</style>

@endsection
