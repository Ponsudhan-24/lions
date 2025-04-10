
{{-- Css blade Start --}}
@include('Frontend.bannersincludes.topbannercss')
{{-- Css blade End --}}

{{-- Member Profile & banner Date  start--}}

@php
    use Illuminate\Support\Facades\DB;
    $member = \App\Models\MemberDetail::first(); // Fetch first member from the table

    $banners_10000 = DB::table('banner_10000')->select('image_path', 'url')->get();
    $banners_5000 = DB::table('banner_5000')->select('image_path', 'url')->get();
    $banners_1000 = DB::table('banner_1000')->select('image_path', 'url')->get();

    $bannerData = [
        '10000' => $banners_10000,
        '5000' => $banners_5000,
        '1000' => $banners_1000,
    ];

@endphp

@if ($member)
    <div id="top-ad1" class="top-ad-container1 mx-1 mobile">
        <div class="top-ad-banner1">
            <img src="{{ asset('storage/app/public/' . $member->image) }}" alt="{{ $member->name }}" class="ban" />
        </div>
        <div class="details-container">
            <h2 class="fs-4">{{ $member->name }}</h2>
            <p class="fs-6 mb-1"><b>{{ $member->role }}</b></p>
        </div>
    </div>
@endif


<div id="top-ad" class="top-ad-container mobile"></div>


{{-- Member Profile & banner Date  End--}}

{{-- ******script section **** --}}

{{-- Banner Script Section start --}}
<script>
    const bannerData = <?php echo json_encode($bannerData); ?>;
    let bannerQueue = [];
    let currentIndex = 0;

    function shuffle(array) {
        return array.sort(() => Math.random() - 0.5);
    }

    function prepareBanners() {
        let b10000 = shuffle(bannerData['10000'].map(banner => ({
            ...banner,
            type: '10000'
        })));
        let b5000 = shuffle(bannerData['5000'].map(banner => ({
            ...banner,
            type: '5000'
        })));
        let b1000 = shuffle(bannerData['1000'].map(banner => ({
            ...banner,
            type: '1000'
        })));

        let maxLength = Math.max(b10000.length, Math.floor(b5000.length / 2), Math.floor(b1000.length / 3));

        let tempQueue = [];
        for (let i = 0; i < maxLength; i++) {
            if (b10000[i]) tempQueue.push([b10000[i]]);
            if (b5000[i * 2] && b5000[i * 2 + 1]) tempQueue.push([b5000[i * 2], b5000[i * 2 + 1]]);
            if (b1000[i * 3] && b1000[i * 3 + 1] && b1000[i * 3 + 2]) {
                tempQueue.push([b1000[i * 3], b1000[i * 3 + 1], b1000[i * 3 + 2]]);
            }
        }


        bannerQueue = shuffle(tempQueue);
        sessionStorage.setItem('bannerQueue', JSON.stringify(bannerQueue));
    }

    function showNextBanner() {
        if (bannerQueue.length === 0) return;

        const topAdContainer = document.getElementById("top-ad");
        let bannersToShow = bannerQueue[currentIndex];

        let bannerHtml = generateBannerHtml(bannersToShow);
        topAdContainer.innerHTML = bannerHtml;

        currentIndex = (currentIndex + 1) % bannerQueue.length;
    }

    function generateBannerHtml(banners) {
        let html = '<div class="top-ad-row">';
        banners.forEach(banner => {
            html += `
              <div class="top-ad-banner">
                  <a href="${banner.url}" target="_blank">
                      <img src="/storage/app/public/${banner.image_path}" alt="Banner Image" class="ad-banner-image" loading="lazy"/>
                  </a>
              </div>
          `;
        });
        html += '</div>';
        return html;
    }
    let storedQueue = sessionStorage.getItem('bannerQueue');
    if (storedQueue) {
        bannerQueue = JSON.parse(storedQueue);
    } else {
        prepareBanners();
    }

    showNextBanner();
    setInterval(showNextBanner, 5000);

</script>

{{-- Banner Script Section End --}}
