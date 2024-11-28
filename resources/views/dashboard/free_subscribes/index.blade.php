@extends('dashboard.includes.app')

@section('css')
    <link href="{{ asset('site/css/select2.css')}}" rel="stylesheet" />
    <link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
        type="text/css" />

@endsection

@section('contnet')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title"> @lang('lang.free_subscribe')  -- {{$course->title}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <form action="{{ route('free-subscribe.update',$course->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            {{ method_field('PUT') }}
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('lang.users')</label>
                                                    <select class="form-control select2" name="users[]" required id="users" multiple>
                                                        @foreach ($users as $key => $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }} -- ({{$user->email}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-default waves-effect waves-light" type="submit">
                                                        @lang('lang.submit')
                                                    </button>
                                                </div>
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
    <input type="hidden" id="local" value="{{app()->getLocale()}}">
@endsection

@section('js')
    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>
    <script src="{{ asset('site/js/select2.js')}}"></script>

    <script type="text/javascript">
        var lang = $("#local").val();
        $("#users").select2({
            placeholder: lang == 'ar' ? 'اختر الطلاب' : 'select a student',
            allowClear: true
        });
    </script>
@endsection
