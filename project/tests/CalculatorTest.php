<?php

namespace App\Tests;

use App\Service\Calculator\Calculator;
use App\Service\Calculator\Operations;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testCalculator(): void
    {
        $calculator = new Calculator();
        foreach (TestCases::$DATA as $testCase) {
            $result = $calculator->calculate($testCase['valueA'], $testCase['valueB'], $testCase['operation']);
            self::assertEquals($testCase['expected'], $result);
        }
    }

    public function testErrorOnDivisionByZero(): void
    {
        $calculator = new Calculator();

        $this->expectError();

        $calculator->calculate(5, 0, Operations::Divide);
    }
}
