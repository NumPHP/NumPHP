<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class ShapeTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class ShapeTest extends TestCase
{
    /**
     * Tests NumArray::getShape on scalar
     */
    public function testGetShape()
    {
        $numArray = NumPHP::zeros();
        $this->assertSame([], $numArray->getShape());
    }

    /**
     * Tests NumArray::getShape on vector size 2
     */
    public function testGetShape2()
    {
        $numArray = NumPHP::zeros(2);
        $this->assertSame([2], $numArray->getShape());
    }

    /**
     * Tests NumArray::getShape on matrix size 2x0
     */
    public function testGetShape2x0()
    {
        $numArray = NumPHP::zeros(2, 0);
        $this->assertSame([2, 0], $numArray->getShape());
    }

    /**
     * Tests NumArray::getShape on matrix size 2x4
     */
    public function testGetShape2x4()
    {
        $numArray = NumPHP::zeros(2, 4);
        $this->assertSame([2, 4], $numArray->getShape());
    }

    /**
     * Tests NumArray::getShape on matrix size 2x3x4
     */
    public function testGetShape2x3x4()
    {
        $numArray = NumPHP::ones(2, 3, 4);
        $this->assertSame([2, 3, 4], $numArray->getShape());
    }

    /**
     * Tests if BadMethodCallException will be thrown, when using NumArray::reshape
     * on scalar
     *
     * @expectedException        \NumPHP\Core\Exception\BadMethodCallException
     * @expectedExceptionMessage NumArray data is not an array
     */
    public function testReshapeBadMethodCallException()
    {
        $numArray = NumPHP::ones();
        $numArray->reshape();
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::reshape
     * with wrong size
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Total size of new array must be unchanged
     */
    public function testReshapeInvalidArgumentException()
    {
        $numArray = NumPHP::ones(2, 3);
        $numArray->reshape(2, 2);
    }

    /**
     * Tests NumArray::reshape with matrix 2x3 to vector 6
     */
    public function testReshape2x3To1x6()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
        $this->assertNumArrayEquals(NumPHP::arange(1, 6), $numArray->reshape(6));
    }

    /**
     * Tests NumArray::reshape with matrix 3x4 to matrix 2x6
     */
    public function testReshape3x4To2x6()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
                [9, 10, 11, 12],
            ]
        );
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5, 6],
                [7, 8, 9, 10, 11, 12],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->reshape(2, 6));
    }

    /**
     * Tests if cache will be flushed after NumArray::reshape
     */
    public function testReshapeCache()
    {
        $numArray = NumPHP::arange(1, 4);
        $numArray->setCache('key', 6);

        $numArray->reshape(2, 2);
        $this->assertFalse($numArray->inCache('key'));
    }
}
