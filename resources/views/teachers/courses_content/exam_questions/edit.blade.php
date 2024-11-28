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
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
                                </li>
                                <li>
                                    <a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a>
                                </li>
                                <li>
                                    <a href="{{route('course-units',$content->course_id)}}">@lang('lang.units')</a>
                                </li>
                                <li>
                                    <a href="{{route('content-courses.show',$content->parent->parent->id)}}">@lang('lang.course_content')</a>
                                </li>
                                <li>
                                    <a href="{{route('content.questions',$question->content_id)}}">@lang('lang.questions')</a>
                                </li>
                                <li class="active">
                                    @lang('lang.question_edit')
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <h4 class="m-t-0 header-title"><b>@lang('lang.question_edit')</b></h4>

                                <div class="add_content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($question->type === 'multi_choice')
                                                @include('teachers.courses_content.exam_questions.questions.multi_choice_edit')
                                            @elseif($question->type === 'true_false')
                                                @include('teachers.courses_content.exam_questions.questions.true_false_edit')
                                            @elseif($question->type === 'textual')
                                                @include('teachers.courses_content.exam_questions.questions.textual_edit')
                                            @elseif($question->type === 'matching')
                                                @include('teachers.courses_content.exam_questions.questions.matching_edit')
                                            @endif
                                        </div>
                                    </div>
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
                    //height: 100,
                    // Update the ACF configuration with MathML syntax.
                    extraAllowedContent: mathElements.join( ' ' ) + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)',
                })
            });

        }() );
    </script>
    <script src="{{asset('dashboard/js/jquery.sortable.min.js')}}"></script>
<script>
        $('.matching_answers').sortable({
            placeholderClass: 'list-group-item',
            items: ':not(.disabled)'
        });
        let quesNum = @json(sizeOf($questions));
        $("#add_btn").on('click', function() {
            quesNum += 1;
            $(".matching_questions").append(`
                <div class="form-group" data-num="${quesNum}">
                    <span class="num">${quesNum}</span>
                    <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="${quesNum}" required>
                </div>
            `)

            $(".matching_answers").append(`
                <div class="form-group" data-num="${quesNum}">
                    <input type="hidden" value="${quesNum}">
                    <span class="num">${quesNum}</span>
                    <input type="text" class="form-control" placeholder="@lang('lang.answer')" required>
                </div>
            `)
            $('.matching_answers').sortable({
                placeholderClass: 'list-group-item',
                items: ':not(.disabled)'
            });
        })

        $("#delete_btn").on('click', function() {
            $(`.matching_questions div[data-num=${quesNum}]`).remove();
            $(`.matching_answers div[data-num=${quesNum}]`).remove();
            if(quesNum >= 1){
                quesNum -= 1;
            }
        })



</script>

<script>
        $("#form_matching").on('submit',function(e){

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

