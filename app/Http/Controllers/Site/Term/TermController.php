<?php

namespace App\Http\Controllers\Site\Term;

use App\Models\Term;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\TermRepositoryInterface;

class TermController extends Controller
{
    use FileManagerTrait;
    private $term;

    public function __construct(TermRepositoryInterface $term)
    {
        $this->term = $term;
    }

    public function index()
    {
        try
        {
            $terms = $this->term->getAll();
            return view('site.terms.index',compact('terms'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
