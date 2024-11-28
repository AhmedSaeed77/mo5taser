@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="row">
                        <div class="col-sm-12">
                            <ol class="breadcrumb">
                                <li>
                                    <a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
                                </li>
                                <li class="active">
                                    @lang('lang.passed_exam')
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.passed_exam') </b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.questions_number')</th>
                                            <th class="text-center">@lang('lang.exam_time')</th>
                                            <th class="text-center">@lang('lang.attemps')</th>
                                            <th class="text-center">@lang('lang.teacher')</th>
                                            <th class="text-center">@lang('lang.main_cat')</th>
                                            <th class="text-center">@lang('lang.level')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($passes->count() > 0)
                                                @foreach ($passes as $key => $passe)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$passe->questions_number}}</td>
                                                        <td class="text-center">{{$passe->exam_time}}</td>
                                                        <td class="text-center">{{$passe->attemps}}</td>
                                                        <td class="text-center">{{$passe->teacher->name ?? '--'}}</td>
                                                        <td class="text-center">{{$passe->mainCat->title ?? '--'}}</td>
                                                        <td class="text-center">{{$passe->levelCat->title ?? '--'}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('exam.questions',[$passe->teacher_id,$passe->id])}}">
                                                                <button type="button" class="btn btn-info  waves-effect waves-light" aria-expanded="false">@lang('lang.questions')</button>
                                                            </a>
                                                            <a href="{{route('students_attempts',$passe->id)}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.students_attempts')</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->

        </div> <!-- content -->
</div>
@endsection

@section('js')
    @include('dashboard.includes.datatable_js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
                var table = $('#datatable-fixed-col').DataTable({
                    scrollY: "300px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedColumns: {
                        leftColumns: 1,
                        rightColumns: 1
                    }
                });
        });
    </script>
@endsection

