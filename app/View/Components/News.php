<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Repository\NewsRepositoryInterface;

class News extends Component
{
    public $new;

    public function __construct(NewsRepositoryInterface $new)
    {
        $this->new = $new;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $news = $this->new->getLatest();
        return view('components.news',compact('news'));
    }
}
