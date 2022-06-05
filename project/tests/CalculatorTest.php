<?php

namespace App\Tests;

use App\Service\Calculator\Calculator;
use App\Service\Calculator\Operations;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new Calculator();
    }

    public function testCalculator(): void
    {
        foreach (TestCases::$DATA as $testCase) {
            $result = $this->calculator->calculate($testCase['valueA'], $testCase['valueB'], $testCase['operation']);
            self::assertEquals($testCase['expected'], $result);
        }
    }

    public function testErrorOnDivisionByZero(): void
    {
        $this->expectError();
        $this->calculator->calculate(5, 0, Operations::Divide);
    }
}
