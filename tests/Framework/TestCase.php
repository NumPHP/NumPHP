<?php
declare(strict_types=1);

namespace NumPHPTest\Framework;

use NumPHP\NumArray;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function assertNumArrayEquals(NumArray $expected, NumArray $actual, string $message = '')
    {
        static::assertEquals(
            $expected->getData(),
            $actual->getData(),
            $message
        );
    }
}
