<?php

namespace App\Http\Controllers\Admin\Subscribe;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Subscribe;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\activeSubscribtion;
use App\Notifications\unActiveSubscribtion;
use App\Repository\SubscribeRepositoryInterface;
use App\Http\Requests\Subscribe\SubscribeRequest;

class SubscribeController extends Controller
{
    use FileManagerTrait;
    private $subscribe;

    public function __construct(SubscribeRepositoryInterface $subscribe)
    {
        $this->subscribe = $subscribe;
    }


    // public function AllData()
    // {
    //     $segments = request()->segments();
    //     $segment = $segments[2];

    //     return Datatables::of(Subscribe::when($segment != null, function ($query) use ($segment) {
    //         return $query->where(function($q) use ($segment){
    //                 if($segment == 'active')
    //                 {
    //                     return $q->where(['active' => 1]);
    //                 }
    //                 if($segment == 'un-active')
    //                 {
    //                     return $q->where(['active' => 0 , 'start_subscribe' => NULL , 'end_subscribe' => NULL]);
    //                 }
    //                 else
    //                 {
    //                     return $q->where(['active' => 0 , ['end_subscribe' , '!=' , NULL]]);
    //                 }
    //             });
    //         })->with('user')->newQuery())
    //     ->setRowClass(function () {
    //         return 'text-center';
    //     })->editColumn('image', function(Subscribe $subscribe) {
    //         return '<img src="'.asset($subscribe->image).'" style="width:100px; max-height:100px" />';
    //     })
    //     ->addColumn('course', function($item){
    //         return $item->course->title;
    //     })
    //     ->addColumn('created_at', function($item){
    //         return $item->created_at->format('Y-m-d H:i');
    //     })
    //     ->addColumn('activation', function($item){
    //         return $item->active == 1 ? __('lang.active') : __('lang.un_active');
    //     })
    //     ->addColumn('user', function($item){
    //         return '<a href="'.route('users.edit' ,$item->user->id ) .'" style="color:blue" />' . $item->user->name .'</a>';
    //     })
    //     ->addColumn('whatsapp', function($item){
    //         return '<a href="https://wa.me/'.$item->user->whatsapp .'" style="color:blue" />' . $item->user->whatsapp .'</a>';
    //     })
    //     ->addColumn('total', function($item){
    //         return $item->total;
    //     })->addColumn('control', 'dashboard.subscribes.btns')
    //     ->rawColumns(['control', 'course', 'user','whatsapp','image','total','activation','created_at','control'])
    //     ->make(true);
    // }

    public function subscribes($slug)
    {

        try
        {
            if($slug == 'active')
            {
                $subscribes = Subscribe::query()->where('active' , 1)->orderByDesc('id')->get();
            }
            elseif($slug == 'un-active')
            {
                $subscribes = Subscribe::query()->where(['active' => 0 , 'start_subscribe' => NULL , 'end_subscribe' => NULL])->orderByDesc('id')->get();
            }
            else
            {
                $subscribes = Subscribe::query()->where(['active' => 0 , 'end_subscribe'=> NULL , ['start_subscribe','!=' , NULL]])->orderByDesc('id')->get();
            }
            return view('dashboard.subscribes.index',compact('subscribes'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    // public function index()
    // {
    //     try
    //     {
    //         $subscribes = $this->subscribe->getAll();
    //         return view('dashboard.subscribes.index',compact('subscribes'));
    //     }
    //     catch(\Exception $ex)
    //     {
    //         return back()->with('failed' , __('lang.not_found'));
    //     }
    // }

    public function edit($id)
    {
        try
        {
            $subscribe = $this->subscribe->getById($id);
            if(isset($subscribe))
            {
                $subscribe = $this->subscribe->getById($id);
                return view('dashboard.subscribes.edit',compact('subscribe'));
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

    public function update(SubscribeRequest $request,$id)
    {
        try
        {
            $subscribe = $this->subscribe->getById($id);
            if(isset($subscribe))
            {

                $date = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
                $plus = $subscribe->course->peroid;
                $slug = 'active';

                if($subscribe->active == 1)
                {
                    $slug = 'active';
                }
                else
                {
                    $slug = 'un-active';
                }

                if($subscribe->start_subscribe == NULL && $subscribe->end_subscribe == NULL)
                {
                    if($subscribe->coupon)
                    {
                        $coupon = Coupon::where('coupon' , $subscribe->coupon)->first();
                        if($coupon)
                        {
                            $user = User::where(['id' => $coupon->user_id])->first();
                            if($user)
                            {
                                $user->update([
                                    'balance' => $user->balance + $subscribe->difference
                                ]);
                            }
                        }
                    }
                }

                $data = [
                    'active' => $request->active,
                    'start_subscribe' => $request->active == 1 ?  $date->toDateString() : NULL,
                    'end_subscribe' => $request->active == 1 ?  $date->addDays($plus)->toDateString() : NULL
                ];

                $this->subscribe->update($id,$data);
                if($request->active == 1)
                {
                    \Notification::send(User::where(['id' => $subscribe->user_id])->first(), new activeSubscribtion($subscribe));
                }
                if($request->active == 0)
                {

                    \Notification::send(User::where(['id' => $subscribe->user_id])->first(), new unActiveSubscribtion($subscribe));
                }
                return redirect()->route('subscribes-courses',$slug)->with('success' , __('lang.updated'));
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
            $subscribe = $this->subscribe->getById($id);
            if(isset($subscribe))
            {
                $this->subscribe->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function Search(Request $request)
    {
        $key = $request->key;
        $slug = $request->slug;
        $val = $request->search;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $subscribes = [];

        if($key == 'user' || $key == 'whatsapp')
        {
            $relation = 'user';
        }
        else
        {
            $relation = 'course';
        }


        if($slug == 'active')
        {
            $subscribes = Subscribe::where('active' , 1);
        }
        elseif($slug == 'un-active')
        {

            $subscribes = Subscribe::where(['active' => 0 , 'start_subscribe' => NULL , 'end_subscribe' => NULL]);
        }
        else
        {
            $subscribes = Subscribe::where(['active' => 0 , ['end_subscribe' , '!=' , NULL]])->paginate(20);
        }

        $subscribes = $subscribes->when($date_from != null, function ($item) use ($date_from) {
            return $item->where('created_at', '>=' , $date_from);
        })
        ->when($date_to != null, function ($item) use ($date_to) {
            return $item->where('created_at', '<=' , $date_to);
        })
        ->whereHas($relation, function($query) use ($val,$key,$relation){
        if($relation == 'course')
        {
            $query->where('title_ar',"LIKE" , '%'.$val.'%');
            $query->orWhere('title_en',"LIKE" , '%'.$val.'%');
        }
        if($relation == 'user')
        {
            if($key == 'user')
            {
                $query->where('name',"LIKE" , '%'.$val.'%');
            }
            if($key == 'whatsapp')
            {
                $query->where('whatsapp',"LIKE" , '%'.$val.'%');
            }
        }
        })->paginate(20);

        return view('dashboard.subscribes.index',compact('subscribes','val','key','slug'));

    }
}
