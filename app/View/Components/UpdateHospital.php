<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UpdateHospital extends Component
{
    public $hospital;
    /**
     * Create a new component instance.
     */
    public function __construct($hospital = null)
    {
        $this->hospital = $hospital;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.update-hospital');
    }
}
