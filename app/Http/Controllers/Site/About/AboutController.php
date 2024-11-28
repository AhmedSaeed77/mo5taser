<?php

namespace App\Http\Controllers\Site\About;

use App\Models\About;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\About\AboutRequest;
use App\Repository\TeamRepositoryInterface;
use App\Repository\AboutRepositoryInterface;

class AboutController extends Controller
{
    use FileManagerTrait;
    private $about;
    private $team;

    public function __construct(AboutRepositoryInterface $about,TeamRepositoryInterface $team)
    {
        $this->about = $about;
        $this->team = $team;
    }

    public function index()
    {
        $about = $this->about->getFirst();
        try
        {
            if(isset($about))
            {
                $teams = $this->team->getAll();
                return view('site.abouts.index',compact('about','teams'));
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

}
