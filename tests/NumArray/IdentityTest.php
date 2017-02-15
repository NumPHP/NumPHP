<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\InvalidArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class IdentityTest extends TestCase
{
    public function testIdentityNegativeAxis()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('$axis -2 is smaller than 0');
        NumArray::identity(-2);
    }

    public function testIdentity0()
    {
        $this->assertNumArrayEquals(NumArray::zeros(0), NumArray::identity(0));
    }

    public function testIdentity3()
    {
        $this->assertNumArrayEquals(NumArray::eye(3), NumArray::identity(3));
    }
}
