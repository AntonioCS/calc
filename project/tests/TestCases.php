<?php
declare(strict_types=1);

namespace App\Tests;

use App\Service\Calculator\Operations;

class TestCases
{
    static public array $DATA = [
        [
            'expected' => 10,
            'valueA' => 5,
            'valueB' => 5,
            'operation' => Operations::Add
        ],
        [
            'expected' => 5,
            'valueA' => 10,
            'valueB' => 5,
            'operation' => Operations::Subtract
        ],
        [
            'expected' => 25,
            'valueA' => 5,
            'valueB' => 5,
            'operation' => Operations::Multiply
        ],
        [
            'expected' => 5,
            'valueA' => 10,
            'valueB' => 2,
            'operation' => Operations::Divide
        ]
    ];
}