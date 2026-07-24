<?php

namespace App\Services\Checker\Contracts;

use App\Models\CheckerQuestion;

interface PricingCalculator
{
    /**
     * Calculate the price contribution of a single question.
     *
     * @param CheckerQuestion $question The question with pricing_rule and unit_price
     * @param mixed $answer The user's answer (string, int, array of option IDs, or null)
     * @param array $uploads Array of uploaded files (UploadedFile instances)
     * @return float The price contribution
     */
    public function calculate(CheckerQuestion $question, mixed $answer, array $uploads): float;
}
