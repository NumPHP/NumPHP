<?php
declare(strict_types=1);

namespace NumPHPTest;

use NumPHP\NumArray;

class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testIsEqual()
    {
        $numArray = new NumArray([3, -1]);
        $this->assertFalse($numArray->isEqual(new NumArray([])));
        $this->assertFalse($numArray->isEqual(new NumArray([0, 5])));
        $this->assertFalse($numArray->isEqual(new NumArray([
            [1, 2, 1],
            [-4, 2, -5]
        ])));
        $this->assertTrue($numArray->isEqual(new NumArray([3, -1])));
    }

    public function testGetData()
    {
        $numArray = new NumArray([2, 0, 5, 6]);
        $this->assertSame([2, 0, 5, 6], $numArray->getData());
    }
}
