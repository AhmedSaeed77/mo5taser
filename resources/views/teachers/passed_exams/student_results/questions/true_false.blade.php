{{--  true or false question  --}}
<div class="row">
    <form action="{{route('answer.update',$answer)}}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" id="form_matching">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">@lang('lang.question')</label>
                        <textarea class="form-control" id="ckeditor1" name="question" required readonly{!! $answer->question->question !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer1')</label>
                        <div class="input_choice">
                            <label for="q5" class="custom_checkbox m-0">
                                <input type="radio" id="q5" value="1" name="true_answer" required="" {{$answer->question->true_answer == 1 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" value="@lang('lang.true')" name="answer1" placeholder="@lang('lang.answer1')" required value="{{ old('answer1') }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer2')</label>
                        <div class="input_choice">
                            <label for="q6" class="custom_checkbox m-0">
                                <input type="radio" id="q6" value="0" name="true_answer" required="" {{$answer->question->true_answer == 0 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="answer2" value="@lang('lang.false')" placeholder="@lang('lang.answer2')" required value="{{ old('answer2') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control" name="subject_id" required disabled>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subjects)
                                        <option value="{{$subjects->id}}" {{$answer->question->subject_id == $subjects->id ? 'selected' : ''}}>{{$subjects->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{$answer->question->degree}}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if($answer->question->image)
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change">
                            <span>@lang('lang.image')</span>
                        </label>
                        <br>
                        <img class="img-thumbnail" src="{{asset($answer->question->image)}}" style="width: 100px; height: 100px;">
                    </div>
                </div>
                @endif
                @if($answer->question->video_url)
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">
                            <span>@lang('lang.video_url')</span>
                        </label>
                        <input type="text" class="form-control" id="field-1" name="video_url"
                        placeholder="@lang('lang.video_url')"  value="{{ $answer->question->video_url }}" readonly>

                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group no-margin">
                            <label for="field-7" class="control-label label-change label-change">
                                <span>@lang('lang.hint')</span>
                            </label>
                            <textarea class="form-control" name="hint" id="ckeditor2">{!! $answer->question->hint !!}</textarea>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.student_answer')</label>

                        <div class="input_choice">
                            @php
                                if($answer->student_answer != 'not_answered' &&  $answer->student_answer != NULL)
                                {
                                    $answer_question = \App\Models\Question::where('id',$answer->question_id)->first();
                                    if($answer->student_answer == 1){
                                        $answer_question = 'صواب';
                                    }
                                    if($answer->student_answer == 0){
                                        $answer_question = 'خطأ';
                                    }
                                }
                                else
                                {
                                    $answer_question = $answer->student_answer;
                                }
                            @endphp
                            <input type="text" class="form-control" id="field-1"
                            placeholder="@lang('lang.student_answer')" required value="{{$answer_question}}" readonly>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">
                            <span>@lang('lang.answer_type')</span>
                        </label>
                        <select class="form-control" name="type" required>
                            <option value="0" {{$answer->type == '0' ? 'selected' : ''}}>@lang('lang.wrong_answer')</option>
                            <option value="1" {{$answer->type == '1' ? 'selected' : ''}}>@lang('lang.true_answer')</option>
                            <option value="2" {{$answer->type == '2' ? 'selected' : ''}}>@lang('lang.uncomplete_answer')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">
                            <span>@lang('lang.teacher_degree')</span>
                        </label>
                        <input type="number" min="0" max="{{$answer->question->degree}}" class="form-control" id="field-1" name="teacher_degree"
                        value="{{$answer->teacher_degree}}" placeholder="@lang('lang.teacher_degree')" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info waves-effect waves-light">@lang('lang.send_answer_degree')</button>
        </div>
    </form>
</div>
{{--  true or false question  --}}
