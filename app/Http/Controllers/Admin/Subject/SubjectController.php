<?php

namespace App\Http\Controllers\Admin\Subject;

use App\Models\Subject;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\SubjectRequest;
use App\Repository\SubjectRepositoryInterface;

class SubjectController extends Controller
{
    use FileManagerTrait;
    private $subject;

    public function __construct(SubjectRepositoryInterface $subject)
    {
        $this->subject = $subject;
    }

    public function index()
    {
        try
        {
            $subjects = $this->subject->getAll();
            return view('dashboard.subjects.index',compact('subjects'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $subject = Subject::find($id);
        try
        {
            if(isset($subject))
            {
                $subject = $this->subject->getById($id);
                $subjects = $this->subject->getAll();
                return view('dashboard.subjects.edit',compact('subject','subjects'));
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

    public function store(SubjectRequest $request)
    {
        try
        {
            $data = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'parent_id' => $request->parent_id,
            ];

            $this->subject->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(SubjectRequest $request,$id)
    {
        $subject = Subject::find($id);
        try
        {
            if(isset($subject))
            {
                $data = [
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'parent_id' => $request->parent_id,
                ];

                $this->subject->update($id,$data);
                return redirect()->route('subject.index')->with('success' , __('lang.updated'));
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
            $subject = Subject::find($id);
            if(isset($subject))
            {
                $subject->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
