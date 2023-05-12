<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class formAuth extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $name;
    public $ph;
    public function __construct($type = null, $name = null, $ph = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->ph = $ph;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-auth');
    }
}
