<?php

namespace App\Http\Controllers\Admin\Image;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Image\ImageRequest;
use App\Repository\ImageRepositoryInterface;

class ImageController extends Controller
{
    use FileManagerTrait;
    private $image;

    public function __construct(ImageRepositoryInterface $image)
    {
        $this->image = $image;
    }

    public function index()
    {
        try
        {
            $images = $this->image->getAll();
            return view('dashboard.images.index',compact('images'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $image = $this->image->getById($id);
        try
        {
            if(isset($image))
            {
                $image = $this->image->getById($id);
                return view('dashboard.images.edit',compact('image'));
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

    public function store(ImageRequest $request)
    {
        try
        {
            $data = [
                'image_login' => $this->upload('image_login','images'),
                'image_register' => $this->upload('image_register','images'),
                'image_join_us' => $this->upload('image_join_us','images'),
                'image_top_logo' => $this->upload('image_top_logo','images'),
                'image_footer_logo' => $this->upload('image_footer_logo','images'),
                'image_fav' => $this->upload('image_fav','images'),
            ];

            $this->image->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(ImageRequest $request,$id)
    {
        $image = $this->image->getById($id);
        try
        {
            if(isset($image))
            {
                $data = [
                    'image_login' => $request->image_login ?  $this->updateFile('image_login','images',$image->image_login) : $image->image_login,
                    'image_register' => $request->image_register ?  $this->updateFile('image_register','images',$image->image_register) : $image->image_register,
                    'image_join_us' => $request->image_join_us ?  $this->updateFile('image_join_us','images',$image->image_join_us) : $image->image_join_us,
                    'image_top_logo' => $request->image_top_logo ?  $this->updateFile('image_top_logo','images',$image->image_top_logo) : $image->image_top_logo,
                    'image_footer_logo' => $request->image_footer_logo ?  $this->updateFile('image_footer_logo','images',$image->image_footer_logo) : $image->image_footer_logo,
                    'image_fav' => $request->image_fav ?  $this->updateFile('image_fav','images',$image->image_fav) : $image->image_fav,
                ];

                $this->image->update($id,$data);
                return redirect()->route('image.index')->with('success' , __('lang.updated'));
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
            $image = $this->image->getById($id);
            if(isset($image))
            {
                $image->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
