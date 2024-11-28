@extends('dashboard.includes.app')


@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                        <div class="col-md-6 col-lg-4">
                    @else
                        <div class="col-md-4">
                    @endif
                        <div class="widget-bg-color-icon card-box fadeInDown animated">
                            <div class="bg-icon bg-icon-info pull-left">
                                <i class="md md-attach-money text-info"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-dark">
                                    @php
                                        $courses = \App\Models\Course::withoutGlobalScope(\App\Scopes\ActiveScope::class)->get();
                                        $teacher_courses = [];
                                        $courses_ids = [];
                                        foreach ($courses as $key => $course) {
                                            $teachers = $course->teachers->pluck('id')->toArray();
                                            if(in_array(auth('admin')->id(),$teachers)){
                                                array_push($teacher_courses,$course);
                                                array_push($courses_ids,$course->id);
                                            }
                                        }
                                    @endphp
                                    @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                                    <b class="counter">{{count(\App\Models\Subscribe::get())}}</b>
                                    @endif
                                    @if (auth('admin')->user()->role_id == 3)
                                    @php
                                    $ids_techs = [];
                                        foreach ($teacher_courses as $key => $tech) {
                                                array_push($ids_techs,$tech->id);
                                        }

                                    @endphp
                                    <b class="counter">{{count(\App\Models\Subscribe::get())}}</b>
                                    @endif
                                </h3>
                                <p><b>@lang('lang.subscribers')</b></p>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                    <div class="col-md-6 col-lg-4">
                    @else
                    <div class="col-md-4">
                    @endif
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-success pull-left">
                                <i class="md md-person text-pink"></i>
                            </div>
                            <div class="text-right">
                                @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                                <h3 class="text-dark"><b class="counter">
                                    {{count(\App\Models\User::where('role_id' , 4)->get())}}</b></h3>
                                <p><b>@lang('lang.students_count')</b></p>
                                @endif
                                @if (auth('admin')->user()->role_id == 3)
                                <h3 class="text-dark"><b class="counter">{{count(\App\Models\Subscribe::whereIn('course_id' , $ids_techs)->get())}}</b></h3>
                                <p><b>@lang('lang.students_count')</b></p>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                    <div class="col-md-6 col-lg-4">
                    @else
                    <div class="col-md-4">
                    @endif
                        <div class="widget-bg-color-icon card-box">
                            <div class="bg-icon bg-icon-primary pull-left">
                                <i class="md md-message text-purple"></i>
                            </div>
                            <div class="text-right">
                                @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                                <h3 class="text-dark"><b class="counter">{{count(\App\Models\Contact::where('status' , 'unread')->get())}}</b></h3>
                                <p><b>@lang('lang.unread_contacts_msg')</b></p>
                                @endif
                                 @if (auth('admin')->user()->role_id == 3)
                                <h3 class="text-dark"><b class="counter">{{count($teacher_courses)}}</b></h3>
                                <p><b>@lang('lang.your_courses')</b></p>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (auth('admin')->user()->role_id == 1 || auth('admin')->user()->role_id == 2)
                    <div class="col-lg-12">
                    @endif
                         @if (auth('admin')->user()->role_id == 3)
                        <div class="col-lg-12">
                        @endif
                        <div class="card-box">
                            <h4 class="text-dark header-title m-t-0">@lang('lang.courses_subscribtion_analytics')</h4>
                            <div class="text-center">
                                <ul class="list-inline chart-detail-list">
                                    <li>
                                        <h5><i class="fa fa-circle m-r-5" style="color: #5fbeaa;"></i>@lang('lang.course_name')</h5>
                                    </li>
                                </ul>
                            </div>
                            <div id="morris-bar-stacked" style="height: 303px;"></div>
                        </div>
                    </div>



                </div>

            </div> <!-- container -->

        </div> <!-- content -->

    </div>

    @php
    if (auth('admin')->user()->role->name == 'admin' || auth('admin')->user()->role->name == 'super_admin')
    {
        $courses = \App\Models\Course::get()->pluck('title')->toArray();
        $courses_data = \App\Models\Course::get();
        $subscribes = [];

        foreach ($courses_data as $item){
            $sub = \App\Models\Subscribe::where([
                'course_id' => $item->id
            ])->get()->count();

            array_push($subscribes,$sub);
        }
    }

    if (auth('admin')->user()->role->name == 'teacher')
    {
        $courses = \App\Models\Course::whereIn('id',$ids_techs)->get()->pluck('title')->toArray();
        $courses_data = \App\Models\Course::whereIn('id',$ids_techs)->get();
        $subscribes = [];

        foreach ($courses_data as $item){
            $sub = \App\Models\Subscribe::where([
                'course_id' => $item->id
            ])->get()->count();

            array_push($subscribes,$sub);
        }
    }



    @endphp
@endsection

@section('js')
<script>
    $(() => {
        /**
 * Theme: Ubold Admin Template
 * Author: Coderthemes
 * Morris Chart
 */

! function($) {
    "use strict";

    var Dashboard1 = function() {
        this.$realData = []
    };

    //creates Stacked chart
    Dashboard1.prototype.createStackedChart = function(element, data, xkey, ykeys, labels, lineColors) {
            Morris.Bar({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                stacked: true,
                labels: labels,
                hideHover: 'auto',
                resize: true, //defaulted to true
                gridLineColor: '#eeeeee',
                barColors: lineColors
            });
        },

        //creates area chart with dotted
        Dashboard1.prototype.createAreaChartDotted = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, Pfillcolor, Pstockcolor, lineColors) {
            Morris.Area({
                element: element,
                pointSize: 0,
                lineWidth: 0,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                pointFillColors: Pfillcolor,
                pointStrokeColors: Pstockcolor,
                resize: true,
                gridLineColor: '#eef0f2',
                lineColors: lineColors
            });

        },


        Dashboard1.prototype.init = function() {
            var cours = @json($courses);
            var subscribes_vals = @json($subscribes);
            var $stckedData  = [];

            //creating Stacked chart
            for (let i = 0; i < cours.length; i++) {
                $stckedData.push({ y: cours[i], a: subscribes_vals[i]},);
            }

             this.createStackedChart('morris-bar-stacked', $stckedData, 'y', ['a'], ['عدد المشتركين'], ['#5fbeaa']);

            //creating area chart
            var $areaDotData = [
                { y: '2009', a: 10, b: 20, c: 30 },
                { y: '2010', a: 75, b: 65, c: 30 },
                { y: '2011', a: 50, b: 40, c: 30 },
                { y: '2012', a: 75, b: 65, c: 30 },
                { y: '2013', a: 50, b: 40, c: 30 },
                { y: '2014', a: 75, b: 65, c: 30 },
                { y: '2015', a: 90, b: 60, c: 30 }
            ];
            //this.createAreaChartDotted('morris-area-with-dotted', 0, 0, $areaDotData, 'y', ['a', 'b', 'c'], ['Desktops ', 'Tablets ', 'Mobiles '], ['#ffffff'], ['#999999'], ['#5fbeaa', '#5d9cec', '#ebeff2']);

        },
        //init
        $.Dashboard1 = new Dashboard1, $.Dashboard1.Constructor = Dashboard1
}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Dashboard1.init();
}(window.jQuery);

    });
</script>
@endsection
