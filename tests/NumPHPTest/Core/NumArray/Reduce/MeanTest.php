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
 * Class MeanTest
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
class MeanTest extends TestCase
{
    /**
     * Tests NumArray::mean with scalar value without arguments
     */
    public function testMeanSingle()
    {
        $numArray = new NumArray(5);

        $expectedNumArray = new NumArray(5);
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    /**
     * Tests NumArray::mean with a vector and without arguments
     */
    public function testMeanVector()
    {
        $numArray = new NumArray(
            [45, 2, -5]
        );

        $expectedNumArray = new NumArray(14);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean());
    }

    /**
     * Tests NumArray::mean with a matrix and without arguments
     */
    public function testMeanMatrix()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        $expectedNumArray = new NumArray(3.5);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean());
    }

    /**
     * Tests NumArray::mean with scalar value with argument 0
     */
    public function testMeanSingleAxis0()
    {
        $numArray = new NumArray(-4);

        $expectedNumArray = new NumArray(-4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    /**
     * Tests NumArray::mean with a vector and with argument 0
     */
    public function testMeanVectorAxis0()
    {
        $numArray = new NumArray(
            [45, 2, -5]
        );

        $expectedNumArray = new NumArray(14);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    /**
     * Tests NumArray::mean with a matrix and with argument 0
     */
    public function testMeanMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [12, -43, 6],
                [-3, 89, 23],
            ]
        );

        $expectedNumArray = new NumArray(
            [4.5, 23, 14.5]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::mean and a
     * wrong axis on a scalar value
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMeanSingleAxis1()
    {
        $numArray = new NumArray(5);

        $numArray->mean(1);
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::mean and a
     * wrong axis on a vector
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMeanVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 2);

        $numArray->mean(1);
    }

    /**
     * Tests NumArray::mean with a matrix and argument 1
     */
    public function testMeanMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [12, -43, 6],
                [-3, 89, 23],
            ]
        );

        $expectedNumArray = new NumArray(
            [-25/3, 109/3]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(1));
    }

    /**
     * Tests if InvalidArgumentException will be thrown by using NumArray::mean and a
     * wrong axis on a matrix
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testMeanMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        $numArray->mean(2);
    }

    /**
     * Tests NumArray::sum with a 2x3x4 matrix and argument 0
     */
    public function testMeanMatrix2x3x4Axis0()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        $expectedNumArray = NumPHP::arange(7, 18)->reshape(3, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }
}
