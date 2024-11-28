{{--  matching question  --}}
<div class="row">
    <form action="{{route('content-categories-questions.store')}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_matching">
        @csrf
        @method('POST')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 matching_section">
                    <div class="form-group no-margin">
                        <div class="text-end">
                            <button type="button" id="add_btn" class="btn btn-default waves-effect">@lang('lang.add_question')</button>
                            <button type="button" id="delete_btn" class="btn btn-danger waves-effect waves-light">@lang('lang.remove_question')</button>
                        </div>
                        <div class="row matching_row">
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.questions')</h5>
                                <div class="matching_questions">
                                    <div class="form-group" data-num="1">
                                        <span class="num">1</span>
                                        <input type="text" class="form-control" placeholder="@lang('lang.question')" data-value="1" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <h5 class="head">@lang('lang.answers')</h5>
                                <div class="matching_answers">
                                    <div class="form-group" data-num="1">
                                        <input type="hidden" value="1">
                                        <span class="num">1</span>
                                        <input type="text" class="form-control" placeholder="@lang('lang.answer')" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control subject_class" name="subject_id[]" required>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subjects)
                                        <option value="{{$subjects->id}}">{{$subjects->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="child_subject hidden">
                    <div class="col-md-12 child_subject1 hidden">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                            <select class="form-control child_subject1_select1" name="subject_id[]">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 child_subject2 hidden">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                            <select class="form-control child_subject1_select2" name="subject_id[]">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{ old('degree') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change">
                            <span>@lang('lang.image')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <input type="file" class="form-control" name="image" accept="image/*">

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video platform')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <select class="form-control" name="video_platform">
                            <option {{ old('video_platform') == '' ?  'selected' : ''}} value="">------</option>
                            <option {{ old('video_platform') == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                            <option {{ old('video_platform') == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video_url')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <input type="text" class="form-control" id="field-1" name="video_url"
                        placeholder="@lang('lang.video_url')"  value="{{ old('video_url') }}">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change">
                                <span>@lang('lang.hint_image')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <input type="file" class="form-control" name="hint_image" accept="image/*">

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">
                                <span>@lang('lang.hint video platform')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <select class="form-control" name="hint_video_platform">
                                <option {{ old('hint_video_platform') == '' ?  'selected' : ''}} value="">------</option>
                                <option {{ old('hint_video_platform') == 'youtube' ?  'selected' : ''}} value="youtube">@lang('lang.youtube')</option>
                                <option {{ old('hint_video_platform') == 'vimeo' ?  'selected' : ''}} value="vimeo">@lang('lang.vimeo')</option>
                            </select>

                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">
                                <span>@lang('lang.hint_video')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="hint_video"
                            placeholder="@lang('lang.hint_video')"  value="{{ old('hint_video') }}">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change label-change">
                                <span>@lang('lang.hint')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <textarea class="form-control ckeditor" name="hint" id="ckeditor8" required></textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="content_category_id" value="{{$category->id}}">
        <input type="hidden" name="type" value="matching">
        <input type="hidden" name="question" id="questions_value" value="">
        <div class="modal-footer">
            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">@lang('lang.close')</button>
            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.submit')</button>
        </div>
    </form>
</div>
{{--  matching question  --}}
