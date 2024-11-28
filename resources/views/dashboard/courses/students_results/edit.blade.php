@extends('dashboard.includes.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
        type="text/css" />

@endsection

@section('contnet')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title"> @lang('lang.students_results') -- {{$course->title}} </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <form action="{{ route('students_results.update',$result->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{ method_field('PUT') }}
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.student_name')</label>
                                                            <input type="text" class="form-control" id="field-1"name="student_name"
                                                            placeholder="@lang('lang.student_name')" required value="{{ $result->student_name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="field-1" class="control-label">@lang('lang.image')</label>
                                                            <input type="file" class="form-control" id="field-1"name="image" accept="image/*">
                                                            <br>
                                                            <span><img src="{{ asset('' . $result->image) }}"
                                                                    style="width:70px; height:70px;"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="course_id" value="{{$result->course_id}}">
                                            <div class="form-group text-right m-b-0">
                                                <button class="btn btn-default waves-effect waves-light" type="submit">
                                                    @lang('lang.update')
                                                </button>
                                            </div>
                                        </form>
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
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        var lang = $("#local").val();
        $("#teachers").select2({
            placeholder: lang == 'ar' ? 'اختر المعلم' : 'select teacher',
            allowClear: true
        });
    </script>
    <script>
        CKEDITOR.replace('markdownckeditor');
    </script>
@endsection
