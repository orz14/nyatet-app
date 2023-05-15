<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ckeditor extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public $ph;
    public $value;
    public function __construct($name = null, $ph = null, $value = null)
    {
        $this->name = $name;
        $this->ph = $ph;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ckeditor');
    }
}
