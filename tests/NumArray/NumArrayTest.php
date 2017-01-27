<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray\Factory;

class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new Factory();
    }

    public function testToString3()
    {
        $numArray = $this->factory->createFromData([6, 3, 0]);
        $this->assertSame("[6,3,0]", $numArray->__toString());
    }

    public function testData()
    {
        $numArray = $this->factory->createFromData([2, 0, 5, 6]);
        $this->assertSame([2, 0, 5, 6], $numArray->getData());
    }

    public function testGetShape4()
    {
        $numArray = $this->factory->createFromData([7, 4, 3, 4]);
        $this->assertSame([4], $numArray->getShape());
    }

    public function testGetShape2x3()
    {
        $numArray = $this->factory->createFromData(
            [
                [5, 4, 0],
                [2, 3, 7],
            ]
        );
        $this->assertSame([2, 3], $numArray->getShape());
    }

    public function testGetSize4()
    {
        $numArray = $this->factory->createFromData([6, 9, 3, 4]);
        $this->assertSame(4, $numArray->getSize());
    }

    public function testGetSize2x3()
    {
        $numArray = $this->factory->createFromData(
            [
                [6, 0, 2],
                [2, 3, 9]
            ]
        );
        $this->assertSame(6, $numArray->getSize());
    }

    public function testGetNDim4()
    {
        $numArray = $this->factory->createFromData([8, 9, 3, 6]);
        $this->assertSame(1, $numArray->getNDim());
    }

    public function testGetNDim2x3()
    {
        $numArray = $this->factory->createFromData(
            [
                [8, 6, 4],
                [3, 8, 0]
            ]
        );
        $this->assertSame(2, $numArray->getNDim());
    }
}
