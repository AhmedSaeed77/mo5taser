<?php

namespace App\Http\Controllers\Site\User;

use App\Models\Info;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Exchange;
use App\Models\Subscribe;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Repository\UserRepositoryInterface;

class UserController extends Controller
{
    use FileManagerTrait;
    private $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        try
        {
            $notifications = \Auth::user()->Notifications()->get();

            foreach($notifications as $notification) {
                if($notification->type == 'App\Notifications\GetCertificateUser' || $notification->type == 'App\Notifications\removeCertificateUser')
                {
                    $notification->markAsRead();
                }
            }

            $certificates = Subscribe::where(['user_id' => auth()->id(), 'certificate' => 1])->get();
            $coupons = Coupon::where('user_id',auth()->id())->get();

            $subscribes = Subscribe::whereIn('coupon' , $coupons->pluck('coupon')->toArray())->get();

            $not_accepted_profits = array_sum(Exchange::query()->select('amount')->where('user_id', auth()->id())->where('paid', 0)->pluck('amount')->toArray());

            $incomming_profits = array_sum(Subscribe::where(['active' => 0 , 'start_subscribe' => NULL , 'end_subscribe' => NULL])->whereIn('coupon', $coupons->pluck('coupon')->toArray())->get()->pluck('difference')->toArray());
            $info = Info::first();
            $exchanges = Exchange::where('user_id' , auth()->id())->get();
            return view('site.users.profile' , compact('certificates','coupons' ,'info' ,'incomming_profits','subscribes','exchanges', 'not_accepted_profits'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function account()
    {

        try
        {
            return view('site.users.account');
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function MyCourses()
    {
        try
        {
            $notifications = \Auth::user()->Notifications()->get();

            foreach($notifications as $notification) {
                if($notification->type == 'App\Notifications\activeSubscribtion' || $notification->type == 'App\Notifications\unActiveSubscribtion')
                {
                    $notification->markAsRead();
                }
            }

            $subscribes_ids = Subscribe::where(['user_id' => auth()->id(), 'active' => 1])->get()->pluck('course_id');
            $courses = Course::whereIn('id' , $subscribes_ids)->get();
            return view('site.users.my_courses',compact('courses'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function update(UserRequest $request,$id)
    {
        try
        {
            $user = $this->user->getById(auth()->id());
            if(isset($user))
            {
                $user->update([
                    'name' => $request->name ? $request->name : $user->name,
                    'email' => $request->email ? $request->email : $user->email,
                    'phone' => $request->phone ? $request->phone : $user->phone,
                    'password' => $request->password ? bcrypt($request->password) : $user->password,
                    'image' => $request->image ?  $this->updateFile('image','users',$user->image) : $user->image,
                ]);
                return back()->with('success' , __('lang.updated'));
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

    public function Certificate($id)
    {

        try
        {
            $subscribe = Subscribe::findOrFail($id);
            if(isset($subscribe))
            {
                if($subscribe->user_id == auth()->id() && $subscribe->certificate == 1)
                {
                    return view('site.users.certificate', compact('subscribe'));
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
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function Notifications()
    {

        try
        {
            return view('site.users.notifications');
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function DeleteNotifications()
    {

        try
        {
            $notifications = \Auth::user()->Notifications()->get();

            foreach($notifications as $notification) {
                $notification->delete();
            }
            return back()->with('success' , __('lang.deleted_notifications'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
