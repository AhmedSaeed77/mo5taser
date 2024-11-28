@php
    $info = \App\Models\Info::first();
    $about = \App\Models\About::first();
@endphp
<!-- Start Footer -->
    <footer>
        <!-- Footer-top -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <!-- Col -->
                    <div class="col-md-4 col-sm-12 wow animate__animated animate__fadeInUp">
                        <div class="footer-col">
                            <a href="{{route('home')}}" class="logo-f">
                                <img src="{{asset($image_control->image_footer_logo ?? 'site/images/logo.png')}}" alt="#" />
                            </a>
                            <p>{!! \Illuminate\Support\Str::limit($about->about, 300, '....') !!}</p>
                        </div>
                    </div>
                    <!-- /Col -->

                    <!-- Col -->
                    <div class="col-md-4 col-sm-12 wow animate__animated animate__fadeInUp">
                        <div class="footer-col">
                            <h3>@lang('lang.important_links')</h3>
                            <ul class="links-h">
                                <li>
                                    <a href="{{route('contact')}}">@lang('lang.contact_us')</a>
                                </li>
                                <li>
                                    <a href="{{route('about')}}">@lang('lang.about_us')</a>
                                </li>
                                <li>
                                    <a href="{{route('news')}}">@lang('lang.news')</a>
                                </li>
                                <li>
                                    <a href="{{route('term')}}">@lang('lang.term')</a>
                                </li>
                                <li>
                                    <a href="{{route('privacy')}}">@lang('lang.privacy')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /Col -->

                    <!-- Col -->
                    <div class="col-md-4 col-sm-12 wow animate__animated animate__fadeInUp">
                        <div class="footer-col contact_info">
                            <h3>@lang('lang.contact_infos')</h3>
                            <ul>
                                <li>
                                    <a href="tel:{{$info->phone ?? ''}}">
                                        <i class="la la-phone-volume"></i>
                                        <span><u>{{$info->phone ?? ''}}</u></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:{{$info->email ?? ''}}">
                                        <i class="la la-envelope"></i>
                                        <span><u>{{$info->email ?? ''}}</u></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://maps.google.com?q={{$info->address ?? ''}}" target="_blank">
                                        <i class="la la-map-marker-alt"></i>
                                        <span>{{$info->{'address_'.app()->getLocale()} ?? ''}}</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="social-f">
                                <a href="https://api.whatsapp.com/send?phone={{$info->full ?? ''}}" target="_blank">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="{{$info->twitter ?? ''}}" target="_blank">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="{{$info->instagram ?? ''}}" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="{{$info->facebook ?? ''}}" target="_blank">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /Col -->
                </div>
            </div>
        </div>
        <!-- /Footer-top -->

        <!-- Footer-bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <!-- Col -->
                    <div class="col-md-12">
                        <div class="copy-right wow animate__animated animate__fadeIn">
                            <p>&copy; @lang('lang.right_reserved')</p>
                        </div>
                    </div>
                    <!-- /Col -->
                </div>
            </div>
        </div>
        <!-- /Footer-bottom -->
    </footer>
    <!-- End Footer -->

    <div class="social-fixed">
        <a href="https://api.whatsapp.com/send?phone={{$info->full ?? ''}}" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="{{$info->instagram ?? ''}}" target="_blank">
            <i class="fab fa-instagram"></i>
        </a>
        @if($info->video_platform == 'youtube')
            <a class="venobox" data-autoplay="true" data-vbtype="iframe" href="https://www.youtube.com/embed/{{ $info->video_id }}?vq=hd720">
                <i class="fa fa-play"></i>
            </a>
        @elseif($info->video_platform == 'vimeo')
            <a class="venobox" data-autoplay="true" data-vbtype="iframe" href="https://player.vimeo.com/video/{{ $info->video_id }}?quality=720p">
                <i class="fa fa-play"></i>
            </a>

{{--            <a onclick="togglePopup('#info-video')"><i class="fa fa-play"></i></a>--}}


{{--            <div id="info-video" class="custom-pop">--}}
{{--                <div onclick="togglePopup('#info-video')" class="close-btn">--}}
{{--                    <i class="fa fa-close"></i>--}}
{{--                </div><br><br>--}}
{{--                <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $info->video_id }}"></div>--}}
{{--            </div>--}}






