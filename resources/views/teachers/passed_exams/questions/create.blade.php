@extends('dashboard.includes.app')
@section('css')
<link href="{{asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
@endsection
@section('contnet')
<div class="content-page add_question_page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
                            </li>
                            <li>
                                <a href="{{route('passed-exams.index')}}">@lang('lang.passed_contest_exam')</a>
                            </li>
                            <li>
                                <a href="{{route('exam.questions',[$exam->teacher_id,$exam->id])}}">@lang('lang.questions')</a>
                            </li>
                            <li class="active">
                                @lang('lang.add_questions_level')
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <h4 class="m-t-0 header-title"><b>@lang('lang.questions')</b></h4>
                                <div class="box_title">
                                    <p>@lang('lang.add_questions_level') ({{$exam->mainCat->title}})</p>
                                    <p>@lang('lang.in_level') ({{$exam->levelCat->title}})</p>
                                </div>
                                <div class="details">
                                    <div class="item">
                                        <span>--</span>
                                        <span class="name">@lang('lang.questions_number') :</span>
                                        <span class="value">({{$exam->questions_number}})</span>
                                    </div>
                                    @if($exam->exam_time)
                                        <div class="item">
                                        <span>--</span>
                                            <span class="name">@lang('lang.exam_time') :</span>
                                            <span class="value">({{$exam->exam_time}}) @lang('lang.mins')</span>
                                        </div>
                                    @endif
                                    <div class="item">
                                    <span>--</span>
                                        <span class="name">@lang('lang.added_questions') ({{$questions}}) @lang('lang.question')</span>
                                    </div>
                                    <div class="item">
                                    <span>--</span>
                                        <span class="name">@lang('lang.rest') ({{$exam->questions_number - $questions}}) @lang('lang.question')</span>
                                    </div>
                                </div>
                                <div class="add_content">
                                    @if($exam->questions_number - $questions > 0)
                                        <h4>@lang('lang.choose_question_type')</h4>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="panel panel-default">
                                                    <div class="panel-body">
                                                        <ul class="nav nav-pills m-b-30">
                                                            <li class="active">
                                                                <a href="#navpills-11" data-toggle="tab" aria-expanded="true">@lang('lang.multi_choice')</a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#navpills-21" data-toggle="tab" aria-expanded="false">@lang('lang.true_or_false')</a>
                                                            </li>
                                                            @if ($exam->childLevel->type != 'contest')
                                                            <li class="">
                                                                <a href="#navpills-31" data-toggle="tab" aria-expanded="false">@lang('lang.textual')</a>
                                                            </li>
                                                            <li class="">
                                                                <a href="#navpills-32" data-toggle="tab" aria-expanded="false">@lang('lang.matching')</a>
                                                            </li>
                                                            @endif
                                                        </ul>
                                                        <div class="tab-content br-n pn">
                                                            <div id="navpills-11" class="tab-pane active">
                                                                @include('teachers.passed_exams.questions.multi_choice')
                                                            </div>
                                                            <div id="navpills-21" class="tab-pane">
                                                                @include('teachers.passed_exams.questions.true_false')
                                                            </div>
                                                            @if ($exam->childLevel->type != 'contest')
                                                                <div id="navpills-31" class="tab-pane">
                                                                    @include('teachers.passed_exams.questions.textual')
                                                                </div>
                                                                <div id="navpills-32" class="tab-pane ">
                                                                    @include('teachers.passed_exams.questions.matching')
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="alert alert-danger">
                                                    <b>@lang('lang.limited_question')</b>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="lang" value="{{app()->getLocale()}}">
</div>

@endsection
@section('js')
<script src="{{asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js')}}"></script>
<script src="{{asset('dashboard/pages/jquery.bs-table.js')}}"></script>

<script>
    ( function() {
        var mathElements = [
            'math',
            'maction',
            'maligngroup',
            'malignmark',
            'menclose',
            'merror',
            'mfenced',
            'mfrac',
            'mglyph',
            'mi',
            'mlabeledtr',
            'mlongdiv',
            'mmultiscripts',
            'mn',
            'mo',
            'mover',
            'mpadded',
            'mphantom',
            'mroot',
            'mrow',
            'ms',
            'mscarries',
            'mscarry',
            'msgroup',
            'msline',
            'mspace',
            'msqrt',
            'msrow',
            'mstack',
            'mstyle',
            'msub',
            'msup',
            'msubsup',
            'mtable',
            'mtd',
            'mtext',
            'mtr',
            'munder',
            'munderover',
            'semantics',
            'annotation',
            'annotation-xml',
            'mprescripts',
            'none'
        ];

        $('.ckeditor').each( function () {

            CKEDITOR.replace( this.id , {

                extraPlugins: 'ckeditor_wiris',
                // For now, MathType is incompatible with CKEditor 4 file upload plugins.
                removePlugins: 'filetools,uploadimage,uploadwidget,uploadfile,filebrowser,easyimage',
                height: 100,
                // Update the ACF configuration with MathML syntax.
                extraAllowedContent: mathElements.join( ' ' ) + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
            })
        });
    }() );
