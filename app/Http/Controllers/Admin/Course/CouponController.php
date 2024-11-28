<?php

namespace App\Http\Controllers\Admin\Course;

use App\Models\Admin;
use App\Models\Course;
use App\Models\Category;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CouponRequest;
use App\Http\Requests\Course\CourseRequest;
use App\Repository\UserRepositoryInterface;
use App\Repository\CouponRepositoryInterface;
use App\Repository\CourseRepositoryInterface;

class CouponController extends Controller
{
    use FileManagerTrait;
    private $coupon , $user;

    public function __construct(CouponRepositoryInterface $coupon ,UserRepositoryInterface $user)
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    public function index()
    {
        try
        {
            $users = $this->user->getAll();
            $courses  = Course::all();
            $coupons = $this->coupon->getAll(['*'], ['course']);
            return view('dashboard.coupons.index',compact('coupons','courses','users'));
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
            $coupon = $this->coupon->getById($id);
            if(isset($coupon))
            {
                $courses  = Course::get();
                $users = $this->user->getAll();
                return view('dashboard.coupons.edit',compact('coupon','courses','users'));
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

    public function store(CouponRequest $request)
    {
        if(!$request->discount && !$request->discount_number)
        {
            return back()->with('failed' , __('lang.must_add_discount'));
        }
        try
        {
            $data = [
                'coupon' => $request->coupon,
                'course_id' => $request->course_id,
                'user_id' => $request->user_id,
                'type' => $request->type,
                'discount' => $request->discount,
                'discount_number' => $request->discount_number,
                'use_number' => $request->use_number,
            ];

            $coupon = $this->coupon->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(CouponRequest $request,$id)
    {
        if(!$request->discount && !$request->discount_number)
        {
            return back()->with('failed' , __('lang.must_add_discount'));
        }
        try
        {
            $coupon = $this->coupon->getById($id);
            if(isset($coupon))
            {
                $data = [
                    'coupon' => $request->coupon,
                    'course_id' => $request->course_id,
                    'user_id' => $request->user_id,
                    'type' => $request->type,
                    'discount' => $request->discount,
                    'discount_number' => $request->discount_number,
                    'use_number' => $request->use_number,
                ];

                $coupon->update($data);
                return redirect()->route('coupon.index')->with('success' , __('lang.updated'));
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
            $coupon = $this->coupon->getById($id);
            if(isset($coupon))
            {
                $this->coupon->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
