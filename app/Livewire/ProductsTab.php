<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class ProductsTab extends Component
{
    public $activeCategory = 'all'; // default semua kategori

    public function render()
    {
        return view('livewire.products-tab', [
            'categories' => Category::with('products')->get(),
        ]);
    }
}