</script>
<script src="{{asset('dashboard/js/jquery.sortable.min.js')}}"></script>
<script>
        let quesNum = 0;
        $("#add_btn").on('click', function() {
            quesNum += 1;
            $(".matching_questions").append(`
                <div class="form-group" data-num="${quesNum + 1}">
                    <span class="num">${quesNum + 1}</span>
                    <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="${quesNum + 1}" required>
                </div>
            `)

            $(".matching_answers").append(`
                <div class="form-group" data-num="${quesNum + 1}">
                    <input type="hidden" value="${quesNum + 1}">
                    <span class="num">${quesNum + 1}</span>
                    <input type="text" class="form-control" placeholder="@lang('lang.answer')" required>
                </div>
            `)
            $('.matching_answers').sortable({
                placeholderClass: 'list-group-item',
                items: ':not(.disabled)'
            });
        })

        $("#delete_btn").on('click', function() {
            $(`.matching_questions div[data-num=${quesNum + 1}]`).remove();
            $(`.matching_answers div[data-num=${quesNum + 1}]`).remove();
            if(quesNum >= 1){
                quesNum -= 1;
            }
        })



</script>

<script>
        $("#form_matching").on('submit',function(e){
                //e.preventDefault();
                var questionsArray = [];
                var answersArray = [];

                for (var i = 0; i <= $(".matching_questions").children().length -1; i++) {
                    var obj = {};
                    var quesContent = $(`.matching_questions input[data-value=${i + 1}]`).val();
                    obj['qn'] = i + 1;
                    obj['q'] = quesContent;
                    questionsArray.push(obj);
                }

                $(".matching_answers .form-group").each(function() {
                    var obj_2 = {};
                    var ansContent = $(this).find('.form-control').val();
                    var ansNum = $(this).data("num");
                    obj_2['an'] = ansNum;
                    obj_2['a'] = ansContent;
                    answersArray.push(obj_2);
                })

                let final = [];

                for (let i in questionsArray) {
                    let merged = {...questionsArray[i], ...answersArray[i]}
                    final.push( merged  )
                }
                $("#questions_value").val(JSON.stringify(final))
        })
</script>

{{--  get selected subject  --}}

<script>
    $('.subject_class').on('change',function(){
        var val = $(this).val();
        var lang = $('#lang').val();

        $.ajax({
            url:"{{route('get_subjects')}}",
            type:"POST",
            data: {
                 val: val,
                 _token: '{!! csrf_token() !!}',
             },
            success:function (data) {
                 $('.child_subject1_select1').empty();
                 $('.child_subject1_select2').empty();

                 if(data.length != 0){
                    $('.child_subject').removeClass('hidden');
                    $('.child_subject1').removeClass('hidden');
                    $('.child_subject1_select1').append('<option value="">'+"@lang('lang.choose')"+'</option>');
                    $.each(data,function(index,subject){
                        if(lang == 'ar')
                        {
                          $('.child_subject1_select1').append('<option value="'+subject.id+'">'+subject.name_ar+'</option>');
                        }
                        if(lang == 'en')
                        {
                          $('.child_subject1_select1').append('<option value="'+subject.id+'">'+subject.name_en+'</option>');
                        }

                      })
                 }
                 else
                 {
                    $('.child_subject').addClass('hidden');
                    $('.child_subject1').addClass('hidden');
                 }

            }
        })
    });

    $('.child_subject1_select1').on('change',function(){
        var val = $(this).val();
        var lang = $('#lang').val();

        $.ajax({
            url:"{{route('get_subjects')}}",
            type:"POST",
            data: {
                 val: val,
                 _token: '{!! csrf_token() !!}',
             },
            success:function (data) {
                 $('.child_subject1_select2').empty();

                 if(data.length != 0){
                    $('.child_subject').removeClass('hidden');
                    $('.child_subject2').removeClass('hidden');
                    $('.child_subject1_select2').append('<option value="">'+"@lang('lang.choose')"+'</option>');
                    $.each(data,function(index,subject){
                        if(lang == 'ar')
                        {
                          $('.child_subject1_select2').append('<option value="'+subject.id+'">'+subject.name_ar+'</option>');
                        }
                        if(lang == 'en')
                        {
                          $('.child_subject1_select2').append('<option value="'+subject.id+'">'+subject.name_en+'</option>');
                        }

                      })
                 }
                 else
                 {
                    $('.child_subject2').addClass('hidden');
                 }

            }
        })
    });
 </script>
{{--  end get selected subject  --}}


@endsection

