<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class OnesLikeTest extends TestCase
{
    public function testOnesLike4()
    {
        $numArray = new NumArray([6, -6, -1, -7]);
        $this->assertTrue(NumArray::ones(4)->isEqual(NumArray::onesLike($numArray)));
    }

    public function testOnesLike2x3()
    {
        $numArray = new NumArray([
            [0, 5, -8],
            [4, 8, 1]
        ]);
        $this->assertTrue(NumArray::ones(2, 3)->isEqual(NumArray::onesLike($numArray)));
    }
}
