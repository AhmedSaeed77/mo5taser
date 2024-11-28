<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repository\WhyRepositoryInterface;

class WhyUs extends Component
{
    public $why;

    public function __construct(WhyRepositoryInterface $why)
    {
        $this->why = $why;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $whys = $this->why->getAll();
        return view('components.why-us',compact('whys'));
    }
}
