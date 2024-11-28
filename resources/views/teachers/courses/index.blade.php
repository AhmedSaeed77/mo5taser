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
									<li class="active">
										@lang('lang.courses')
									</li>
								</ol>
							</div>
						</div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.courses')</b></h4>
                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.title')</th>
                                            <th class="text-center">@lang('lang.category')</th>
                                            <th class="text-center">@lang('lang.progress')</th>
                                            <th class="text-center">@lang('lang.control')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($courses->count() > 0)
                                                @foreach ($courses as $key => $course)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$course->title}}</td>
                                                        <td class="text-center">{{$course->category->title}}</td>
                                                        <td class="text-center"><a href="{{route('students-progress.show',$course->id)}}">@lang('lang.progress')</a></td>
                                                        <td class="text-center">
                                                            <a href="{{route('course-units',$course->id)}}">
                                                                <button type="button" class="btn btn-success  waves-effect waves-light" aria-expanded="false">@lang('lang.units')</button>
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

