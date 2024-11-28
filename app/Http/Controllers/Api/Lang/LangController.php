<?php

namespace App\Http\Controllers\Api\Lang;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lang\LangRequest;

class LangController extends Controller
{
    public function index(LangRequest $request)
    {
        app()->setLocale($request->lang);
        $lang =  app()->getLocale();
        return response()->json(['data' => $lang ,'status' => 200]);
    }
}
