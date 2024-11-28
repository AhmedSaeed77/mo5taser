@extends('dashboard.includes.app')
@section('css')
<link href="{{asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

<style>
    .cke_reset_all{
        display: none !important;
    }
    .cke_1.cke.cke_reset.cke_chrome{
        width: 100%;
        pointer-events: none;
    }
</style>
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
                                <a href="{{route('students_answers',$answer->attemp_id)}}">@lang('lang.show_student_answers')</a>
                            </li>
                            <li class="active">
                                @lang('lang.student_answer')
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <h4 class="m-t-0 header-title"><b>@lang('lang.student_answer')</b></h4>

                                <div class="add_content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($answer->question->type === 'multi_choice')
                                                @include('teachers.passed_exams.student_results.questions.multi_choice')
                                            @elseif($answer->question->type === 'true_false')
                                                @include('teachers.passed_exams.student_results.questions.true_false')
                                            @elseif($answer->question->type === 'textual')
                                                @include('teachers.passed_exams.student_results.questions.textual')
                                            @elseif($answer->question->type === 'matching')
                                                @include('teachers.passed_exams.student_results.questions.matching')
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

            CKEDITOR.replace( 'ckeditor1', {
                extraPlugins: 'ckeditor_wiris',
                // For now, MathType is incompatible with CKEditor 4 file upload plugins.
                removePlugins: 'filetools,uploadimage,uploadwidget,uploadfile,filebrowser,easyimage',
                height: 100,
                // Update the ACF configuration with MathML syntax.
                extraAllowedContent: mathElements.join( ' ' ) + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
            } );
            CKEDITOR.replace( 'ckeditor2', {
                extraPlugins: 'ckeditor_wiris',
                // For now, MathType is incompatible with CKEditor 4 file upload plugins.
                removePlugins: 'filetools,uploadimage,uploadwidget,uploadfile,filebrowser,easyimage',
                height: 100,
                // Update the ACF configuration with MathML syntax.
                extraAllowedContent: mathElements.join( ' ' ) + '(*)[*]{*};img[data-mathml,data-custom-editor,role](Wirisformula)'
            } );
        }() );
    </script>
@endsection

