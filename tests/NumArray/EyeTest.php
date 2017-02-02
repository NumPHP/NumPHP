<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class EyeTest extends \PHPUnit_Framework_Testcase
{
    public function testEyeNegativeMAxis()
    {
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('$mAxis -2 is smaller than 0');
        NumArray::eye(-2);
    }

    public function testEyeNegativeNAxis()
    {
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('$nAxis -1 is smaller than 0');
        NumArray::eye(0, -1);
    }

    public function testEye0()
    {
        $this->assertTrue(NumArray::eye(0)->isEqual(NumArray::zeros(0, 0)));
    }

    public function testEye3()
    {
        $numArray = new NumArray([
            [1, 0, 0],
            [0, 1, 0],
            [0, 0, 1]
        ]);
        $this->assertTrue(NumArray::eye(3)->isEqual($numArray));
    }

    public function testEye2x3()
    {
        $numArray = new NumArray([
            [1, 0, 0],
            [0, 1, 0]
        ]);
        $this->assertTrue(NumArray::eye(2, 3)->isEqual($numArray));
    }

    public function testEye3x2()
    {
        $numArray = new NumArray([
            [1, 0],
            [0, 1],
            [0, 0]
        ]);
        $this->assertTrue(NumArray::eye(3, 2)->isEqual($numArray));
    }
}
