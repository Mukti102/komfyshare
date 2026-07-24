<?php

namespace App\Services\Checker\Calculators;

use App\Models\CheckerQuestion;
use App\Services\Checker\Contracts\PricingCalculator;

class NoneCalculator implements PricingCalculator
{
    public function calculate(CheckerQuestion $question, mixed $answer, array $uploads): float
    {
        return 0;
    }
}
