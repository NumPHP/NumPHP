<?php

namespace NumPHPTest\NumArray;

use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    private $factory;

    public function setUp()
    {
        $this->factory = new Factory();
    }

    public function testCreateFromData()
    {
        $data = [9, 5, 3, 1];
        $this->assertSame($data, $this->factory->createFromData($data)->getData());
    }

    public function testCreateZerosEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('Required argument $axis not found');
        $this->assertSame([], $this->factory->createZeros()->getData());
    }

    public function testCreateZeros3x2()
    {
        $this->assertSame(
            [
                [0, 0],
                [0, 0],
                [0, 0]
            ],
            $this->factory->createZeros(3, 2)->getData()
        );
    }
}
