<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $size;
    public $method;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($size = 'modal-md', $method = 'post')
    {
        $this->size = $size;
        $this->method = $method;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
