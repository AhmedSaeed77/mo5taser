<?php

namespace App\Http\Controllers\Admin\Slider;

use App\Models\Slider;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Slider\SliderRequest;
use App\Repository\SliderRepositoryInterface;

class SliderController extends Controller
{
    use FileManagerTrait;
    private $slider;

    public function __construct(SliderRepositoryInterface $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {
        try
        {
            $sliders = $this->slider->getAll();
            return view('dashboard.sliders.index',compact('sliders'));
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
            $slider = Slider::find($id);
            if(isset($slider))
            {
                $slider = $this->slider->getById($id);
                return view('dashboard.sliders.edit',compact('slider'));
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

    public function store(SliderRequest $request)
    {
        try
        {
            $data = [
                'image' => $this->upload('image','sliders'),
            ];

            $this->slider->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(SliderRequest $request,$id)
    {
        try
        {
            $slider = Slider::find($id);
            if(isset($slider))
            {
                $data = [
                    'image' => $request->image ?  $this->updateFile('image','sliders',$slider->image) : $slider->image,
                ];

                $this->slider->update($id,$data);
                return redirect()->route('slider.index')->with('success' , __('lang.updated'));
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
            $slider = Slider::find($id);
            if(isset($slider))
            {
                $this->slider->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
