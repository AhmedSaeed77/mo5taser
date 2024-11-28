@extends('dashboard.includes.app')
@include('dashboard.includes.datatable')
@section('contnet')
<div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.passed_contests') </b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

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
                                                            <a href="{{route('pass-contest.edit' ,$passe->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                            data-id="{{$passe->id}}"> @lang('lang.delete') </button>

                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('pass-contest.destroy' ,$passe->id )}}" method="POST" enctype="multipart/form-data" id="userForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                                <div class="modal-body text-center">
                                                                                    <div class="alert alert-danger">
                                                                                    <h3>@lang('lang.confirm_delete')</h3>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"> @lang('lang.close') </button>
                                                                                    <button type="submit" class="btn btn-danger pull-right"> @lang('lang.delete') </button>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
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

    {{--  modal  --}}
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('lang.create')</h4>
                </div>
                <form action="{{ route('pass.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.questions_number')</label>
                                    <input type="number" min="1" class="form-control" id="field-1"name="questions_number"
                                    placeholder="@lang('lang.questions_number')" required value="{{ old('questions_number') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.exam_time')</label>
                                    <input type="number" min="1" class="form-control" id="field-1"name="exam_time"
                                    placeholder="@lang('lang.exam_time')" value="{{ old('exam_time') }}">
                                    <span style="color: red">@lang('lang.optional')</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.attemps')</label>
                                    <input type="number" min="1" max="1" class="form-control" id="field-1" name="attemps"
                                    placeholder="@lang('lang.attemps')" value="1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.teacher')</label>
                                    <select class="form-control" name="teacher_id" required>
                                        <option value="">@lang('lang.choose')</option>
                                        @if($teachers->count() > 0)
                                            @foreach ($teachers as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.main_cat')</label>
                                    <select class="form-control" name="main_cat" required id="department">
                                        <option value="">@lang('lang.choose')</option>
                                        @if($main_categories->count() > 0)
                                            @foreach ($main_categories as $item_cat)
                                                <option value="{{$item_cat->id}}">{{$item_cat->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.level')</label>
                                    <select class="form-control" name="level" id="level" required>
                                        <option value="">@lang('lang.choose')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="lang" value="{{Config::get('app.locale')}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('lang.close')</button>
                        <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  modal  --}}

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
    <script>
        $(document).ready(function(){
            // get levels related with department

            $('#department').on('change',function(e) {
                var department_id = e.target.value;
                var lang = $("#lang").val();
                $.ajax({
                      url:"{{ route('get_levels') }}",
                      type:"POST",
                      data: {
                           department_id: department_id,
                           _token: '{!! csrf_token() !!}',
                       },
                      success:function (data) {
                           $('#level').empty();

                           if(data.length == 0){
                               $('#level').append('<option value="">'+"@lang('lang.not_found_level')"+'</option>');
                           }
                           else{

                             $.each(data,function(index,level){
                                 if(lang == 'ar')
                                 {
                                   $('#level').append('<option value="'+level.id+'">'+level.title_ar+'</option>');
                                 }
                                 if(lang == 'en')
                                 {
                                   $('#level').append('<option value="'+level.id+'">'+level.title_en+'</option>');
                                 }

                               })
                           }

                      }
                })
           });
        });
    </script>
@endsection

