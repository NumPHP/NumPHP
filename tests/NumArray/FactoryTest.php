<?php
declare(strict_types=1);

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

    public function testCreateZerosLike2x3()
    {
        $this->assertSame(
            $this->factory->createZeros(2, 3)->getData(),
            $this->factory->createZerosLike($this->factory->createZeros(2, 3))->getData()
        );
    }

    public function testCreateOnesEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('Required argument $axis not found');
        $this->assertSame([], $this->factory->createOnes()->getData());
    }

    public function testCreateOnes2x3()
    {
        $this->assertSame(
            [
                [1, 1, 1],
                [1, 1, 1]
            ],
            $this->factory->createOnes(2, 3)->getData()
        );
    }

    public function testCreateOnesLike3x2()
    {
        $this->assertSame(
            $this->factory->createZeros(3, 2)->getData(),
            $this->factory->createZerosLike($this->factory->createOnes(3, 2))->getData()
        );
    }
}
