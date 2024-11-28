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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.join_teacher')</b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.name')</th>
                                            <th class="text-center">@lang('lang.email')</th>
                                            <th class="text-center">@lang('lang.status')</th>
                                            <th class="text-center">@lang('lang.cv')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($joins->count() > 0)
                                                @foreach ($joins as $key => $join)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$join->name}}</td>
                                                        <td class="text-center">{{$join->email}}</td>
                                                        <td class="text-center">
                                                            @if($join->status === 'unread')
                                                            <strong style="color: red">@lang('lang.unread')</strong>
                                                            @else
                                                            <strong style="color: green">@lang('lang.read')</strong>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{asset($join->cv)}}" target="_blank">@lang('lang.show')</a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('join.show' ,$join->id )}}">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">@lang('lang.show')</button>
                                                            </a>

                                                            <button class="btn btn-danger modal_btn" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$join->id}}"> @lang('lang.delete') </button>

                                                             {{--  modal  --}}
                                                                <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                            </div>
                                                                            <form action="{{route('join.destroy',$join->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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

