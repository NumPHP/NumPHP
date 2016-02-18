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
 * Class SumTest
 *
 * @package   NumPHPTest\Core\NumArray\Reduce
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class SumTest extends TestCase
{
    /**
     * Tests NumArray::sum with scalar value without arguments
     */
    public function testSumSingle()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum());
    }

    /**
     * Tests NumArray::sum with a vector without arguments
     */
    public function testSumVector()
    {
        $numArray = NumPHP::arange(1, 8);

        $expectedNumArray = new NumArray(36);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum());
    }

    /**
     * Tests NumArray::sum with a matrix without arguments
     */
    public function testSumMatrix()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = new NumArray(78);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum());
    }

    /**
     * Tests NumArray::sum with scalar value with argument 0
     */
    public function testSumSingleAxis0()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum(0));
    }

    /**
     * Tests NumArray::sum with a vector and argument 0
     */
    public function testSumVectorAxis0()
    {
        $numArray = NumPHP::arange(1, 8);

        $expectedNumArray = new NumArray(36);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum(0));
    }

    /**
     * Tests NumArray::sum with a matrix and argument 0
     */
    public function testSumMatrixAxis0()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(15, 24, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum(0));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::sum and a
     * wrong axis on a scalar value
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testSumSingleAxis1()
    {
        $numArray = new NumArray(6);

        $numArray->sum(1);
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::sum and a
     * wrong axis on a vector
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testSumVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 8);

        $numArray->sum(1);
    }

    /**
     * Tests NumArray::sum with a matrix and argument 1
     */
    public function testSumMatrixAxis1()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(10, 42, 16);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum(1));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::sum and a
     * wrong axis on a matrix
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testSumMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $numArray->sum(2);
    }

    /**
     * Tests NumArray::sum with a 2x3x4 matrix and argument 2
     */
    public function testSumMatrix2x3x4Axis2()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        $expectedNumArray = NumPHP::arange(10, 90, 16)->reshape(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->sum(2));
    }
}
