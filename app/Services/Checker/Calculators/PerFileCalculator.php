<?php

namespace App\Services\Checker\Calculators;

use App\Models\CheckerQuestion;
use App\Services\Checker\Contracts\PricingCalculator;

class PerFileCalculator implements PricingCalculator
{
    public function calculate(CheckerQuestion $question, mixed $answer, array $uploads): float
    {
        $fileCount = count($uploads);

        return $fileCount * (float) $question->unit_price;
    }
}
