<?php

namespace App\Http\Controllers\Admin\Info;

use App\Models\Info;
use App\Models\Team;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Info\InfoRequest;
use App\Http\Requests\Team\TeamRequest;
use App\Repository\InfoRepositoryInterface;

class InfoController extends Controller
{
    use FileManagerTrait;
    private $info;

    public function __construct(InfoRepositoryInterface $info)
    {
        $this->info = $info;
    }

    public function index()
    {
        try
        {
            $infos = $this->info->getAll();
            return view('dashboard.infos.index',compact('infos'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $info = Info::find($id);
        try
        {
            if(isset($info))
            {
                $info = $this->info->getById($id);
                return view('dashboard.infos.edit',compact('info'));
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

    public function store(InfoRequest $request)
    {
        try
        {
            $data = [
                'email' => $request->email,
                'address_ar' => $request->address_ar,
                'address_en' => $request->address_en,
                'phone' => $request->phone,
                'whatsapp' => $request->whatsapp,
                'full' => $request->full,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'video' => $request->video,
                'video_platform' => $request->video_platform,
                'video_id' => $this->getVideoId($request->video),
                'tax_number' => $request->tax_number,
                'tax' => $request->tax,
                'min_profit' => $request->min_profit,
            ];

            $this->info->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(InfoRequest $request,$id)
    {
        try
        {
            $info = Info::find($id);
            if(isset($info))
            {
                $data = [
                    'email' => $request->email,
                    'address_ar' => $request->address_ar,
                    'address_en' => $request->address_en,
                    'phone' => $request->phone,
                    'whatsapp' => $request->whatsapp,
                    'full' => $request->full,
                    'facebook' => $request->facebook,
                    'instagram' => $request->instagram,
                    'twitter' => $request->twitter,
                    'video' => $request->video,
                    'video_platform' => $request->video_platform,
                    'video_id' => $this->getVideoId($request->video),
                    'tax_number' => $request->tax_number,
                    'tax' => $request->tax,
                    'min_profit' => $request->min_profit,
                ];

                $this->info->update($id,$data);
                return redirect()->route('info.index')->with('success' , __('lang.updated'));
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
            $info = Info::find($id);
            if(isset($info))
            {
                $this->info->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
