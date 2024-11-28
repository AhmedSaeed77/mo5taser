@extends('dashboard.includes.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('dashboard/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('contnet')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="page-title"> @lang('lang.courses') </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box">
                                        <form action="{{ route('courses.store') }}" method="post"
                                            enctype="multipart/form-data" onsubmit="Button_submit.disabled = true; return true;">
                                            @csrf
                                            {{ method_field('POST') }}
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.title_ar')</label>
                                                    <input type="text" name="title_ar" value="{{ old('title_ar') }}"
                                                        placeholder="@lang('lang.title_ar')" class="form-control title_ar" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.title_en')</label>
                                                    <input type="text" name="title_en" value="{{ old('title_en') }}"
                                                        placeholder="@lang('lang.title_en')" class="form-control title_en" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.desc_ar')</label>
                                                    <textarea name="desc_ar" rows="3"
                                                        placeholder="@lang('lang.desc_ar')"
                                                        class="form-control ckeditor">{{ old('desc_ar') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.desc_en')</label>
                                                    <textarea name="desc_en" rows="3"
                                                        placeholder="@lang('lang.desc_en')"
                                                        class="form-control ckeditor">{{ old('desc_en') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.peroid') (@lang('lang.days'))</label>
                                                    <input type="number" min="1" value="{{ old('peroid') }}" name="peroid" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.image')</label>
                                                    <input type="file" name="image"
                                                        placeholder="@lang('lang.image')" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.category')</label>
                                                    <select class="form-control" required name="category_id">
                                                        @foreach ($categories as $key => $item)
                                                            <option value="{{ $item->id }}">{{ $item->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.price')</label>
                                                    <input type="number" min="0" name="price" value="{{ old('price') }}"
                                                        placeholder="@lang('lang.price')" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.price_after') (<span style="color:red">@lang('lang.price_after_empty')</span>)</label>
                                                    <input type="number" name="price_after"
                                                    placeholder="@lang('lang.price_after')" value="{{ old('price_after') }}" class="form-control">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.number of subscribers')</label>
                                                    <input type="number" name="subscribers" min="0"
                                                    placeholder="@lang('lang.number of subscribers')" value="{{ old('subscribers') }}" class="form-control" required>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.activation')</label>
                                                    <select class="form-control" name="active" required>
                                                        <option value="0">@lang('lang.not_active')</option>
                                                        <option value="1">@lang('lang.active')</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.status')</label>
                                                    <select class="form-control" name="open" required>
                                                        <option value="0">@lang('lang.closed')</option>
                                                        <option value="1">@lang('lang.open')</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.course_type')</label>
                                                    <select class="form-control" name="type" required>
                                                        <option value="paid" selected>@lang('lang.paid')</option>
                                                          <option value="free">@lang('lang.free')</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.teachers')</label>
                                                    <select class="form-control" name="teachers[]" required id="teachers"
                                                        multiple>
                                                        @foreach ($teachers as $key => $val)
                                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>@lang('lang.preview video platform')</label>
                                                    <select class="form-control" name="preview_video_platform">
                                                        <option {{ old('preview_video_platform') == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                                        <option {{ old('preview_video_platform') == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>@lang('lang.preview_video')</label>
                                                    <input type="text" value="{{ old('preview_video') }}" name="preview_video" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.course_bag')  <a href="https://drive.google.com/file/d/1_DbqG0K98ugUCv-hgzHFS6nAqfmU7_pG/view?usp=share_link" target="_blank">(@lang('lang.for_help'))</a></label>
                                                    <input type="text" name="course_bag" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.subscribed_course_bag') <a href="https://drive.google.com/file/d/1_DbqG0K98ugUCv-hgzHFS6nAqfmU7_pG/view?usp=share_link" target="_blank">(@lang('lang.for_help'))</a></label>
                                                    <input type="text" name="subscribed_bag" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.start_date')</label>
                                                    <input type="date" name="start_date" class="form-control" >
                                                    <span style="color: red">@lang('lang.optional')</span>
                                                    <br>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.course_table') <a href="https://drive.google.com/file/d/1_DbqG0K98ugUCv-hgzHFS6nAqfmU7_pG/view?usp=share_link" target="_blank">(@lang('lang.for_help'))</a></label>
                                                    <input type="text" name="course_table" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>@lang('lang.course_group') <span style="color: red">@lang('lang.optional')</span> </label>
                                                    <input type="url" name="course_group" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group text-right m-b-0">
                                                    <button class="btn btn-default waves-effect waves-light" name="Button_submit"
                                                     type="submit">
                                                        @lang('lang.submit')
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection

                @section('js')
                    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
                    <script src="{{ asset('dashboard/plugins/bootstrap-table/js/bootstrap-table.min.js') }}"></script>
                    <script src="{{ asset('dashboard/pages/jquery.bs-table.js') }}"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

                    <script type="text/javascript">
                        var lang = $("#local").val();
                        $("#teachers").select2({
                            placeholder: lang == 'ar' ? 'اختر المعلم' : 'select teacher',
                            allowClear: true
                        });
                        $("#live_days").select2({
                            placeholder: lang == 'ar' ? 'اختر اليوم' : 'select day',
                            allowClear: true
                        });
                    </script>
                    <script>
                        CKEDITOR.replace('markdownckeditor');
                    </script>

                @endsection
