<?php

namespace App\Http\Controllers\Admin\About;

use App\Models\About;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\About\AboutRequest;
use App\Repository\AboutRepositoryInterface;

class AboutController extends Controller
{
    use FileManagerTrait;
    private $about;

    public function __construct(AboutRepositoryInterface $about)
    {
        $this->about = $about;
    }

    public function index()
    {
        try
        {
            $abouts = $this->about->getAll();
            return view('dashboard.abouts.index',compact('abouts'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $about = About::find($id);
        try
        {
            if(isset($about))
            {
                $about = $this->about->getById($id);
                return view('dashboard.abouts.edit',compact('about'));
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

    public function store(AboutRequest $request)
    {
        try
        {
            $data = [
                'about_ar' => $request->about_ar,
                'about_en' => $request->about_en,
                'image' => $this->upload('image','abouts'),
                'cover' => $this->upload('cover','abouts'),
            ];

            $this->about->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(AboutRequest $request,$id)
    {
        $about = About::find($id);
        try
        {
            if(isset($about))
            {
                $data = [
                    'about_ar' => $request->about_ar,
                    'about_en' => $request->about_en,
                    'image' => $request->image ?  $this->updateFile('image','abouts',$about->image) : $about->image,
                    'cover' => $request->cover ?  $this->updateFile('cover','abouts',$about->cover) : $about->cover,
                ];

                $this->about->update($id,$data);
                return redirect()->route('about.index')->with('success' , __('lang.updated'));
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
            $about = About::find($id);
            if(isset($about))
            {
                $about->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
