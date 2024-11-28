<?php

namespace App\Http\Controllers\Admin\Subscribe;

use App\Models\Cart;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscribe;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Notifications\activeSubscribtion;
use App\Notifications\unActiveSubscribtion;
use App\Repository\CourseRepositoryInterface;
use App\Repository\SubscribeRepositoryInterface;
use App\Http\Requests\Subscribe\SubscribeRequest;

class FreeSubscribeController extends Controller
{
    use FileManagerTrait;
    private $subscribe , $course;

    public function __construct(SubscribeRepositoryInterface $subscribe , CourseRepositoryInterface $course)
    {
        $this->subscribe = $subscribe;
        $this->course = $course;
    }

    public function show($id)
    {
        $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        try
        {
            if(isset($course))
            {
                $exist_subscribes = Subscribe::where('course_id',$course->id)->get();
                $users = User::where('role_id' , 4)->whereNotIn('id' , $exist_subscribes->pluck('user_id')->toArray())->get();
                return view('dashboard.free_subscribes.index',compact('users','course'));
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

    public function update(Request $request,$id)
    {
        $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
        try
        {
            if(isset($course))
            {

                if($request->users)
                {
                    $users = User::whereIn('id',$request->users)->get();
                    foreach($users as $user)
                    {
                        $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                        $plus = $course->peroid;
                        $data = [
                            'active' => 1,
                            'start_subscribe' => $date->toDateString(),
                            'end_subscribe' => $date->addDays($plus)->toDateString(),
                            'course_id' => $course->id,
                            'user_id' => $user->id,
                            'type' => 'free',
                            'total' => 0,
                        ];

                        $subscribe = $this->subscribe->create($data);
                        Cart::query()->where('user_id', $user->id)->where('course_id', $id)->delete();
                        \Notification::send(User::where(['id' => $user->id])->first(), new activeSubscribtion($subscribe));
                    }
                    return redirect()->back()->with('success' , __('lang.added'));
                }
                else
                {
                    return back()->with('failed' , __('lang.not_found'));
                }

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

}
