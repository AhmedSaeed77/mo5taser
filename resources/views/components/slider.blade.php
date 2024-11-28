@if ($sliders->count() > 0)
    <div class="home-slider owl-carousel owl-theme">
        @foreach ($sliders as $key => $slider)
            <div class="item">
                <div class="block-home-slider">
                    <div class="overlay-img">
                        <img src="{{asset($slider->image)}}" alt="#" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

