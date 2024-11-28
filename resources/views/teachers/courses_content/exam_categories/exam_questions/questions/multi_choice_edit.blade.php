{{-- multi_choice question  --}}
<div class="row">
    <form action="{{route('content-categories-questions.update',$question)}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_matching">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="ckeditor3" class="control-label label-change label-change">@lang('lang.question')</label>
                        <textarea class="form-control ckeditor" id="ckeditor3" name="question" required>{!! $question->question !!}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">@lang('lang.question_details') <span style="color: #e52012">(@lang('lang.optional'))</span></label>
                        <textarea class="form-control ckeditor" id="ckeditor2222" name="question_details" required>{!! $question->question_details !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer1')</label>
                        <div class="input_choice">
                            <label for="q1" class="custom_checkbox m-0">
                                <input type="radio" id="q1" value="1" name="true_answer" required="" {{$question->true_answer == 1 ? 'checked' : ''}}>
                                <span class="checkmark"></span>
                            </label>
                            <textarea class="form-control ckeditor" id="ckeditor_answer1"  name="answer1" required>{!! $question->answer1 !!}</textarea>
                            {{--  <input type="text" class="form-control" id="field-1" name="answer1" placeholder="@lang('lang.answer1')" required value="{{ $question->answer1 }}">  --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer2')</label>
                        <div class="input_choice">
                            <label for="q2" class="custom_checkbox m-0">
                                <input type="radio" id="q2" value="2" name="true_answer" required="" {{$question->true_answer == 2 ? 'checked' : ''}}>
                                <span class="checkmark"></span>
                            </label>
                            <textarea class="form-control ckeditor" id="ckeditor_answer2" name="answer2" required>{!! $question->answer2 !!}</textarea>
                            {{--  <input type="text" class="form-control" id="field-1" name="answer2" placeholder="@lang('lang.answer2')" required value="{{ $question->answer2 }}">  --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer3')</label>
                        <div class="input_choice">
                            <label for="q3" class="custom_checkbox m-0">
                                <input type="radio" id="q3" value="3" name="true_answer" required="" {{$question->true_answer == 3 ? 'checked' : ''}}>
                                <span class="checkmark"></span>
                            </label>
                            <textarea class="form-control ckeditor" id="ckeditor_answer3" name="answer3" required>{!! $question->answer3 !!}</textarea>
                            {{--  <input type="text" class="form-control" id="field-1" name="answer3" placeholder="@lang('lang.answer3')" required value="{{ $question->answer3 }}">  --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer4')</label>

                        <div class="input_choice">
                            <label for="q4" class="custom_checkbox m-0">
                                <input type="radio" id="q4" value="4" name="true_answer" required="" {{$question->true_answer == 4 ? 'checked' : ''}}>
                                <span class="checkmark"></span>
                            </label>
                            <textarea class="form-control ckeditor" id="ckeditor_answer4" name="answer4" required>{!! $question->answer4 !!}</textarea>
                            {{--  <input type="text" class="form-control" id="field-1" name="answer4"placeholder="@lang('lang.answer4')" required value="{{$question->answer4 }}">  --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @php
                    $subject_val = $question->subjectId();
                    $second_childs_subjects = \App\Models\Subject::whereIn('parent_id',$subjects->pluck('id')->toArray())->get();
                    $third_childs_subjects = \App\Models\Subject::whereIn('parent_id',$second_childs_subjects->pluck('id')->toArray())->get();
                @endphp
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control subject_class" name="subject_id[]" required>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}" {{in_array($subject->id,$subject_val) ? 'selected' : ''}}>{{$subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 child_subject1 {{count(array_intersect($subject_val,$second_childs_subjects->pluck('id')->toArray())) > 0 ? '' : 'hidden'}}">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control child_subject1_select1" name="subject_id[]">
                            <option value="">@lang('lang.choose')</option>
                            @if($second_childs_subjects->count() > 0)
                                @foreach ($second_childs_subjects as $second_subject)
                                        <option value="{{$second_subject->id}}" {{in_array($second_subject->id,$subject_val) ? 'selected' : ''}}>{{$second_subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12 child_subject2 {{count(array_intersect($subject_val,$third_childs_subjects->pluck('id')->toArray())) > 0 ? '' : 'hidden'}}">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control child_subject1_select2" name="subject_id[]">
                            <option value="">@lang('lang.choose')</option>
                            @if($third_childs_subjects->count() > 0)
                                @foreach ($third_childs_subjects as $third_subject)
                                        <option value="{{$third_subject->id}}" {{in_array($third_subject->id,$subject_val) ? 'selected' : ''}}>{{$third_subject->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{$question->degree }}">
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
                        <br>
                        @if($question->image)
                          <img class="img-thumbnail" src="{{asset($question->image)}}" style="width: 100px; height: 100px;">
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video platform')</span>
                            <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                        </label>
                        <select class="form-control" name="video_platform">
                            <option {{ $question->video_platform == '' ? 'selected' : '' }} value="">------</option>
                            <option {{ $question->video_platform == 'youtube' ? 'selected' : '' }} value="youtube">@lang('lang.youtube')</option>
                            <option {{ $question->video_platform == 'vimeo' ? 'selected' : '' }} value="vimeo">@lang('lang.vimeo')</option>
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
                        placeholder="@lang('lang.video_url')"  value="{{ $question->video_url }}">

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
                            <br>
                            @if($question->hint_image)
                            <img class="img-thumbnail" src="{{asset($question->hint_image)}}" style="width: 100px; height: 100px;">
                            @endif

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="field-1" class="control-label label-change">
                                <span>@lang('lang.hint video platform')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <select class="form-control" name="hint_video_platform">
                                <option {{ $question->hint_video_platform == '' ? 'selected' : '' }} value="">------</option>
                                <option {{ $question->hint_video_platform == 'youtube' ? 'selected' : '' }} value="youtube">@lang('lang.youtube')</option>
                                <option {{ $question->hint_video_platform == 'vimeo' ? 'selected' : '' }} value="vimeo">@lang('lang.vimeo')</option>
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
                            placeholder="@lang('lang.hint_video')"  value="{{ $question->hint_video }}">

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change label-change">
                                <span>@lang('lang.hint')</span>
                                <span style="color: #e52012; font-size: 15px !important;" class="control-label label-change">(@lang('lang.optional'))</span>
                            </label>
                            <textarea class="form-control ckeditor" name="hint" id="ckeditor2" required>{!! $question->hint !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="content_category_id" value="{{$question->content_category_id}}">
        <input type="hidden" name="type" value="multi_choice">
        <div class="modal-footer">
            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.edit')</button>
        </div>
    </form>
</div>
{{-- multi_choice question  --}}
