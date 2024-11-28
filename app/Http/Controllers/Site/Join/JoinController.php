<?php

namespace App\Http\Controllers\Site\Join;

use App\Models\Image;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Join\JoinRequest;
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
        try
        {
            $image = Image::first();
            return view('site.joins.index',compact('image'));
        }
        catch(Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function store(JoinRequest $request)
    {
        try
        {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'cv' => $this->upload('cv','joins'),
                'status' => 'unread',
            ];

            $this->join->create($data);
            return back()->with('success' , __('lang.sent'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
