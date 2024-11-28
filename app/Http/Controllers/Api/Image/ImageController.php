<?php

namespace App\Http\Controllers\Api\Image;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    public function index()
    {
        try
        {
            $image = Image::first();
            return response()->json(['data' => new ImageResource($image),'status' => 200]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['data' => __('lang.not_found'),'status' => 400]);
        }
    }
}
