<footer class="footer text-right">

    <div class="ryad-logo" style="
        display: inline-block;
        height: 48px;
        position: absolute;
        right: 0px;
        top: -18%;
    ">
        <a target="_balnk" href="https://elryad.com/ar/" title="تصميم مواقع" style="color:#000">
            <svg height="90" width="102" style=" transform: rotateY(180deg) scale(.35);float: left;width: 77px;">
                <line x1="0" y1="0" x2="90" y2="0" style="stroke:#f00;stroke-width:35" />
                <line x1="100" y1="0" x2="0" y2="10" style="stroke:#f00;stroke-width:20; transform:rotate(40deg)" />
                <line x1="10" y1="95" x2="50" y2="45" style="stroke:#f00;stroke-width:20;" />
            </svg>
        </a>
        <div class="lolo-co" style="float: right;text-align: left;padding-top: 30px;position: relative;left: -15px;">
            <a target="_balnk" href="https://elryad.com/ar/" title="تصميم مواقع" style="color:#000;text-decoration: none;">
                <p style="text-transform: uppercase;font-family: sans-serif;font-size: 24px;line-height: 0.7;margin: 0;font-weight: 700;">elryad</p>
            </a>
            <span style="font-size: 12px;font-family: sans-serif; color:#000;">
                <a target="_balnk" href="https://elryad.com/ar/" title="تصميم مواقع" alt="تصميم مواقع" style="font-size: 12px; font-family: sans-serif; color:inherit;text-decoration: none;">تصميم مواقع </a> /
                <a target="_balnk" href="https://elryad.com/ar/برمجة-تطبيقات-الجوال/" title="تطبيقات" alt="تطبيقات" style="font-size: 12px; font-family: sans-serif; color:inherit;text-decoration: none;">تطبيقات</a>
            </span>
        </div>
    </div>
    <span style="font-size: 12px; color: black; font-weight: bold;">All rights reserved © 2022</span>

</footer>

</div>

<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{asset('dashboard/js/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="{{asset('dashboard/js/bootstrap-rtl.min.js')}}"></script>
<script src="{{asset('dashboard/js/detect.js')}}"></script>
<script src="{{asset('dashboard/js/fastclick.js')}}"></script>

<script src="{{asset('dashboard/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('dashboard/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('dashboard/js/waves.js')}}"></script>
<script src="{{asset('dashboard/js/wow.min.js')}}"></script>
<script src="{{asset('dashboard/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('dashboard/js/jquery.scrollTo.min.js')}}"></script>

<script src="{{asset('dashboard/plugins/peity/jquery.peity.min.js')}}"></script>

<!-- jQuery  -->
<script src="{{asset('dashboard/plugins/waypoints/lib/jquery.waypoints.js')}}"></script>
{{--  <script src="{{asset('dashboard/plugins/counterup/jquery.counterup.min.js')}}"></script>  --}}



<script src="{{asset('dashboard/plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('dashboard/plugins/raphael/raphael-min.js')}}"></script>

<script src="{{asset('dashboard/plugins/jquery-knob/jquery.knob.js')}}"></script>

{{--  <script src="{{asset('dashboard/pages/jquery.dashboard.js')}}"></script>  --}}


<script src="{{asset('dashboard/js/jquery.core.js')}}"></script>
<script src="{{asset('dashboard/js/jquery.app.js')}}"></script>

{{--  <script src="{{asset('js/app.js')}}"></script>  --}}

<script>
    @if(count($errors) > 0)
    @foreach($errors->all() as $error)
    toastr.error("{{ $error }}");
    @endforeach
    @endif
</script>
@include('shared.toastr')
@yield('js')

{{--  <script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });
        $(".knob").knob();

    });
</script>  --}}
{{--  <script>
    $('button').dblclick(function(e){
        e.preventDefault();
      });
</script>  --}}

</body>
</html>
