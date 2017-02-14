<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class OnesLikeTest extends TestCase
{
    public function testOnesLike4()
    {
        $numArray = new NumArray([6, -6, -1, -7]);
        $this->assertNumArrayEquals(NumArray::ones(4), NumArray::onesLike($numArray));
    }

    public function testOnesLike2x3()
    {
        $numArray = new NumArray([
            [0, 5, -8],
            [4, 8, 1]
        ]);
        $this->assertNumArrayEquals(NumArray::onesLike($numArray), NumArray::ones(2, 3));
    }
}
