{{-- multi_choice question  --}}
<div class="row">
    <form action="{{route('content_answer.update',$answer)}}" class="form-horizontal gggg" role="form" method="post" enctype="multipart/form-data" id="form_matching">
        @csrf
        @method('PUT')
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">@lang('lang.question')</label>
                        <textarea class="form-control" id="ckeditor1" name="question" required>{!! $answer->question->question !!}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer1')</label>
                        <div class="input_choice">
                            <label for="q1" class="custom_checkbox m-0">
                                <input type="radio" id="q1" value="1" name="true_answer" required="" {{$answer->question->true_answer == 1 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="answer1" placeholder="@lang('lang.answer1')" required value="{{ $answer->question->answer1 }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer2')</label>
                        <div class="input_choice">
                            <label for="q2" class="custom_checkbox m-0">
                                <input type="radio" id="q2" value="2" name="true_answer" required="" {{$answer->question->true_answer == 2 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="answer2" placeholder="@lang('lang.answer2')" required value="{{ $answer->question->answer2 }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer3')</label>
                        <div class="input_choice">
                            <label for="q3" class="custom_checkbox m-0">
                                <input type="radio" id="q3" value="3" name="true_answer" required="" {{$answer->question->true_answer == 3 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="answer3"
                        placeholder="@lang('lang.answer3')" required value="{{ $answer->question->answer3 }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.answer4')</label>

                        <div class="input_choice">
                            <label for="q4" class="custom_checkbox m-0">
                                <input type="radio" id="q4" value="4" name="true_answer" required="" {{$answer->question->true_answer == 4 ? 'checked' : ''}} disabled>
                                <span class="checkmark"></span>
                            </label>
                            <input type="text" class="form-control" id="field-1" name="answer4"placeholder="@lang('lang.answer4')" required value="{{$answer->question->answer4 }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.question_subject')</label>
                        <select class="form-control" name="subject_id" required>
                            <option value="">@lang('lang.choose')</option>
                            @if($subjects->count() > 0)
                                @foreach ($subjects as $subjects)
                                        <option value="{{$subjects->id}}" {{$answer->question->subject_id == $subjects->id ? 'selected' : ''}} disabled>{{$subjects->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="field-1" class="control-label label-change">@lang('lang.degree')</label>
                        <div class="input_choice">
                            <input type="number" min="1" class="form-control" id="field-1" name="degree" placeholder="@lang('lang.degree')" required value="{{$answer->question->degree }}" readonly>
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
                            <textarea class="form-control" name="hint" id="ckeditor2" required>{!! $answer->question->hint !!}</textarea>
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
                                        $answer_question = $answer_question->answer1;
                                    }
                                    if($answer->student_answer == 2){
                                        $answer_question = $answer_question->answer2;
                                    }
                                    if($answer->student_answer == 3){
                                        $answer_question = $answer_question->answer3;
                                    }
                                    if($answer->student_answer == 4){
                                        $answer_question = $answer_question->answer4;
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
                <div class="col-md-6">
                    <div class="form-group no-margin">
                        <label for="field-7" class="control-label label-change label-change">
                            <span>@lang('lang.answer_type')</span>
                        </label>
                        <select class="form-control" name="type" required>
                            <option value="" >@lang('lang.choose')</option>
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
{{-- multi_choice question  --}}
