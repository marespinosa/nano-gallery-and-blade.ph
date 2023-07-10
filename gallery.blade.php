@if ($gallery)
<div class="single-property-gallery mb-16">
    {{-- <div id="single-property-gallery-view" class="single-property-gallery-view  relative">
        @foreach ($gallery as $item)
        <div class="single-property-gallery-view-item thumbnail-holder">
            {!! $item['view'] !!}
        </div>
        @endforeach
    </div> --}}
    <div class="single-property-gallery-container  relative">
        {!! get_svg('/images/slideshow-nav-left.svg', ['slideshow-nav-left slideshow-button
        slideshow-button-prev
        transition-3s']) !!}
        {!! get_svg('/images/slideshow-nav-right.svg', ['slideshow-nav-right slideshow-button
        slideshow-button-next
        transition-3s']) !!}
        <div id="single-property-gallery-slide" class="single-property-gallery-slide  relative">
            @foreach ($gallery as $item)
            <div class="single-property-gallery-slide-item thumbnail-holder">
                {!! $item['view'] !!}
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif