<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class IdentityTest extends \PHPUnit_Framework_TestCase
{
    public function testIdentityNegativeAxis()
    {
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('$axis -2 is smaller than 0');
        NumArray::identity(-2);
    }

    public function testIdentity0()
    {
        $this->assertTrue(NumArray::identity(0)->isEqual(NumArray::zeros(0)));
    }

    public function testIdentity3()
    {
        $this->assertTrue(NumArray::identity(3)->isEqual(NumArray::eye(3)));
    }
}
