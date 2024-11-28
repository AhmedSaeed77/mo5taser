<?php

namespace App\Http\Controllers\Api\Term;

use App\Models\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TermResource;
use App\Http\Resources\ModelCollection;

class TermController extends Controller
{
    public function index()
    {
        try
        {
            $terms = Term::get();
            return response()->json(['data' => new ModelCollection(TermResource::collection($terms)),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
