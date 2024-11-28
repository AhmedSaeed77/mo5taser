<?php

namespace App\Http\Controllers\Admin\PassExam;


use App\Models\Admin;
use App\Models\Category;
use App\Models\PassExam;
use Illuminate\Http\Request;
use App\Notifications\passTest;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Exams\PassRequest;
use App\Repository\PassExamRepositoryInterface;

class PassExamController extends Controller
{
    use FileManagerTrait;
    private $pass;

    public function __construct(PassExamRepositoryInterface $pass)
    {
        $this->pass = $pass;
    }

    public function index()
    {
        try
        {
            $categories = Category::category('exam')->get()->pluck('id')->toArray();
            $passes = PassExam::whereIn('level',$categories)->orWhereIn('main_cat',$categories)->get();
            $teachers = Admin::where('role_id',3)->get();
            $main_categories = Category::category('exam')->where('parent_id',NULL)->get();
            return view('dashboard.exams.passed.index',compact('passes','teachers','main_categories'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass))
            {
                $pass = $this->pass->getById($id);
                $teachers = Admin::where('role_id',3)->get();
                $main_categories = Category::category('exam')->where('parent_id',NULL)->get();
                $passes = PassExam::where('level','!=',NULL)->get()->pluck('level')->toArray();
                $levels = Category::where('parent_id' , $pass->main_cat)->whereNotIn('id',$passes)->get();
                return view('dashboard.exams.passed.edit',compact('pass','teachers','main_categories','levels'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(PassRequest $request)
    {
        try
        {
            $data = [
                'questions_number' => $request->questions_number,
                'exam_time' => $request->exam_time,
                'attemps' => $request->attemps,
                'teacher_id' => $request->teacher_id,
                'main_cat' => $request->main_cat,
                'level' => $request->level,
            ];

            $exam = $this->pass->create($data);
            \Notification::send(Admin::where('id', $request->teacher_id)->get(), new passTest($exam));
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(PassRequest $request,$id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass))
            {
                $user = Admin::where('id' , $pass->teacher_id)->first();
                $notifications = $user->Notifications()->get();

                foreach($notifications as $notification) {
                    if($notification->data['id'] == $pass->id && $notification->data['teacher_id'] == $pass->teacher_id
                    && $notification->data['main_cat'] == $pass->main_cat
                    && $notification->data['level'] == $pass->level){
                        $notification->delete();
                    }
                }

                $data = [
                    'questions_number' => $request->questions_number,
                    'exam_time' => $request->exam_time,
                    'attemps' => $request->attemps,
                    'teacher_id' => $request->teacher_id,
                    'main_cat' => $request->main_cat,
                    'level' => $request->level,
                ];

                $this->pass->update($id,$data);
                Category::query()->where('id', $request->level)->update(['parent_id' => $request->main_cat]);
                \Notification::send(Admin::where('id', $request->teacher_id)->get(), new passTest($pass));
                return redirect()->route('pass.index')->with('success' , __('lang.updated'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function destroy($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass))
            {
                $notifications = \App\Models\Notification::get();
                if($notifications->count() > 0)
                {
                    foreach($notifications as $notify)
                    {
                        $not = json_decode($notify->data);
                        if($notify->type == 'App\Notifications\passTest')
                        {
                            if($not->main_cat == $pass->main_cat && $not->level == $pass->level)
                            {
                                $notify->delete();
                            }
                        }
                    }
                }
                $this->pass->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function getLevels(Request $request)
    {
        $department_id = $request->department_id;
        if($department_id != NULL)
        {
            $passes = PassExam::where('level','!=',NULL)->get()->pluck('level')->toArray();
            $levels = Category::where('parent_id' , $department_id)->whereNotIn('id',$passes)->get();
        }
        else
        {
            $levels = '';
        }
        return response()->json($levels);
    }
}
