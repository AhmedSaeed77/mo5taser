<?php

namespace App\Http\Controllers\Admin\Team;

use App\Models\Team;
use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamRequest;
use App\Repository\TeamRepositoryInterface;

class TeamController extends Controller
{
    use FileManagerTrait;
    private $team;

    public function __construct(TeamRepositoryInterface $team)
    {
        $this->team = $team;
    }

    public function index()
    {
        try
        {
            $teams = $this->team->getAll();
            return view('dashboard.teams.index',compact('teams'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function edit($id)
    {
        $team = Team::find($id);
        try
        {
            if(isset($team))
            {
                $team = $this->team->getById($id);
                return view('dashboard.teams.edit',compact('team'));
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

    public function store(TeamRequest $request)
    {
        try
        {
            $data = [
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'job_ar' => $request->job_ar,
                'job_en' => $request->job_en,
                'image' => $this->upload('image','teams'),
            ];

            $this->team->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

    public function update(TeamRequest $request,$id)
    {
        try
        {
            $team = Team::find($id);
            if(isset($team))
            {
                $data = [
                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'job_ar' => $request->job_ar,
                    'job_en' => $request->job_en,
                    'image' => $request->image ?  $this->updateFile('image','teams',$team->image) : $team->image,
                ];

                $this->team->update($id,$data);
                return redirect()->route('team.index')->with('success' , __('lang.updated'));
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
            $team = Team::find($id);
            if(isset($team))
            {
                $this->team->delete($id);
                return back()->with('success' , __('lang.deleted'));
            }
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }
}
