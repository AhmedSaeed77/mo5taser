<?php

namespace App\Http\Controllers\Site\Rating;

use App\Traits\FileManagerTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\RatingRequest;
use App\Repository\RatingRepositoryInterface;

class RatingController extends Controller
{
    private $rating;

    public function __construct(RatingRepositoryInterface $rating)
    {
        $this->rating = $rating;
    }
    public function store(RatingRequest $request)
    {
        try
        {
            $data = [
                'comment' => $request->comment,
                'rating' => $request->rating,
                'user_id' => auth()->id(),
                'course_id' => $request->course_id
            ];

            $this->rating->create($data);
            return back()->with('success' , __('lang.added'));
        }
        catch(\Exception $ex)
        {
            return back()->with('failed' , __('lang.not_found'));
        }
    }

}
