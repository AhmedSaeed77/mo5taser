<?php

namespace App\Http\Resources;

use App\Http\Resources\NewsResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsPaginateCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            "data" =>  NewsResource::collection($this->collection),
            'status' => 200 ,
        ];
    }
}
