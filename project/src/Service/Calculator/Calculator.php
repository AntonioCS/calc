<?php
declare(strict_types=1);

namespace App\Service\Calculator;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Calculator
{
    public function calculate(int|float $a, int|float $b, Operations $operation) : int|float
    {
        /**
         * NOTE: ExpressionLanguage is not implemented as a service by symfony.
         * It is only used here and is required for this to work, so there is no need for Dependency Injection
         */
        $expressionLanguage = new ExpressionLanguage();
        $op = $operation->value;

        return $expressionLanguage->evaluate("$a $op $b");
    }
}
