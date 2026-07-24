<?php

namespace App\Services\Checker;

use App\Models\CheckerService;
use App\Services\Checker\Calculators\MultiplyCalculator;
use App\Services\Checker\Calculators\NoneCalculator;
use App\Services\Checker\Calculators\OptionCalculator;
use App\Services\Checker\Calculators\PerFileCalculator;
use App\Services\Checker\Contracts\PricingCalculator;

class PricingService
{
    /**
     * Registry: pricing_rule => Calculator class.
     * To add a new rule, create a Calculator class and register it here.
     */
    private array $calculators = [
        'none'     => NoneCalculator::class,
        'per_file' => PerFileCalculator::class,
        'multiply' => MultiplyCalculator::class,
        'option'   => OptionCalculator::class,
    ];

    /**
     * Calculate the grand total for a service order.
     *
     * Formula: base_price + Σ pricing questions + Σ additional options
     */
    public function calculate(CheckerService $service, array $answers, array $uploads = []): float
    {
        // 1. Start with the service base price
        $total = (float) $service->base_price;

        // 2. Get all questions that affect pricing
        $questions = $service->questions()
            ->where('affects_price', true)
            ->get();

        // 3. Loop each question and delegate to the appropriate calculator
        foreach ($questions as $question) {
            $answer = $answers[$question->id] ?? null;
            $questionUploads = $uploads[$question->id] ?? [];
            $calculator = $this->resolveCalculator($question->pricing_rule);
            $total += $calculator->calculate($question, $answer, $questionUploads);
        }

        return $total;
    }

    /**
     * Resolve the calculator instance for a given pricing rule.
     */
    private function resolveCalculator(string $rule): PricingCalculator
    {
        $calculatorClass = $this->calculators[$rule] ?? NoneCalculator::class;

        return app($calculatorClass);
    }
}