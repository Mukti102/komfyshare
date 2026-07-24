<?php

namespace App\Services\Checker\Calculators;

use App\Models\CheckerQuestion;
use App\Services\Checker\Contracts\PricingCalculator;

class MultiplyCalculator implements PricingCalculator
{
    public function calculate(CheckerQuestion $question, mixed $answer, array $uploads): float
    {
        $quantity = (int) ($answer ?? 0);

        return $quantity * (float) $question->unit_price;
    }
}
