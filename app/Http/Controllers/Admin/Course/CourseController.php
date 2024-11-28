<?php

namespace App\Http\Controllers\Admin\Course;

use App\Models\Admin;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Content;
use App\Models\Category;
use App\Scopes\ActiveScope;
use Illuminate\Http\Request;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Repository\CourseRepositoryInterface;
use App\Repository\ContentRepositoryInterface;

class CourseController extends Controller
{
    use FileManagerTrait;
    private $course ,$content;

    public function __construct(CourseRepositoryInterface $course ,ContentRepositoryInterface $content)
    {
        $this->course = $course;
        $this->content = $content;
    }

    public function index()
    {
        try
        {
            $courses = Course::withoutGlobalScope(ActiveScope::class)->get();
            return view('dashboard.courses.index',compact('courses'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
    public function create()
    {
        try
        {
            $categories = Category::category('course')->get();
            $teachers  = Admin::where('role_id',3)->get();
            return view('dashboard.courses.create',compact('categories','teachers'));
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
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $categories = Category::category('course')->get();
                $teachers  = Admin::where('role_id',3)->get();
                $course_teachers = $course->teachers->pluck('id')->toArray();
                return view('dashboard.courses.edit',compact('categories','teachers','course','course_teachers'));
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
    private function getVideoId($url)
    {
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?.*v=|embed\/|v\/))([^\s&]+)/', $url, $matches)) {
            return $matches[1]; // YouTube video ID
        } elseif (preg_match('/(?:vimeo\.com\/(?:channels\/|groups\/|album\/\d+\/video\/|video\/|ondemand\/|video\/|))(\d+)/', $url, $matches)) {
            return $matches[1]; // Vimeo video ID
        }

        return $url;
    }

    public function store(CourseRequest $request)
    {
        if($request->type == 'free')
        {
            if($request->price > 0)
            {
                return back()->with('failed' , __('lang.free_error_course'));
            }
        } else {
            if($request->price <= 0)
            {
                return back()->with('failed' , __('lang.paid_error_course'));
            }
        }
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'desc_ar' => $request->desc_ar,
                'desc_en' => $request->desc_en,
                'peroid' => $request->peroid,
                'course_group' => $request->course_group,
                'price' => $request->price,
                'open' => $request->open,
                'start_date' => $request->start_date,
                'subscribers' => $request->subscribers,
                'course_bag' => $request->course_bag,
                'subscribed_bag' => $request->subscribed_bag,
                'course_table' => $request->course_table,
                'price_after' => $request->price_after,
                'active' => $request->active,
                'type' => $request->type,
                'preview_video' => $request->preview_video,
                'preview_video_platform' => $request->preview_video_platform,
                'preview_video_id' => $this->getVideoId($request->preview_video),
                'category_id' => $request->category_id,
                'image' => $this->upload('image','courses'),
            ];
            $course = $this->course->create($data);
            $course->teachers()->sync($request->teachers);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(CourseRequest $request,$id)
    {
        if($request->type == 'free')
        {
            if($request->price > 0)
            {
                return back()->with('failed' , __('lang.free_error_course'));
            }
        } else {
            if($request->price <= 0)
            {
                return back()->with('failed' , __('lang.paid_error_course'));
            }
        }
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'desc_ar' => $request->desc_ar,
                    'desc_en' => $request->desc_en,
                    'peroid' => $request->peroid,
                    'course_group' => $request->course_group,
                    'price' => $request->price,
                    'open' => $request->open,
                    'start_date' => $request->start_date,
                    'subscribers' => $request->subscribers,
                    'price_after' => $request->price_after,
                    'active' => $request->active,
                    'type' => $request->type,
                    'course_bag' => $request->course_bag,
                    'subscribed_bag' => $request->subscribed_bag,
                    'course_table' => $request->course_table,
                    'preview_video' => $request->preview_video,
                    'preview_video_platform' => $request->preview_video_platform,
                    'preview_video_id' => $this->getVideoId($request->preview_video),
                    'category_id' => $request->category_id,
                    'image' => $request->image ?  $this->updateFile('image','courses',$course->image) : $course->image,
                ];
                $finalPrice = $request->price_after ?? $request->price;
                $carts = Cart::query()->where('course_id', $course->id)->get();
                foreach ($carts as $cart) {
                    if ($cart->coupon !== null) {
                        $coupon = Coupon::query()->where('coupon', $cart->coupon)->first();
                        if ($coupon !== null) {
                            if ($coupon->discount_number !== null) {
                                $cart->update([
                                    'difference' => $finalPrice - $coupon->discount_number > 0 ? $coupon->discount_number : null,
                                    'price' => $finalPrice - $coupon->discount_number > 0 ? $finalPrice - $coupon->discount_number : $finalPrice
                                ]);
                            } elseif ($coupon->discount !== null) {
                                $cart->update([
                                    'difference' => $finalPrice * $coupon->discount / 100,
                                    'price' => $finalPrice * (100 - $coupon->discount) / 100,
                                ]);
                            }
                        }
                    } else {
                        $cart->update([
                            'price' => $finalPrice,
                        ]);
                    }
                }
                $course->update($data);
                $course->teachers()->sync($request->teachers);
                return redirect()->route('courses.index')->with('success' , __('lang.updated'));
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
        }
        catch(\Exception $ex)
        {
//            dd($ex);
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function destroy($id)
    {
        try
        {
            $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($id);
            if(isset($course))
            {
                $course->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }



    public function copyContent(Request $request)
    {
        if(!$request->course_id)
        {
            return back()->with('failed' , __('lang.select_course'));
        }

        $course = Course::withoutGlobalScope(ActiveScope::class)->findOrFail($request->course_id);

        try
        {
            if(isset($course))
            {
                $contents = Content::withoutGlobalScope(ActiveScope::class)->where('course_id',$course->id)->get();
            }
            else
            {
                return back()->with('failed' , __('lang.not_found'));
            }
            if($contents->count() > 0)
            {
                foreach($contents as $key => $item)
                {
                    $attach_path = NULL;
                    $image_path = NULL;
                    if($item->attachement)
                    {
                        $paths = explode("/", $item->attachement);
                        \File::copy(storage_path('app/public/courses/'.$paths[2]), storage_path('app/public/courses/'.'copy_'.$paths[2]));
                        $attach_path = 'storage/courses/'.$paths[2];
                    }
                    if($item->image)
                    {
                        $paths2 = explode("/", $item->image);
                        \File::copy(storage_path('app/public/courses/'.$paths2[2]), storage_path('app/public/courses/'.'copy_'.$paths2[2]));
                        $image_path = 'storage/courses/'.$paths2[2];
                    }


                    $data = [
                        'title_ar' => $item->title_ar,
                        'title_en' => $item->title_en,
                        'desc_ar' => $item->desc_ar,
                        'desc_en' => $item->desc_en,
                        'type' => $item->type,
                        'sort' => $item->sort,
                        'active' => $item->active,
                        'attempts_count' => $item->attempts_count,
                        'course_id' => $course->id,
                        'video_url' => $item->video_url,
                        'live_url' => $item->live_url,
                        'recorded_url' => $item->recorded_url,
                        'zoom_time' => $item->zoom_time,
                        'download' => $item->download,
                        'questions_number' => $item->questions_number,
                        'exam_time' => $item->exam_time,
                        'parent_id' => $item->parent_id,
                        'attachement' => $attach_path,
                        'image' => $image_path,
                    ];

                    $this->content->create($data);
                }
                return back()->with('success' , __('lang.added'));
            }
            else
            {
                return back()->with('failed' , __('lang.no_content_yet'));
            }

        }
        catch(\Exception $ex)
        {

            return back()->with('failed' , __('lang.not_found'));
        }
    }

//    public function
}
