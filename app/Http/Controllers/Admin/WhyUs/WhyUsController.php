<?php

namespace App\Http\Controllers\Admin\WhyUs;

use App\Models\Team;
use App\Models\WhyUs;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Why\WhyRequest;
use App\Http\Requests\Team\TeamRequest;
use App\Repository\WhyRepositoryInterface;
use App\Repository\TeamRepositoryInterface;

class WhyUsController extends Controller
{
    use FileManagerTrait;
    private $why;

    public function __construct(WhyRepositoryInterface $why)
    {
        $this->why = $why;
    }

    public function index()
    {
        try
        {
            $whys = $this->why->getAll();
            return view('dashboard.whys.index',compact('whys'));
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
            $why = WhyUs::find($id);
            if(isset($why))
            {
                $why = $this->why->getById($id);
                return view('dashboard.whys.edit',compact('why'));
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

    public function store(WhyRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'content_ar' => $request->content_ar,
                'content_en' => $request->content_en,
            ];

            $this->why->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(WhyRequest $request,$id)
    {
        try
        {
            $why = WhyUs::find($id);
            if(isset($why))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'content_ar' => $request->content_ar,
                    'content_en' => $request->content_en,
                ];

                $this->why->update($id,$data);
                return redirect()->route('why-us.index')->with('success' , __('lang.updated'));
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
            $why = WhyUs::find($id);
            if(isset($why))
            {
                $this->why->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
