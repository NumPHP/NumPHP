<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ZerosLikeTest extends TestCase
{
    public function testZerosLike4()
    {
        $numArray = new NumArray([8, 6, 1, 1]);
        $this->assertNumArrayEquals(NumArray::zeros(4), NumArray::zerosLike($numArray));
    }

    public function testZerosLike2x3()
    {
        $numArray = new NumArray([
            [1, -1, 0],
            [4, -6, 6]
        ]);
        $this->assertNumArrayEquals(NumArray::zeros(2, 3), NumArray::zerosLike($numArray));
    }
}
