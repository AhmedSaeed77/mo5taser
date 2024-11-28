<?php

namespace App\Http\Controllers\Admin\Course;

use Notification;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscribe;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Notifications\GetCertificateUser;
use App\Notifications\removeCertificateUser;
use App\Repository\CourseRepositoryInterface;

class ProgressController extends Controller
{
    public function show($id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $students = Subscribe::where('course_id',$course->id)->get();
                return view('dashboard.courses.progress.index',compact('students','course'));
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

    public function studentCertificate(Request $request)
    {
        $id = $request->id;
        $val = $request->val;


        $subscribe = Subscribe::findOrFail($id);
        if(isset($subscribe))
        {
            if($val == 'false')
            {
                $subscribe->update([
                    'certificate' => 0
                ]);
                Notification::send(User::where(['id' => $subscribe->user_id])->first(), new removeCertificateUser($subscribe));
                return response()->json('unactivated');
            }

            if($val == 'true')
            {
                $subscribe->update([
                    'certificate' => 1
                ]);
                Notification::send(User::where(['id' => $subscribe->user_id])->first(), new GetCertificateUser($subscribe));
                return response()->json('activated');
            }

        }
    }
}
