<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TimeComponent extends Component
{
    public $time;
    public $articleId;

    /**
     * Create a new component instance.
     *
     * @param $time
     * @param $articleId
     */
    public function __construct($time, $articleId)
    {

        $this->time = $time;
        $this->articleId = $articleId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.time-component');
    }
}
