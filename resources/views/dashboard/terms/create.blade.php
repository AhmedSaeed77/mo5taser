@extends('dashboard.includes.app')
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
                                    <div class="widget-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                                <h4>@lang('lang.term') </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{ route('term.store') }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
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
                                                            <textarea class="form-control autogrow ckeditor" id="field-7" name="content_ar"
                                                            placeholder="@lang('lang.content_ar')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_ar') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group no-margin">
                                                            <label for="field-7" class="control-label">@lang('lang.content_en')</label>
                                                            <textarea class="form-control autogrow ckeditor" id="field-7" name="content_en"
                                                            placeholder="@lang('lang.content_en')" required
                                                            style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;">{{ old('content_en') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
                                            </div>
                                        </form>
                                    </div>
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
    <script src="{{asset('ckeditor/ckeditor.js') }}"></script>

    <script>
            CKEDITOR.replace('markdownckeditor');
    </script>
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
