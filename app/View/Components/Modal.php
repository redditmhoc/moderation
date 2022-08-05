<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $alpineShow)
    {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.modal');
    }
}