<?php

namespace App\Http\Controllers\Api\Team;

use App\Models\Team;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Http\Resources\ModelCollection;

class TeamController extends Controller
{
    public function index()
    {
        try
        {
            $teams = Team::get();
            return response()->json(['data' => new ModelCollection(TeamResource::collection($teams)),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
