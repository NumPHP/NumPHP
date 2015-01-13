<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\Reduce;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class MaxTest
 *
 * @package   NumPHPTest\Core\NumArray\Reduce
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class MaxTest extends TestCase
{
    /**
     * Tests NumArray::max with scalar value without arguments
     */
    public function testMaxSingle()
    {
        $numArray = new NumArray(7);

        $expectedNumArray = new NumArray(7);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    /**
     * Tests NumArray::max with a vector without arguments
     */
    public function testMaxVector()
    {
        $numArray = new NumArray(
            [4, -1, 78, -4]
        );

        $expectedNumArray = new NumArray(78);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    /**
     * Tests NumArray::max with a matrix without arguments
     */
    public function testMaxMatrix()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(453);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    /**
     * Tests NumArray::max with scalar value with argument 0
     */
    public function testMaxSingleAxis0()
    {
        $numArray = new NumArray(-6);

        $expectedNumArray = new NumArray(-6);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    /**
     * Tests NumArray::max with a vector and argument 0
     */
    public function testMaxVectorAxis0()
    {
        $numArray = new NumArray(
            [4, -1, 34, -4]
        );

        $expectedNumArray = new NumArray(34);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    /**
     * Tests NumArray::max with a matrix and argument 0
     */
    public function testMaxMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(
            [354, 453, 67]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::max and a
     * wrong axis on a scalar value
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMaxSingleAxis1()
    {
        $numArray = new NumArray(7);

        $numArray->max(1);
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::max and a
     * wrong axis on a vector
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMaxVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 2);

        $numArray->max(1);
    }

    /**
     * Tests NumArray::max with a matrix and argument 1
     */
    public function testMaxMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(
            [354, 453]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(1));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::max and a
     * wrong axis on a matrix
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testMaxMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        $numArray->max(2);
    }
}
