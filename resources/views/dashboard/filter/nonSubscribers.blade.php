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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.non_subscribers')</b></h4>
                                    <form action="{{route('admin.filter', 'nonSubscribers')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="field-1" class="control-label">@lang('lang.range')</label>
                                                    <select class="form-control" name="range">
                                                        <option {{ $data['range'] == '' ? 'selected' : '' }} value="" >@lang('lang.all')</option>
                                                        <option {{ $data['range'] == 'last_day' ? 'selected' : '' }} value="last_day" >@lang('lang.last_day')</option>
                                                        <option {{ $data['range'] == 'last_week' ? 'selected' : '' }} value="last_week" >@lang('lang.last_week')</option>
                                                        <option {{ $data['range'] == 'last_month' ? 'selected' : '' }} value="last_month" >@lang('lang.last_month')</option>
                                                        <option {{ $data['range'] == 'last_six_months' ? 'selected' : '' }} value="last_six_months" >@lang('lang.last_six_months')</option>
                                                        <option {{ $data['range'] == 'last_year' ? 'selected' : '' }} value="last_year" >@lang('lang.last_year')</option>
                                                        <option {{ $data['range'] == 'last_two_years' ? 'selected' : '' }} value="last_two_years" >@lang('lang.last_two_years')</option>
                                                        <option {{ $data['range'] == 'last_three_years' ? 'selected' : '' }} value="last_three_years" >@lang('lang.last_three_years')</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-top: 27px;">@lang('lang.search')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="font-13 m-b-30 text-right">
                                        <form action="{{ route('admin.filter.export', 'nonSubscribers') }}" method="post">
                                            @csrf
                                            <input name="data" type="hidden" value="{{ $export_users }}">
                                            <button class="btn btn-info waves-effect waves-light" type="submit">@lang('lang.excell_export')</button>
                                        </form>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.name')</th>
                                            <th class="text-center">@lang('lang.email')</th>
                                            <th class="text-center">@lang('lang.phone')</th>
                                            <th class="text-center">@lang('lang.user_type')</th>
                                            <th class="text-center">@lang('lang.specs')</th>
                                            <th class="text-center">@lang('lang.activation')</th>
                                            <th class="text-center">@lang('lang.balance')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($users->count() > 0)
                                            @foreach ($users as $key => $user)
                                                <tr>
                                                    <td class="text-center">{{$key + 1}}</td>
                                                    <td class="text-center">{{$user->name}}</td>
                                                    <td class="text-center">{{$user->email}}</td>
                                                    <td class="text-center">{{$user->phone}}</td>
                                                    <td class="text-center">{{$user->type}}</td>
                                                    <td class="text-center">{{$user->spec}}</td>
                                                    <td class="text-center">{{$user->active == 1 ? __('lang.active') : __('lang.un_active')}}</td>
                                                    <td class="text-center">{{$user->balance}} @lang('lang.rs')</td>
                                                    <td class="text-center">
                                                        <a href="{{route('users.edit' ,$user->id )}}">
                                                            <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                        </a>
                                                        <button class="btn btn-danger " alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                data-id="{{$user->id}}"> @lang('lang.delete') </button>

                                                        <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                    </div>
                                                                    <form action="{{route('users.destroy',$user->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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

