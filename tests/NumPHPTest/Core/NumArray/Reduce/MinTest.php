<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray\Reduce;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class MinTest
 *
 * @package   NumPHPTest\Core\NumArray\Reduce
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class MinTest extends TestCase
{
    /**
     * Tests NumArray::min with scalar value without arguments
     */
    public function testMinSingle()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min());
    }

    /**
     * Tests NumArray::min with a vector without arguments
     */
    public function testMinVector()
    {
        $numArray = new NumArray(
            [-5, 7, 9, -34]
        );

        $expectedNumArray = new NumArray(-34);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min());
    }

    /**
     * Tests NumArray::min with a matrix without arguments
     */
    public function testMinMatrix()
    {
        $numArray = new NumArray(
            [
                [6, 3],
                [-1, 11],
            ]
        );

        $expectedNumArray = new NumArray(-1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min());
    }

    /**
     * Tests NumArray::min with scalar value with argument 0
     */
    public function testMinSingleAxis0()
    {
        $numArray = new NumArray(99);

        $expectedNumArray = new NumArray(99);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min(0));
    }

    /**
     * Tests NumArray::min with a vector and argument 0
     */
    public function testMinVectorAxis0()
    {
        $numArray = NumPHP::arange(1, 5);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min(0));
    }

    /**
     * Tests NumArray::min with a matrix and argument 0
     */
    public function testMinMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [34, 346, -12],
                [56, -78, 12],
                [345, -6, 99],
            ]
        );

        $expectedNumArray = new NumArray(
            [34, -78, -12]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min(0));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::min and a
     * wrong axis on a scalar value
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMinSingleAxis1()
    {
        $numArray = new NumArray(5);

        $numArray->min(1);
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::min and a
     * wrong axis on a vector
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMinVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 5);

        $numArray->min(1);
    }

    /**
     * Tests NumArray::min with a matrix and argument 1
     */
    public function testMinMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [34, 346, -12],
                [56, -78, 12],
                [345, -6, 99],
            ]
        );

        $expectedNumArray = new NumArray(
            [-12, -78, -6]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->min(1));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::min and a
     * wrong axis on a matrix
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testNimMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 9)->reshape(3, 3);

        $numArray->min(2);
    }
}
