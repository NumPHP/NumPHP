<?php
declare(strict_types=1);

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;

class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testData()
    {
        $numArray = new NumArray([2, 0, 5, 6]);
        $this->assertSame([2, 0, 5, 6], $numArray->getData());
    }

    public function testGetShape4()
    {
        $numArray = new NumArray([7, 4, 3, 4]);
        $this->assertSame([4], $numArray->getShape());
    }

    public function testGetShape2x3()
    {
        $numArray = new NumArray(
            [
                [5, 4, 0],
                [2, 3, 7],
            ]
        );
        $this->assertSame([2, 3], $numArray->getShape());
    }

    public function testGetSize4()
    {
        $numArray = new NumArray([6, 9, 3, 4]);
        $this->assertSame(4, $numArray->getSize());
    }

    public function testGetSize2x3()
    {
        $numArray = new NumArray(
            [
                [6, 0, 2],
                [2, 3, 9]
            ]
        );
        $this->assertSame(6, $numArray->getSize());
    }

    public function testGetNDim4()
    {
        $numArray = new NumArray([8, 9, 3, 6]);
        $this->assertSame(1, $numArray->getNDim());
    }

    public function testGetNDim2x3()
    {
        $numArray = new NumArray(
            [
                [8, 6, 4],
                [3, 8, 0]
            ]
        );
        $this->assertSame(2, $numArray->getNDim());
    }
}
