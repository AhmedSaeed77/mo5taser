<?php

namespace App\Http\Resources;

use App\Http\Resources\CourseResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CoursePaginateCollection extends ResourceCollection
{

    public function toArray($request)
    {
        return [
            "data" =>  CourseResource::collection($this->collection),
            'status' => 200 ,
        ];
    }
}
