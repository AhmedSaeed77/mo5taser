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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.store_requests')</b></h4>

                                    <div class="row">
                                        <form action="{{route('store-requests.index')}}" method="POST">
                                            @csrf
                                            {{method_field("GET")}}

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">@lang('lang.type')</label>
                                                        <select class="form-control" name="type">
                                                            <option value="">@lang('lang.choose')</option>
                                                            <option value="printed" {{request()->key == 'printed' ? 'selected' : ''}}>@lang('lang.printed version')</option>
                                                            <option value="pdf" {{request()->key == 'pdf' ? 'selected' : ''}}>@lang('lang.Pdf Version')</option>
                                                            <option value="all" {{request()->key == 'all' ? 'selected' : ''}}>@lang('lang.all')</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">@lang('lang.date_from')</label>
                                                        <input type="date" name="date_from" placeholder="@lang('lang.date_from')" class="form-control" value="{{request()->date_from ?? ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="field-1" class="control-label">@lang('lang.date_to')</label>
                                                        <input type="date" name="date_to" placeholder="@lang('lang.date_to')" class="form-control" value="{{request()->date_to ?? ''}}"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                          <button type="submit" class="btn btn-info waves-effect waves-light" style="margin-top: 27px;">@lang('lang.search')</button>
                                                   </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="widget-bg-color-icon card-box fadeInDown animated">
                                                <div class="bg-icon bg-icon-info pull-left">
                                                    <i class="md md-attach-money text-info"></i>
                                                </div>
                                                <div class="text-right">
                                                    <h3 class="text-dark">{{$printed_payments}} @lang('lang.rs')</h3>
                                                    <p><b>@lang('lang.printed_payments')</b></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="widget-bg-color-icon card-box fadeInDown animated">
                                                <div class="bg-icon bg-icon-info pull-left">
                                                    <i class="md md-attach-money text-info"></i>
                                                </div>
                                                <div class="text-right">
                                                    <h3 class="text-dark">{{$pdf_payments}} @lang('lang.rs')</h3>
                                                    <p><b>@lang('lang.pdf_payments')</b></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="widget-bg-color-icon card-box fadeInDown animated">
                                                <div class="bg-icon bg-icon-info pull-left">
                                                    <i class="md md-attach-money text-info"></i>
                                                </div>
                                                <div class="text-right">
                                                    <h3 class="text-dark">{{$all_payments}} @lang('lang.rs')</h3>
                                                    <p><b>@lang('lang.all')</b></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>



                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.name')</th>
                                            <th class="text-center">@lang('lang.email')</th>
                                            <th class="text-center">@lang('lang.phone')</th>
                                            <th class="text-center">@lang('lang.type')</th>
                                            <th class="text-center">@lang('lang.book_name')</th>
                                            <th class="text-center">@lang('lang.user')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($payments->count() > 0)
                                                @foreach ($payments as $key => $payment)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$payment->name}}</td>
                                                        <td class="text-center">{{$payment->email}}</td>
                                                        <td class="text-center">{{$payment->phone}}</td>
                                                        <td class="text-center">{{$payment->type == 'printed' ? __('lang.printed version') : __('lang.Pdf Version')}}</td>
                                                        <td class="text-center">{{$payment->assemble->title ?? ''}}</td>
                                                        <td class="text-center">{{$payment->user->name ?? ''}}</td>
                                                        <td class="text-center">
                                                            <a href="{{route('store-requests.show' ,$payment->id )}}">
                                                                <button type="button" class="btn btn-primary  waves-effect waves-light" aria-expanded="false">@lang('lang.show')</button>
                                                            </a>
                                                            <button class="btn btn-danger " alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                    data-id="{{$payment->id}}"> @lang('lang.delete') </button>

                                                                    <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                                </div>
                                                                                <form action="{{route('store-requests.destroy',$payment->id)}}" method="POST" enctype="multipart/form-data" id="userForm">
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



