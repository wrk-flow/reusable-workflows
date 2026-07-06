<?php

declare(strict_types=1);

namespace WrkFlow\PhpSample\Tests;

use PHPUnit\Framework\TestCase;
use WrkFlow\PhpSample\Calculator;

final class CalculatorTest extends TestCase
{
    public function testAddReturnsSum(): void
    {
        $calculator = new Calculator();

        self::assertSame(5, $calculator->add(2, 3));
    }
}
