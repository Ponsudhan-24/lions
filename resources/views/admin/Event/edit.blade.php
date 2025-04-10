@extends('MasterAdmin.layout')

@section('content')

<style>
    .container {
        background-color: #fff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 40px auto;
    }

    @media (max-width: 768px) {
        .container {
            padding: 1.5rem;
            margin: 20px;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding: 1rem;
            margin: 10px;
        }
        
        .custom-btn {
            font-size: 14px;
            padding: 8px 16px;
            width: 100%;
            border-radius: 24px;
            margin-left: 0px;
        }
    }


    .custom-btn {
        background: rgb(30, 144, 255);
        background: linear-gradient(159deg, rgba(30, 144, 255, 1) 0%, rgba(153, 186, 221, 1) 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 24px;
        transition: 0.3s;
    }

    .custom-btn:hover {
        background: linear-gradient(159deg, rgba(153, 186, 221, 1) 0%, rgba(30, 144, 255, 1) 100%);
        color: white;
    }

</style>
<div class="container mt-4">
    <a href="{{ route('event_index') }}" class="text-decoration-none back-arrow mb-3 d-inline-block">← Back</a>


    <h3 class="mb-4">Edit Event</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" name="event_name" value="{{ $event->event_name }}" required>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" class="form-control" name="event_date" value="{{ $event->event_date }}" required>
        </div>

        <div class="mb-3">
            <label for="event_invitation" class="form-label">Change Invitation (optional)</label>
            <input type="file" class="form-control" name="event_invitation">
            @if ($event->event_invitation)
                <p>Current: <img src="{{ asset('storage/event_invitations/' . $event->event_invitation) }}" width="100"></p>
            @endif
        </div>

        <button type="submit" class="btn custom-btn w-40 upload">Update Event</button>
    </form>
</div>
@endsection