<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ZerosLikeTest extends \PHPUnit_Framework_TestCase
{
    public function testZerosLike4()
    {
        $numArray = new NumArray([8, 6, 1, 1]);
        $this->assertTrue(NumArray::zeros(4)->isEqual(NumArray::zerosLike($numArray)));
    }

    public function testZerosLike2x3()
    {
        $numArray = new NumArray([
            [1, -1, 0],
            [4, -6, 6]
        ]);
        $this->assertTrue(NumArray::zeros(2, 3)->isEqual(NumArray::zerosLike($numArray)));
    }
}
