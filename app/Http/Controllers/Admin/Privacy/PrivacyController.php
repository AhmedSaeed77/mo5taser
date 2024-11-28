<?php

namespace App\Http\Controllers\Admin\Privacy;

use App\Models\Privacy;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Privacy\PrivacyRequest;
use App\Repository\PrivacyRepositoryInterface;

class PrivacyController extends Controller
{
    use FileManagerTrait;
    private $privacy;

    public function __construct(PrivacyRepositoryInterface $privacy)
    {
        $this->privacy = $privacy;
    }

    public function create()
    {
        try
        {
            return view('dashboard.privacies.create');
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function index()
    {
        try
        {
            $privacies = $this->privacy->getAll();
            return view('dashboard.privacies.index',compact('privacies'));
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
            $privacy = Privacy::find($id);
            if(isset($privacy))
            {
                $privacy = $this->privacy->getById($id);
                return view('dashboard.privacies.edit',compact('privacy'));
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

    public function store(PrivacyRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'content_ar' => $request->content_ar,
                'content_en' => $request->content_en,
            ];

            $this->privacy->create($data);
            return redirect()->route('privacy.index')->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(PrivacyRequest $request,$id)
    {
        try
        {
            $privacy = Privacy::find($id);
            if(isset($privacy))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'content_ar' => $request->content_ar,
                    'content_en' => $request->content_en,
                ];

                $this->privacy->update($id,$data);
                return redirect()->route('privacy.index')->with('success' , __('lang.updated'));
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
            $privacy = Privacy::find($id);
            if(isset($privacy))
            {
                $this->privacy->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
