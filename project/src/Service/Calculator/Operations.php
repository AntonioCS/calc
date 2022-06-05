<?php
declare(strict_types=1);

namespace App\Service\Calculator;

enum Operations: string
{
    case Add = '+';
    case Subtract = '-';
    case Multiply = '*';
    case Divide = '/';
}