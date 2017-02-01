<?php
declare(strict_types=1);

namespace NumPHPTest;

use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testToStringEmpty()
    {
        $numArray = new NumArray([]);
        $this->assertSame("[]", $numArray->__toString());
    }

    public function testToString3()
    {
        $numArray = new NumArray([6, 3, 0]);
        $this->assertSame("[6, 3, 0]", $numArray->__toString());
    }

    public function testToString2x3()
    {
        $numArray = new NumArray(
            [
                [-2, 3, 9],
                [-7, 8, -8]
            ]
        );
        $this->assertSame("[\n  [-2, 3, 9],\n  [-7, 8, -8]\n]", $numArray->__toString());
    }

    public function testIsEqual()
    {
        $numArray = new NumArray([3, -1]);
        $this->assertFalse($numArray->isEqual(new NumArray([])));
        $this->assertFalse($numArray->isEqual(new NumArray([0, 5])));
        $this->assertFalse($numArray->isEqual(new NumArray(
            [
                [1, 2, 1],
                [-4, 2, -5]
            ]
        )));
        $this->assertTrue($numArray->isEqual(new NumArray([3, -1])));
    }

    public function testGetData()
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

    public function testOnesEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('No $axis given');
        NumArray::ones();
    }

    public function testOnes4()
    {
        $numArray = new NumArray([1, 1, 1, 1]);
        $this->assertTrue($numArray->isEqual(NumArray::ones(4)));
    }

    public function testOnes2x3()
    {
        $numArray = new NumArray(
            [
                [1, 1, 1],
                [1, 1, 1]
            ]
        );
        $this->assertTrue($numArray->isEqual(NumArray::ones(2, 3)));
    }

    public function testOnesLike4()
    {
        $numArray = new NumArray([6, -6, -1, -7]);
        $this->assertTrue(NumArray::ones(4)->isEqual(NumArray::onesLike($numArray)));
    }

    public function testOnesLike2x3()
    {
        $numArray = new NumArray(
            [
                [0, 5, -8],
                [4, 8, 1]
            ]
        );
        $this->assertTrue(NumArray::ones(2, 3)->isEqual(NumArray::onesLike($numArray)));
    }

    public function testZerosEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('No $axis given');
        NumArray::zeros();
    }

    public function testZeros4()
    {
        $numArray = new NumArray([0, 0, 0, 0]);
        $this->assertTrue($numArray->isEqual(NumArray::zeros(4)));
    }

    public function testZeros2x3()
    {
        $numArray = new NumArray(
            [
                [0, 0, 0],
                [0, 0, 0]
            ]
        );
        $this->assertTrue($numArray->isEqual(NumArray::zeros(2, 3)));
    }

    public function testZerosLike4()
    {
        $numArray = new NumArray([8, 6, 1, 1]);
        $this->assertTrue(NumArray::zeros(4)->isEqual(NumArray::zerosLike($numArray)));
    }

    public function testZerosLike2x3()
    {
        $numArray = new NumArray(
            [
                [1, -1, 0],
                [4, -6, 6]
            ]
        );
        $this->assertTrue(NumArray::zeros(2, 3)->isEqual(NumArray::zerosLike($numArray)));
    }
}
