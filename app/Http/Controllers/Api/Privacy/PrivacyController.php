<?php

namespace App\Http\Controllers\Api\Privacy;

use App\Models\Privacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModelCollection;
use App\Http\Resources\PrivacyResource;

class PrivacyController extends Controller
{
    public function index()
    {
        try
        {
            $privacies = Privacy::get();
            return response()->json(['data' => new ModelCollection(PrivacyResource::collection($privacies)),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
