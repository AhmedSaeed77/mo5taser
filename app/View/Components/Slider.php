<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repository\SliderRepositoryInterface;

class Slider extends Component
{
    public $slider;

    public function __construct(SliderRepositoryInterface $slider)
    {
        $this->slider = $slider;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $sliders = $this->slider->getAll();
        return view('components.slider',compact('sliders'));
    }
}
