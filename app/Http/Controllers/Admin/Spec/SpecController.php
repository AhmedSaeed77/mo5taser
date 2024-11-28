<?php

namespace App\Http\Controllers\Admin\Spec;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Spec\SpecRequest;
use App\Repository\SpecRepositoryInterface;

class SpecController extends Controller
{
    use FileManagerTrait;
    private $spec;

    public function __construct(SpecRepositoryInterface $spec)
    {
        $this->spec = $spec;
    }

    public function index()
    {
        try
        {
            $specs = $this->spec->getAll();
            return view('dashboard.specs.index',compact('specs'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $spec = $this->spec->getById($id);
        try
        {
            if(isset($spec))
            {
                return view('dashboard.specs.edit',compact('spec'));
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

    public function store(SpecRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
            ];

            $this->spec->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(SpecRequest $request,$id)
    {
        $spec = $this->spec->getById($id);
        try
        {
            if(isset($spec))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                ];

                $this->spec->update($id,$data);
                return redirect()->route('spec.index')->with('success' , __('lang.updated'));
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
        $spec = $this->spec->getById($id);
        try
        {
            if(isset($spec))
            {
                $this->spec->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