{{--            <a class="venobox" data-vbtype="inline" href="#inline"><i class="fa fa-play"></i></a>--}}
{{--            <div id="inline" style="display: none;">--}}
{{--                <div class="playerH" data-plyr-provider="vimeo" data-plyr-embed-id="{{ $info->video_id }}"></div>--}}
{{--            </div>--}}
        @endif
{{--        <a href="{{$info->video ?? ''}}" data-autoplay="true" data-vbtype="video" class="venobox">--}}
{{--            <i class="fa fa-play"></i>--}}
{{--        </a>--}}
        {{--  <a href="{{$info->twitter ?? ''}}" target="_blank">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="{{$info->facebook ?? ''}}" target="_blank">
            <i class="fab fa-facebook-f"></i>
        </a>  --}}
    </div>


    <!--======================== start search popup =============================-->
    <div class="search-popup search-popup__default" id="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <div class="search-popup__content">
            <div class="aws-container" data-url="/themes/agrikon/?wc-ajax=aws_action" data-siteurl="https://ninetheme.com/themes/agrikon" data-lang="" data-show-loader="true" data-show-more="true" data-show-page="true" data-show-clear="true" data-mobile-screen="false"
                data-use-analytics="false" data-min-chars="1" data-buttons-order="1" data-is-mobile="false" data-page-id="4016" data-tax="">
                <form class="aws-search-form aws-show-clear" action="{{ route('search') }}" method="get" role="search">
                    @method('GET')
                    <div class="aws-wrapper">
                        <label style="position:absolute !important;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" class="aws-search-label" for="6054afa526acc">Search</label>
                        <input type="search" name="search" id="6054afa526acc" value="" class="aws-search-field" placeholder="@lang('lang.search_in_courses')" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--======================== End search popup =============================-->

    <script src="https://player.vimeo.com/api/player.js"></script>
    <script src="{{asset('site/vendor/js/jquery-1.11.0.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/wow.min.js')}}"></script>

    <script src="{{asset('site/vendor/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/intlTelInput-jquery.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/jquery.sortable.min.js')}}"></script>
    <script src="{{asset('site/vendor/js/jquery.lazyload.js')}}"></script>
    <!--<script src="{{asset('site/js/html2canvas.min.js')}}"></script>-->
    <!--<script src="{{asset('site/js/three.min.js')}}"></script>-->
    <!--<script src="{{asset('site/js/pdf.min.js')}}"></script>-->
    <!--<script src="{{asset('site/js/3dflipbook.min.js')}}"></script>-->
    <script type="text/javascript" src="{{asset('site/js/pdf.combined.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('site/js/wow_book.min.js')}}"></script>

    <script src="{{asset('site/js/plyr.js')}}"></script>
    <script src="{{asset('site/js/main.js')}}"></script>
    <script src="{{asset('site/vendor/js/venobox.min.js')}}"></script>

    <script>
        function togglePopup(id) {
            $(id).toggle();
        }
    $(document).ready(function () {

        // $("body").bind("DOMNodeInserted", function() {
        //     $(this).find('.venoframe').addClass('plyr__video-embed').attr('id', 'player');
        //
        // });
        // $('.venoframe').parent().addClass('plyr__video-embed');


            $('.venobox').venobox({
                cb_post_open: function (data, instance) {
                    if (data.trigger && data.trigger.is('[data-vbtype="iframe"]')) {
                        const videoUrl = data.trigger.attr('href');
                        const iframe = document.createElement('iframe');
                        iframe.src = videoUrl.replace('watch?v=', 'embed/');
                        iframe.width = '100%';
                        iframe.height = '100%';
                        iframe.allowfullscreen = true;

                        $('.vbox-content').html(iframe);

                        const videoPlayer = new Plyr(iframe, {
                            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
                        });
                    }
                }
            });
        });



document.addEventListener('DOMContentLoaded', () => {


  const players = Array.from(document.querySelectorAll('.playerH'));

  players.forEach(function(player) {
    player = new Plyr(player, {
      //debug:true,
      autoplay: false,
      ratio: '16:9',
      defaultQuality: '720',
    //   poster: "http://www.clair-obscur.ch/2004/images/PLEIX_Itsu.jpg"
    })
    var test = jQuery(player).attr('class');
    var container = jQuery(player.media).parents('.video_container');
    var image = container.attr('data-plyr-poster');

    window.addEventListener("load", function() {
      setTimeout(() => {
        container.find('.plyr__poster').css({
          'background-image':'url('+image+')'
        });
        container.css({opacity:1});
      }, 1000);
		})

    jQuery('.button').on('click',function(){
      player.pause();
    });
  });


});



    </script>
    @include('shared.toastr')
    @include('site.includes.cart_js')
    @yield('js')
</body>

</html>
