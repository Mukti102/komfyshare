<?php

namespace App\View\Components;

use App\Models\Faq as ModelsFaq;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Faq extends Component
{
    /**
     * Create a new component instance.
     */
    public $faqs;
    public function __construct()
    {
         $faqs = ModelsFaq::all();

        $this->faqs = $faqs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.faq');
    }
}
