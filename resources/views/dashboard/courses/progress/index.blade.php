@extends('dashboard.includes.app')
@section('style')
    <link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
        type="text/css" />
        @include('dashboard.includes.datatable')
        <style>
            /* The switch - the box around the slider */
            .switch {
                position: relative;
                display: inline-block;
                width: 60px;
                height: 34px;
            }

            .hidden {
                display: none;
            }

            /* Hide default HTML checkbox */
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            /* The slider */
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                -webkit-transition: .4s;
                transition: .4s;
            }

            .slider:before {
                position: absolute;
                content: "";
                height: 26px;
                width: 26px;
                left: 4px;
                bottom: 4px;
                background-color: white;
                -webkit-transition: .4s;
                transition: .4s;
            }

            input:checked+.slider {
                background-color: #2196F3;
            }

            input:focus+.slider {
                box-shadow: 0 0 1px #2196F3;
            }

            input:checked+.slider:before {
                -webkit-transform: translateX(26px);
                -ms-transform: translateX(26px);
                transform: translateX(26px);
            }

            /* Rounded sliders */
            .slider.round {
                border-radius: 34px;
            }

            .slider.round:before {
                border-radius: 50%;
            }

        </style>
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

                                    <h4 class="m-t-0 header-title"><b>@lang('lang.progress') - {{$course->title}}</b></h4>

                                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">@lang('lang.student')</th>
                                            <th class="text-center">@lang('lang.course')</th>
                                            <th class="text-center">@lang('lang.progress')</th>
                                            <th class="text-center">@lang('lang.certificate')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if ($students->count() > 0)
                                                @foreach ($students as $key => $student)
                                                    <tr>
                                                        <td class="text-center">{{$key + 1}}</td>
                                                        <td class="text-center">{{$student->user->name}}</td>
                                                        <td class="text-center">{{$student->course->title}}</td>
                                                        <td class="text-center">{{$student->course->progress($student->user_id)}} %</td>
                                                        <td class="text-center">
                                                            <label class="switch">
                                                                <input type="checkbox" class="switch_btn"
                                                                    name="switch-{{ $key }}"
                                                                    {{ $student->certificate == 1 ? 'checked' : '' }}
                                                                        data-id="{{ $student->id }}">
                                                                <span class="slider round"></span>
                                                            </label>
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

    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>

    <script>
        $(() => {
            var switchStatus = false;
            $(document).on('click', '.switch_btn', function() {
                toastr.options = {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    timeOut: 2000,
                };

                if ($(this).is(':checked')) {
                    switchStatus = $(this).is(':checked');
                    var id = $(this).data('id');
                    var val = switchStatus;

                    $.ajax({
                        url: "{{ route('student.certificate') }}",
                        type: "POST",
                        data: {
                            val: val,
                            id: id,
                            _token: '{!! csrf_token() !!}',
                        },
                        success: function(data) {
                            toastr.success('تم  منح الشهادة للطالب');
                        }
                    });


                } else {
                    switchStatus = $(this).is(':checked');
                    var id = $(this).data('id');
                    var val = switchStatus;

                    $.ajax({
                        url: "{{ route('student.certificate') }}",
                        type: "POST",
                        data: {
                            val: val,
                            id: id,
                            _token: '{!! csrf_token() !!}',
                        },
                        success: function(data) {
                            toastr.success('تم  إلغاء الشهادة من حساب الطالب');
                        }
                    });
                }
            });
        });
    </script>

    
@endsection

