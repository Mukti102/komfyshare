<?php

namespace App\Services\Checker\Calculators;

use App\Models\CheckerQuestion;
use App\Models\CheckerQuestionOption;
use App\Services\Checker\Contracts\PricingCalculator;

class OptionCalculator implements PricingCalculator
{
    public function calculate(CheckerQuestion $question, mixed $answer, array $uploads): float
    {
        if (empty($answer)) {
            return 0;
        }

        // Normalize to array (supports radio/select single value and checkbox array)
        $optionIds = is_array($answer) ? $answer : [$answer];

        // Filter out empty/null values
        $optionIds = array_filter($optionIds, fn ($id) => !empty($id));

        if (empty($optionIds)) {
            return 0;
        }

        return (float) CheckerQuestionOption::where('checker_question_id', $question->id)
            ->whereIn('id', $optionIds)
            ->sum('additional_price');
    }
}
