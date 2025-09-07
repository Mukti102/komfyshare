<?php

namespace App\Livewire;

use App\Models\Group;
use Livewire\Component;

class BoxGroupList extends Component
{   
    public $product;
    public $groups;

    public function mount($product)
    {
        $this->product = $product;
        $this->groups = collect(); // kosong dulu
        $this->loadGroups();
    }

    public function loadGroups()
    {   
        $this->groups = $this->product?->groups ?? collect();
    }

    public function render()
    {
        return view('livewire.box-group-list');
    }
}
