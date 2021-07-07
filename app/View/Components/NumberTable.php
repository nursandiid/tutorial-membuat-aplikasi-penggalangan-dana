<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NumberTable extends Component
{

    public $key;

    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($key, $model)
    {
        $this->key = $key;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.number-table');
    }
}
