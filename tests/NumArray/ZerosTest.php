<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ZerosTest extends TestCase
{
    public function testZerosEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('No $axis given');
        NumArray::zeros();
    }

    public function testZeros4()
    {
        $numArray = new NumArray([0, 0, 0, 0]);
        $this->assertNumArrayEquals($numArray, NumArray::zeros(4));
    }

    public function testZeros2x3()
    {
        $numArray = new NumArray([
            [0, 0, 0],
            [0, 0, 0]
        ]);
        $this->assertNumArrayEquals($numArray, NumArray::zeros(2, 3));
    }
}
