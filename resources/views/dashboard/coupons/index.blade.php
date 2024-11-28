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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.coupons')</b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#con-close-modal">@lang('lang.create')</button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.coupon')</th>
                                            <th class="text-center">@lang('lang.course')</th>
                                            <th class="text-center">@lang('lang.user')</th>
                                            <th class="text-center">@lang('lang.type')</th>
                                            <th class="text-center">@lang('lang.discount')  %</th>
                                            <th class="text-center">@lang('lang.discount_number')</th>
                                            <th class="text-center">@lang('lang.use_number')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if ($coupons->count() > 0)
                                            @foreach ($coupons as $key => $coupon)
                                                <tr>
                                                    <td class="text-center">{{$key + 1}}</td>
                                                    <td class="text-center">{{$coupon->coupon}}</td>
                                                    <td class="text-center">{{$coupon->course->title}}</td>
                                                    <td class="text-center">{{$coupon->user->name ?? ''}}</td>
                                                    <td class="text-center">{{$coupon->type}}</td>
                                                    <td class="text-center">{{$coupon->discount}} </td>
                                                    <td class="text-center">{{$coupon->discount_number}}</td>
                                                    <td class="text-center">{{$coupon->use_number}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('coupon.edit' ,$coupon->id )}}">
                                                            <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                        </a>

                                                        <button class="btn btn-danger" alt="default" data-toggle="modal" data-target="#delete-modal{{$key}}"
                                                                data-id="{{$coupon->id}}"> @lang('lang.delete') </button>

                                                        <div id="delete-modal{{$key}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title">@lang('lang.delete')</h4>
                                                                    </div>
                                                                    <form action="{{route('coupon.destroy' ,$coupon->id )}}" method="POST" enctype="multipart/form-data" id="userForm">
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
                <form action="{{ route('coupon.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.coupon')</label>
                                    <input type="text" class="form-control" id="field-1" name="coupon"
                                           placeholder="@lang('lang.coupon')" required value="{{ old('coupon') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.course')</label>
                                    <select class="form-control" id="field-1" name="course_id">
                                        @if($courses->count() > 0)
                                            @foreach ($courses as $course)
                                                <option value="{{$course->id}}">{{$course->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.user')</label>
                                    <select class="form-control" id="field-1" name="user_id">
                                        <option value="">@lang('lang.without_user')</option>
                                        @if($users->count() > 0)
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.type')</label>
                                    <select class="form-control" id="field-1" name="type">
                                        <option value="paid">@lang('lang.paid')</option>
                                        {{--  <option value="free">@lang('lang.free')</option>  --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.discount') % (<span style="color: red">@lang('lang.optional'))</label>
                                    <input type="number" min="1"  max="99" class="form-control" id="field-1" name="discount"
                                           placeholder="@lang('lang.discount')" value="{{ old('discount') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.discount_number') (<span style="color: red">@lang('lang.optional'))</label>
                                    <input type="number" min="1" class="form-control" id="field-1" name="discount_number"
                                           placeholder="@lang('lang.discount_number')" value="{{ old('discount_number') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">@lang('lang.use_number')</label>
                                    <input type="number" min="1" class="form-control" id="field-1" name="use_number"
                                           placeholder="@lang('lang.use_number')" required value="{{ old('use_number') }}">
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
                $('#userForm').attr("action", "{{ url('/admin/coupon') }}" + "/" + id);
            })
        });
    </script>

@endsection

