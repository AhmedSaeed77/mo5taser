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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.why_us')</b></h4>
                                    @if($whys->count() < 4)
                                        <div class="font-13 m-b-30 text-right">
                                            <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                        </div>
                                    @endif
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title_ar')</th>
                                            <th class="text-center">@lang('lang.title_en')</th>
                                            <th class="text-center">@lang('lang.content_ar')</th>
                                            <th class="text-center">@lang('lang.content_en')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($whys->count() > 0)
                                                @foreach ($whys as $key => $why)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{$why->title_ar}}</td>
                                                        <td class="text-center">{{$why->title_en}}</td>
                                                        <td class="text-center">
                                                            {!! \Illuminate\Support\Str::limit($why->content_ar, 50, '') !!}
                                                        </td>
                                                        <td class="text-center">
                                                            {!! \Illuminate\Support\Str::limit($why->content_en, 50, '') !!}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('why-us.edit' ,$why->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>

                                                            <button class="btn btn-danger modal_btn" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$why->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('why-us.destroy',$why->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                <form action="{{ route('why-us.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.title_ar')</label>
                                    <input type="text" class="form-control" id="field-1"name="title_ar"
                                    placeholder="@lang('lang.title_ar')" required value="{{ old('title_ar') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.title_en')</label>
                                    <input type="text" class="form-control" id="field-1"name="title_en"
                                    placeholder="@lang('lang.title_en')" required value="{{ old('title_en') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group no-margin">
                                    <label for="field-7" class="control-label">@lang('lang.content_ar')</label>
                                    <textarea class="form-control autogrow" id="field-7" name="content_ar"
                                    placeholder="@lang('lang.content_ar')" required
                                    style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_ar') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group no-margin">
                                    <label for="field-7" class="control-label">@lang('lang.content_en')</label>
                                    <textarea class="form-control autogrow" id="field-7" name="content_en"
                                    placeholder="@lang('lang.content_en')" required
                                    style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_en') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
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
            $('.modal_btn').on('click', function (event) {
                var id = $(this).data('id');
                $('#userForm').attr("action", "{{ url('/admin/why-us') }}" + "/" + id);
            })
        });
    </script>
@endsection

