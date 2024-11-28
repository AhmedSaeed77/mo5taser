<?php

namespace App\Http\Controllers\Admin\Testimonail;

use App\Models\Testimonail;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\TestimonailRepositoryInterface;
use App\Http\Requests\Testimonail\TestimonailRequest;

class TestimonailController extends Controller
{
    use FileManagerTrait;
    private $testimonail;

    public function __construct(TestimonailRepositoryInterface $testimonail)
    {
        $this->testimonail = $testimonail;
    }

    public function index()
    {
        try
        {
            $testimonails = $this->testimonail->getAll();
            return view('dashboard.testimonails.index',compact('testimonails'));
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
            $testimonail =Testimonail::find($id);
            if(isset($testimonail))
            {
                $testimonail = $this->testimonail->getById($id);
                return view('dashboard.testimonails.edit',compact('testimonail'));
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

    public function store(TestimonailRequest $request)
    {
        try
        {
            $data = [
                'comment_ar' => $request->comment_ar,
                'comment_en' => $request->comment_en,
                'image' => $this->upload('image','testimonails'),
            ];

            $this->testimonail->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(TestimonailRequest $request,$id)
    {
        try
        {
            $testimonail = Testimonail::find($id);
            if(isset($testimonail))
            {
                $data = [
                    'comment_ar' => $request->comment_ar,
                    'comment_en' => $request->comment_en,
                    'image' => $request->image ?  $this->updateFile('image','testimonails',$testimonail->image) : $testimonail->image,
                ];

                $this->testimonail->update($id,$data);
                return redirect()->route('testimonail.index')->with('success' , __('lang.updated'));
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
            $testimonail =Testimonail::find($id);
            if(isset($testimonail))
            {
                $this->testimonail->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
