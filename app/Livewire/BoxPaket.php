<?php

namespace App\Livewire;

use Livewire\Component;

class BoxPaket extends Component
{   

    public $prices;
    public $selectedPriceId;

    public function mount($prices)
    {
        $this->prices = $prices;
    }

    public function selectPrice($priceId)
    {
        $this->selectedPriceId = $priceId;
    }

    public function render()
    {
        return view('livewire.box-paket');
    }
}
