<?php

namespace App\Http\Controllers\Admin\Assemble;

use App\Models\Category;
use App\Models\Assemble;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Assemble\AssembleRequest;


class AssembleController extends Controller
{
    use FileManagerTrait;
    public function index()
    {
        try
        {
            $categories = Category::category('assemblies')->where('parent_id',NULL)->get();
            $assemblies = Assemble::get();
            return view('dashboard.assemblies.index',compact('assemblies','categories'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $assemble = Assemble::find($id);
        try
        {
            if(isset($assemble))
            {
                $categories = Category::category('assemblies')->where('parent_id',NULL)->get();
                // $childs = Category::category('assemblies')->whereIn('parent_id',$categories->pluck('id')->toArray())->get();
                return view('dashboard.assemblies.edit',compact('assemble','categories'));
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

    public function store(AssembleRequest $request)
    {
        try
        {
            $data = $request->validated();
            if($request->type == 'video')
            {
                unset($data['book_preview'],$data['book'],$data['price']);
                $data['video_id'] = $this->getVideoId($data['link']);
            }
            elseif($request->type == 'book')
            {
                unset($data['link']);
                $data['book'] = $this->upload('book','assemblies');
                $data['book_preview'] = $this->upload('book_preview','assemblies');
            }

            $data['image'] = $this->upload('image','assemblies');

            $assemble = Assemble::create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(AssembleRequest $request, $id)
    {
        $assemble = Assemble::find($id);
        try
        {
            if(isset($assemble))
            {
                $data = $request->validated();
                if($request->type == 'video')
                {
                    unset($data['book_preview'],$data['book'],$data['price']);
                    $data['video_id'] = $this->getVideoId($data['link']);
                }
                elseif($request->type == 'book')
                {
                    unset($data['link']);
                    $data['book'] = $request->book ? $this->updateFile('book','assemblies',$assemble->book) : $assemble->book;
                    $data['book_preview'] = $request->book_preview ? $this->updateFile('book_preview','assemblies',$assemble->book_preview) : $assemble->book_preview;
                }

                $data['image'] = $request->image ? $this->updateFile('image','assemblies',$assemble->image) : $assemble->image;

                $assemble->update($data);
                return redirect()->route('assemble.index')->with('success' , __('lang.updated'));
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
            $assemble = Assemble::find($id);
            if(isset($assemble))
            {
                $assemble->delete();
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }


    public function getLevels(Request $request)
    {
        $department_id = $request->department_id;
        if($department_id != NULL)
        {
            $levels = Category::where(['parent_id' => $department_id,'type' => 'assemblies'])->get();
        }
        else
        {
            $levels = '';
        }
        return response()->json($levels);
    }
}
