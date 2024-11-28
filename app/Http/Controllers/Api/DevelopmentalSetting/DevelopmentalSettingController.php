<?php

namespace App\Http\Controllers\Api\DevelopmentalSetting;

use App\Http\Controllers\Controller;
use App\Models\DevelopmentSetting;
use Illuminate\Http\Request;

class DevelopmentalSettingController extends Controller
{
    public function getKey($key) {
        $setting = DevelopmentSetting::query()->where('key', $key)->first();
        if ($setting !== null)
            return response()->json([
                'message' => 'success',
                'data' => [
                    $setting->key => $setting->value,
                ]
            ]);
        else
            return response()->json([
                'message' => 'fail, key not found',
                'data' => []
            ], 404);
    }
}
