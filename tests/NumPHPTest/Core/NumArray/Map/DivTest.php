<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray\Map;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class DivTest
 *
 * @package   NumPHPTest\Core\NumArray\Map
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.4
 */
class DivTest extends TestCase
{
    /**
     * Tests NumArray::div with scalar values
     */
    public function testDicSingle()
    {
        $numArray1 = new NumArray(3);
        $numArray2 = new NumArray(-7);

        $expectedNumArray = new NumArray(-3/7);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with scalar value and vector
     */
    public function testAddSingleVector()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = new NumArray(3);

        $expectedNumArray = NumPHP::arange(1/3, 5/3, 1/3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with two vectors
     */
    public function testDivTwoVector()
    {
        $numArray1 = NumPHP::arange(1, 4);
        $numArray2 = NumPHP::arange(-19, -10, 3);

        $expectedNumArray = new NumArray(
            [-1/19, -2/16, -3/13, -4/10]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with scalar value and matrix
     */
    public function testDivMatrixSingle()
    {
        $numArray1 = new NumArray(56);
        $numArray2 = NumPHP::arange(1, 9)->reshape(3, 3);

        $expectedNumArray = new NumArray(
            [
                [56/1, 56/2, 56/3],
                [56/4, 56/5, 56/6],
                [56/7, 56/8, 56/9]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with vector and matrix
     */
    public function testDivVectorMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 4);

        $expectedNumArray = new NumArray(
            [
                [1/1,  2/2,  3/3,  4/4],
                [5/1,  6/2,  7/3,  8/4],
                [9/1, 10/2, 11/3, 12/4],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with two matrices
     */
    public function testDivMatrixMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(-13, -2)->reshape(3, 4);

        $expectedNumArray = new NumArray(
            [
                [-1/13, -2/12, -3/11, -4/10],
                [ -5/9,  -6/8,  -7/7,  -8/6],
                [ -9/5, -10/4, -11/3, -12/2]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->div($numArray2));
    }

    /**
     * Tests NumArray::div with vector and array
     */
    public function testDivVectorArray()
    {
        $numArray = NumPHP::arange(1, 7);
        $array = [4, 5, 6, 7, 8, 9, 10];

        $expectedNumArray = new NumArray(
            [1/4, 2/5, 3/6, 4/7, 5/8, 6/9, 7/10]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->div($array));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::div with vectors of different size
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Shape (5) is not align with shape (4)
     */
    public function testDivDifferentShape()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->div($numArray2);
    }

    /**
     * Tests if DivideByZeroException will be thrown, when using NumArray::div with zero value in divisor
     *
     * @expectedException        \NumPHP\Core\Exception\DivideByZeroException
     * @expectedExceptionMessage Dividing by zero is forbidden
     */
    public function testDivZero()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(-2, 2);

        $numArray1->div($numArray2);
    }
}
