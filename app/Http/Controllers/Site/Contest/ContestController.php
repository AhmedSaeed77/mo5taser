<?php

namespace App\Http\Controllers\Site\Contest;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\PassExamRepositoryInterface;

class ContestController extends Controller
{
    use FileManagerTrait;
    private $pass;

    public function __construct(PassExamRepositoryInterface $pass)
    {
        $this->pass = $pass;
    }


    public function show($id)
    {
        try
        {
            $pass = $this->pass->getById($id);
            if(isset($pass) && $pass->childLevel->type == 'contest')
            {
                return view('site.contest.index',compact('pass'));
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
