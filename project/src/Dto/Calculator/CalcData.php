<?php
declare(strict_types=1);

namespace App\Dto\Calculator;

class CalcData
{
    private int|float $valueA;

    private int|float $valueB;

    private string $operation;

    public function getValueA(): float|int
    {
        return $this->valueA;
    }

    public function setValueA(float|int $valueA): CalcData
    {
        $this->valueA = $valueA;
        return $this;
    }

    public function getValueB(): float|int
    {
        return $this->valueB;
    }

    public function setValueB(float|int $valueB): CalcData
    {
        $this->valueB = $valueB;
        return $this;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): CalcData
    {
        $this->operation = $operation;
        return $this;
    }




}