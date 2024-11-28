<?php

namespace App\Http\Controllers\Api\About;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AboutResource;

class AboutController extends Controller
{
    public function index()
    {
        try
        {
            $about = About::first();
            return response()->json(['data' => new AboutResource($about),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
