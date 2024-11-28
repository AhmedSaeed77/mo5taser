<?php

namespace App\Http\Resources;

use App\Models\Subject;
use App\Models\Question;
use App\Models\StudentAnswer;
use Illuminate\Http\Resources\Json\JsonResource;

class AttemptsDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
            $answers = StudentAnswer::where(['attemp_id' => $this->id])->get();
            $questions = Question::where('exam_id',$this->exam_id)->get();


            if(($answers->count() == $questions->count()))
            {
                $right_answers = StudentAnswer::where(['attemp_id' => $this->id , 'type' => '1'])->get();
                $wrong_answers = \App\Models\StudentAnswer::where(['attemp_id' => $this->id , 'type' => '0'])->where('student_answer', '!=', 'not_answered')->get();
                $uncompleted_answers = \App\Models\StudentAnswer::where(['attemp_id' => $this->id , 'student_answer' => 'not_answered'])->get();
                $finsh_answers = $answers->pluck('type')->toArray();
                if(!in_array(null, $finsh_answers,true))
                {
                    if(array_sum($questions->pluck('degree')->toArray()) > 0)
                    {
                        $total = (array_sum($answers->pluck('teacher_degree')->toArray())  / array_sum($questions->pluck('degree')->toArray())) * 100;
                        $total = number_format($total, 2);
                    }
                    else
                    {
                        $total = 0;
                    }

                    return
                    [
                        'exam_id' => $this->id,
                        'total' => $total . ' %',
                        'right_answers' => count($right_answers),
                        'wrong_answers' => count($wrong_answers),
                        'uncompleted_answers' => count($uncompleted_answers),
                        'not_yet' => null,
                    ];

                }
                else
                {
                    return
                        [
                            'exam_id' => null,
                            'total' => null,
                            'right_answers' => null,
                            'wrong_answers' => null,
                            'uncompleted_answers' => null,
                            'not_yet' => __('lang.not_all_answers'),
                        ];
                }
            }
            else
            {
                return
                [
                    'exam_id' => $this->id,
                    'total' => 0 . ' %',
                    'right_answers' => 0,
                    'wrong_answers' => count($questions),
                    'uncompleted_answers' => 0,
                    'not_yet' => null,
                ];
            }
    }
}

