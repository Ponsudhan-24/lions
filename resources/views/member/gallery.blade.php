@extends('layouts.navbar')

@section('content')


<style>
    .selected-card {
        border: 3px solid #007bff !important;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        transition: all 0.3s ease-in-out;
    }
</style>
<div class="container mt-4">
    <h3 class="fw-bold text-center">Gallery</h3>

    <!-- Month Navigation -->
    <div class="mb-3 text-center">
        @php
            $currentMonth = now()->format('F');
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 
                       'July', 'August', 'September', 'October', 'November', 'December'];
        @endphp

        @foreach($months as $month)
            <a href="#" class="month-link btn btn-outline-primary btn-sm 
                {{ $month === $currentMonth ? 'active' : '' }}" 
                data-month="{{ $month }}">
                {{ $month }}
            </a>
        @endforeach
    </div>

@php
$highlightedImage = request()->query('highlight') ? basename(request()->query('highlight')) : null;
@endphp

<div class="row g-3" id="galleryContainer">
    @php 
        $hasImages = false; 
        // Ensure sorting is done based on the actual event date
        $sortedEvents = $completedEvents->sortBy(function ($event) {
            return \Carbon\Carbon::parse($event->event_date);
        });
    @endphp

    @forelse($sortedEvents as $event)
        @php
            $eventMonth = \Carbon\Carbon::parse($event->event_date)->format('F');
            $eventDate = \Carbon\Carbon::parse($event->event_date)->format('d-m-Y'); // Display actual event date
            $images = $event->images ?? [];
            $mainImage = !empty($images) ? asset('storage/app/public/' . $images[0]) : null;
            $mainImageName = !empty($images) ? basename($images[0]) : null;
            $eventName = $event->event ? $event->event->event_name : 'Unknown Event';
        @endphp

        @if($mainImage)
            @php $hasImages = true; @endphp
            <div class="col-md-3 col-sm-6 event-card" data-month="{{ $eventMonth }}" 
                 style="{{ $eventMonth !== $currentMonth ? 'display: none;' : '' }}">
                <a href="{{ route('gallery.show', ['id' => $event->id]) }}" 
                   class="text-decoration-none text-dark" 
                   title="Click to see the event details">
                    <div class="card shadow-sm border border-secondary {{ $highlightedImage == $mainImageName ? 'selected-card' : '' }}">
                        <img src="{{ $mainImage }}" 
                             class="card-img-top rounded-top" 
                             style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2 text-center">
                        <h6 class="card-title text-truncate" title="{{ $event->event->name }}">
    {{ $event->event->event_name }} - {{ \Carbon\Carbon::parse($event->event->event_date)->format('d-m-y') }}
</h6>

                            <div class="d-flex flex-wrap justify-content-center">
                                @foreach(array_slice($images, 1) as $image)
                                    @php $imageName = basename($image); @endphp
                                    <img src="{{ asset('storage/app/public/' . $image) }}" 
                                         class="img-thumbnail m-1 {{ $highlightedImage == $imageName ? 'border border-3 border-primary' : '' }}" 
                                         style="width: 60px; height: 50px; object-fit: cover;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif
    @empty
        <p class="text-muted text-center w-100">No completed event images available.</p>
    @endforelse

    @if(!$hasImages)
        <p class="text-muted text-center w-100" data-month="{{ $currentMonth }}">No images available for this month.</p>
    @endif
</div>





</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.month-link').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let selectedMonth = this.getAttribute('data-month');

                document.querySelectorAll('.event-card').forEach(card => {
                    card.style.display = card.getAttribute('data-month') === selectedMonth ? 'block' : 'none';
                });

                document.querySelectorAll('.month-link').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
<script>
    let eventDate = @json($eventDate);
    console.log("Event Date:", eventDate);
</script>

@endsection
