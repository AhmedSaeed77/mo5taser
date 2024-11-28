<section class="teacher-h">
    <div class="container">
        <div class="row">
            <!-- Col -->
            <div class="col-md-8 col-sm-12">
                <div class="text-teacher">
                    <div class="title title-start">
                        <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.be_teacher')</h3>
                    </div>
                    <p class="wow animate__animated animate__fadeInUp">@lang('lang.Join our team')</p>
                    <ul>
                        <li class="wow animate__animated animate__fadeInUp">@lang('lang.own content')</li>
                        <li class="wow animate__animated animate__fadeInUp">@lang('lang.Prepare your course')</li>
                        <li class="wow animate__animated animate__fadeInUp">@lang('lang.Keep track')</li>
                    </ul>
                    <div class="title title-start">
                        <a href="{{route('join-teacher.index')}}">
                            <h3 class="wow animate__animated animate__fadeInUp">@lang('lang.join_now')</h3>
                        </a>
                    </div>
                    @if(!auth()->check())
                        <a href="{{route('register')}}" class="btn wow animate__animated animate__fadeInUp">
                            <span>@lang('lang.join us')</span>
                        </a>
                    @endif
                </div>
            </div>
            <!-- /Col -->

            <!-- Col -->
            <div class="col-md-4 col-sm-12">
                <div class="img-teacher wow animate__animated animate__fadeInUp">
                    <div class="img">
                        <img data-original="{{asset($image_control->image_join_us ?? 'site/images/teacher.jpg')}}" alt="#" class="lazyload"/>
                    </div>
                </div>
            </div>
            <!-- /Col -->
        </div>
    </div>
</section>
