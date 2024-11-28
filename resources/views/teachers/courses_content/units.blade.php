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
								<ol class="breadcrumb">
									<li>
										<a href="{{route('admin.dashboard')}}">@lang('lang.home')</a>
									</li>
									<li>
										<a href="{{route('teacher-courses.index')}}">@lang('lang.courses')</a>
									</li>
									<li class="active">
										@lang('lang.units_for_course') -- ({{$course->title}})
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.course_content') </b></h4>
                                    <div class="font-13 m-b-30 text-right">
                                        <button class="btn btn-info waves-effect waves-light" data-toggle="modal"
                                            data-target="#unit-modal">@lang('lang.unit') + </button>
                                    </div>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-switchable="false" class="text-center">#</th>
                                                <th class="text-center">@lang('lang.title_ar')</th>
                                                <th class="text-center">@lang('lang.title_en')</th>
                                                <th class="text-center">@lang('lang.image')</th>
                                                <th class="text-center">@lang('lang.type')</th>
                                                <th class="text-center">@lang('lang.course_content')</th>
                                                <th class="text-center">@lang('lang.control')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if ($units->count() > 0)
                                                @foreach ($units as $key => $unit)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 }}</td>
                                                        <td class="text-center">{{ $unit->title_ar }}</td>
                                                        <td class="text-center">{{ $unit->title_en }}</td>
                                                        <td class="text-center">
                                                            <img src="{{asset($unit->image)}}" style="width: 80px; height: 80px; border-radius: 50%">
                                                        </td>
                                                        <td class="text-center"><span>@lang('lang.'.$unit->type)</span></td>

                                                        <td class="text-center">
                                                            <a href="{{route('content-courses.show',$unit->id)}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.course_content')</button>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{route('content-courses.edit',$unit->id)}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.edit')</button>
                                                            </a>
                                                            <form action="{{route('content-courses.destroy',$unit->id)}}" method="POST" style="display: inline-block;">
                                                                <input name="_method" type="hidden" value="DELETE">
                                                                {{ csrf_field() }}
                                                                <button type="submit" class="btn btn-danger  waves-effect waves-light" aria-expanded="false">@lang('lang.delete')</button>
                                                            </form>
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

    {{-- model add unit --}}
    <div id="unit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-color panel-primary">
                    <div class="panel-heading">
                        <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 class="panel-title">@lang('lang.add_course_unit')</h3>
                    </div>
                    <div class="panel-body">
                        <div class="card-box">
                            <form action="{{ route('content-courses.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                {{ method_field('POST') }}
                                <div class="form-group">
                                    <label>@lang('lang.title_ar')</label>
                                    <input type="text" name="title_ar" placeholder="@lang('lang.title_ar')"
                                        class="form-control title_ar" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.title_en')</label>
                                    <input type="text" name="title_en" placeholder="@lang('lang.title_en')"
                                        class="form-control title_en" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('lang.image')</label>
                                    <input type="file" name="image" placeholder="@lang('lang.image')"
                                        class="form-control image" accept="image/*" required>
                                </div>
                                <input type="hidden" name="type" value="unit">
                                <input type="hidden" name="course_id" value="{{$course->id}}">
                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">
                                        @lang('lang.submit')
                                    </button>
                                    <button type="button" data-dismiss="modal"
                                        class="btn btn-danger waves-effect waves-light m-l-5">
                                        @lang('lang.cancel')
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal add unit --}}
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


