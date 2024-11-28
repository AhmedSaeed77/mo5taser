<?php

namespace App\View\Components;

use App\Models\Category;
use App\Models\PassExam;
use Illuminate\View\Component;
use App\Repository\TestimonailRepositoryInterface;

class Testimonail extends Component
{
    public $testimonail;

    public function __construct(TestimonailRepositoryInterface $testimonail)
    {
        $this->testimonail = $testimonail;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $testimonails = $this->testimonail->getAll();
        $categories = Category::category('contest')->where('parent_id','!=',NULL)->get();
        $pass_contests = PassExam::query()->whereHas('questions')->whereIn('level',$categories->pluck('id')->toArray())->get();
        return view('components.testimonail',compact('testimonails','pass_contests'));
    }
}
