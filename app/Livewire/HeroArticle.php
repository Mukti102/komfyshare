<?php

namespace App\Livewire;

use App\Models\Blog;
use Livewire\Component;

class HeroArticle extends Component
{
    public ?Blog $article = null;
    public function render()
    {
        return view('livewire.hero-article');
    }
}
