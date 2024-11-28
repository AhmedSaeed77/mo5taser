@extends('site.includes.master')
@section('content')

<!--========================== Start page header =============================-->
<div class="breadcrumbs wow animate__animated animate__fadeInUp">
    <div class="container">
        <a href="{{route('home')}}" class="home">@lang('lang.home')</a>
        <span class="break">/</span>
        <span class="current">@lang('lang.general_exams')</span>
    </div>
</div>
<!--========================== End page header =============================-->

<!--========================== Start general exams page =============================-->
<section class="general_exams_page mt-40 mb-40 wow animate__animated animate__fadeInUp">
    <div class="container">
        <h4 class="heading_2 mb-30">@lang('lang.general_exams')</h4>
        <div class="row">
            <div class="col-lg-3">
                <div class="exams_card sticky">
                    <h5 class="head">@lang('lang.exams_departments')</h5>
                    <ul>
                        @if ($categories->count() > 0)
                            @foreach ($categories as $key => $category)
                                <li class="mou_tab {{$key == 0 ? 'active' : ''}}" data-content="section_{{$key}}">{{$category->title}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 mt-md-30">
                <div class="main_content">
                    @if ($categories->count() > 0)
                        <div class="row">
                            @foreach ($categories as $key => $category)
                                    @foreach ($category->childs as $index => $item)

                                        @if($item->passExam)

                                            @php
                                                $nquestions = \App\Models\Question::where('exam_id',$item->passExam->id)->get()->count();
                                            @endphp
                                            @if($item->passExam->questions_number == $nquestions)
                                            <div class="box_content {{$key == 0 ? 'active' : ''}} col-md-4 col-sm-6 main_box section_{{$key}}">

                                                    <div class="box_Gexam">
                                                        <div class="image"><img src="{{$item->image}}" alt=""></div>
                                                        <div class="info">
                                                            <h6 class="name text-ellipsis">{{$item->title}}</h6>
                                                            @if($item->passExam)
                                                                <div class="details">
                                                                    <div class="details_row">
                                                                        <div class="item">
                                                                            <span class="icon"><i class="fal fa-redo"></i></span>
                                                                            <span class="text">{{$item->passExam->attemps}} @lang('lang.attemps')</span>
                                                                        </div>
                                                                        <div class="item">
                                                                            <span class="icon"><i class="fal fa-file-alt"></i></span>
                                                                            <span class="text">{{$item->passExam->questions_number}} @lang('lang.nquestions')</span>
                                                                        </div>
                                                                    </div>
                                                                    @if($item->passExam->exam_time)
                                                                    <div class="details_row">
                                                                        <div class="item">
                                                                            <span class="icon"><i class="fal fa-clock"></i></span>
                                                                            <span class="text">{{$item->passExam->exam_time}} @lang('lang.mins')</span>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <a href="{{route('enter_exam',$item->passExam->id)}}" class="main-btn trans w-100">@lang('lang.try_attemp')</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                        @endif

                                    @endforeach
                        @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--========================== End general exams page =============================-->

@endsection

@section('js')
    <script>
        $(function () {
            $(document).on('click', '.mou_tab', function () {
                $('.mou_tab').removeClass('active');
                $('.main_box').removeClass('active');
                $(this).addClass('active');
                $('.' + $(this).attr('data-content')).addClass('active');
            });
            $('.mou_tab').each(function (i, value) {
                if (! $('.' + $(this).attr('data-content'))[0]) {
                    console.log('.' + $(this).attr('data-content'));

                    $('[data-content=' + $(this).attr('data-content') +']').remove();
                }
            })
            // for (i = 0; i <= $('.mou_tab').length; i++) {
            //     console.log($('.' + $('.mou_tab')[i].attr('data-content')));
            //     // if (! $('.' + $('.mou_tab')[i].attr('data-content'))) {
            //     //     $('[data-content=' + $('.mou_tab')[i].attr('data-content') +']').remove();
            //     // }
            // }
        });
    </script>
@endsection
