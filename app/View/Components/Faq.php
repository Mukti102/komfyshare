<?php

namespace App\View\Components;

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
         $faqs = [
            [
                'question' => 'Apa itu KomfyShare?',
                'answer' => 'KomfyShare adalah platform untuk berbagi akun berlangganan secara aman.',
            ],
            [
                'question' => 'Bagaimana cara kerja KomfyShare?',
                'answer' => 'Pengguna bisa membuat grup langganan dan berbagi biaya bersama.',
            ],
            [
                'question' => 'Bagaimana KomfyShare berbeda dari platform berlangganan lainnya?',
                'answer' => 'KomfyShare lebih fokus pada kolaborasi biaya bersama dalam satu grup.',
            ],
        ];

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
