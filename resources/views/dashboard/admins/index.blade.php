@extends('dashboard.includes.app')
@section('css')
    @include('dashboard.includes.datatable')
@endsection
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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.teachers') & @lang('lang.admins')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <a href="{{route('admins.create')}}">
                                            <button class="btn btn-success waves-effect waves-light">@lang('lang.create')</button>
                                        </a>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.name')</th>
                                            <th class="text-center">@lang('lang.email')</th>
                                            <th class="text-center">@lang('lang.phone')</th>
                                            <th class="text-center">@lang('lang.user_type')</th>
                                            <th class="text-center">@lang('lang.activation')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($admins->count() > 0)
                                                @foreach ($admins as $key => $admin)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$admin->name}}</td>
                                                        <td class="text-center">{{$admin->email}}</td>
                                                        <td class="text-center">{{$admin->phone}}</td>
                                                        <td class="text-center">{{$admin->type}}</td>
                                                        <td class="text-center">{{$admin->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                                                        <td class="text-center">
                                                            @if($admin->role_id != 1)
                                                            <a href="{{route('admins.edit' ,$admin->id )}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                                @if($admin->id != auth()->id())
                                                                <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                 data-id="{{$admin->id}}"> @lang('lang.delete') </button>

                                                                {{--  modal  --}}
                                                            <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                        </div>
                                                                        <form action="{{route('admins.destroy' ,$admin->id )}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                                                                @endif
                                                            @endif
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
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">@lang('lang.delete')</h4>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="userForm">
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
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
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

