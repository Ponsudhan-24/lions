<style>
    /* Modal Content - Initial Background */
    .modal-content {
        height: 500px;
        background-size: contain;
        background-position: center;
        color: white;
        text-align: center;
        position: relative;
        padding: 40px 20px;
        border-radius: 10px;
        transition: background-image 1s ease-in-out;
    }

    /* Dark overlay for readability */
    .modal-content::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        border-radius: 10px;
    }

    /* Ensure content is on top of overlay */
    .modal-body, .modal-header {
        position: relative;
        z-index: 2;
    }

    /* Close button styling */
    .btn-close {
        filter: invert(1);
    }

    /* Centering content */
    .modal-title {
        font-size: 28px;
        font-weight: bold;
    }

    .modal-body p {
        font-size: 18px;
        margin-top: 10px;
    }

    @media (max-width: 768px) {

        .modal-content {
            margin-top:50% ;
            background-repeat: no-repeat;
        height: 225px;
        background-color: rgba(255, 255, 255, 0);
        color: white;
        text-align: center;
        position: relative;
        padding: 40px 20px;
        border-radius: 10px;
        transition: background-image 1s ease-in-out;
    }

    }
</style>

@php
    // Fetch all popups (latest first)
    $popups = \App\Models\Popup::latest()->get();
    $popupImages = $popups->pluck('image')->map(fn($image) => asset("storage/app/public/" . $image))->toArray();
@endphp

@if($popups->count() > 0)
    <!-- Pop-up Banner Modal -->
    <div class="modal fade show" id="popupCarouselModal" tabindex="-1" aria-labelledby="popupCarouselLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content " id="modalBackground" style="background-image: url('{{ $popupImages[0] ?? asset("assets/images/celebration.jpg") }}');" loading="lazy">
                <div class="modal-header border-0">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="margin-top:-80px;"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="popupCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                        @foreach($popups as $key => $popup)
    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
        @if($popup->link)
            <a href="{{ route('track.banner.click', ['type' => 'popup', 'url' => $popup->link, 'image' => $popup->image]) }}" target="_blank" style="text-decoration: none; color: inherit;">
        @endif

        <div class="d-flex flex-column align-items-center text-center p-3">
            <h4 class="text-white modal-title px-3 py-2 rounded">{{ $popup->title }}</h4>
            <p class="text-white modal-title p-2 rounded">{{ $popup->content }}</p>
        </div>

        @if($popup->link)
            </a>
        @endif
    </div>
@endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var popupCarouselModal = new bootstrap.Modal(document.getElementById('popupCarouselModal'));
            popupCarouselModal.show();

            // Auto-hide after 5 minutes
            setTimeout(function () {
                popupCarouselModal.hide();
            }, 300000);

            // Background Image Slide Effect
            let popupImages = @json($popupImages);
            let modalBg = document.getElementById("modalBackground");
            let currentIndex = 0;

            function changeBackground() {
                currentIndex = (currentIndex + 1) % popupImages.length;
                modalBg.style.backgroundImage = `url('${popupImages[currentIndex]}')`;
            }

            setInterval(changeBackground, 5000); // Change background every 5 seconds
        });
    </script>
@endif
