<?php

namespace App\Http\Controllers\Admin\Join;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Repository\JoinRepositoryInterface;

class JoinController extends Controller
{
    use FileManagerTrait;
    private $join;

    public function __construct(JoinRepositoryInterface $join)
    {
        $this->join = $join;
    }

    public function index()
    {
        $joins = $this->join->getAll();
        try
        {
            return view('dashboard.joins.index',compact('joins'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function show($id)
    {
        $join = $this->join->getById($id);
        try
        {
            if(isset($join))
            {
                $join->update(['status' => 'read']);
                return view('dashboard.joins.show',compact('join'));
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


    public function destroy($id)
    {
        $join = $this->join->getById($id);
        try
        {
            if(isset($join))
            {
                $this->join->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
