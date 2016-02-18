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
 * Class MultTest
 *
 * @package   NumPHPTest\Core\NumArray\Map
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.4
 */
class MultTest extends TestCase
{
    /**
     * Tests NumArray::mult with scalar values
     */
    public function testAddSingle()
    {
        $numArray1 = new NumArray(3);
        $numArray2 = new NumArray(-7);

        $expectedNumArray = new NumArray(-21);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with scalar value and vector
     */
    public function testMultSingleVector()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = new NumArray(3);

        $expectedNumArray = NumPHP::arange(3, 15, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with two vectors
     */
    public function testMultTwoVector()
    {
        $numArray1 = NumPHP::arange(1, 4);
        $numArray2 = NumPHP::arange(-19, -10, 3);

        $expectedNumArray = new NumArray(
            [-19, -32, -39, -40]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with scalar value and matrix
     */
    public function testMultMatrixSingle()
    {
        $numArray1 = new NumArray(56);
        $numArray2 = NumPHP::arange(1, 9)->reshape(3, 3);

        $expectedNumArray = NumPHP::arange(56, 531, 56)->reshape(3, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with vector and matrix
     */
    public function testMultVectorMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 3);

        $expectedNumArray = new NumArray(
            [
                [ 1,  2,  3,  4],
                [10, 12, 14, 16],
                [27, 30, 33, 36]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with two matrices
     */
    public function testMultMatrixMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(-5, 6)->reshape(3, 4);

        $expectedNumArray = new NumArray(
            [
                [-5, -8, -9, -8],
                [-5,  0,  7, 16],
                [27, 40, 55, 72]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->mult($numArray2));
    }

    /**
     * Tests NumArray::mult with vector and array
     */
    public function testMultVectorArray()
    {
        $numArray = NumPHP::arange(1, 7);
        $array = [4, 5, 6, 7, 8, 9, 10];

        $expectedNumArray = new NumArray(
            [4, 10, 18, 28, 40, 54, 70]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mult($array));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::mult with vectors of different size
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Size 5 is different from size 4
     */
    public function testMultDifferentShape()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->mult($numArray2);
    }

    /**
     * Tests if cache will be flushed after use of NumArray::mult
     */
    public function testMultCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 6);

        $numArray->mult(4);
        $this->assertFalse($numArray->inCache('key'));
    }
}
