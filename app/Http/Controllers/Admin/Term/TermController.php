<?php

namespace App\Http\Controllers\Admin\Term;

use App\Models\Term;
use App\Models\Privacy;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Term\TermRequest;
use App\Repository\TermRepositoryInterface;

class TermController extends Controller
{
    use FileManagerTrait;
    private $term;

    public function __construct(TermRepositoryInterface $term)
    {
        $this->term = $term;
    }

    public function create()
    {
        try
        {
            return view('dashboard.terms.create');
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
            $terms = $this->term->getAll();
            return view('dashboard.terms.index',compact('terms'));
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
            $term = Term::find($id);
            if(isset($term))
            {
                $term = $this->term->getById($id);
                return view('dashboard.terms.edit',compact('term'));
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

    public function store(TermRequest $request)
    {
        try
        {
            $data = [
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'content_ar' => $request->content_ar,
                'content_en' => $request->content_en,
            ];

            $this->term->create($data);
            return redirect()->route('term.index')->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(TermRequest $request,$id)
    {
        try
        {
            $term = Term::find($id);
            if(isset($term))
            {
                $data = [
                    'title_ar' => $request->title_ar,
                    'title_en' => $request->title_en,
                    'content_ar' => $request->content_ar,
                    'content_en' => $request->content_en,
                ];

                $this->term->update($id,$data);
                return redirect()->route('term.index')->with('success' , __('lang.updated'));
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
            $term = Term::find($id);
            if(isset($term))
            {
                $this->term->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
