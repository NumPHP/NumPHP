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
 * Class AddTest
 *
 * @package   NumPHPTest\Core\NumArray\Map
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class AddTest extends TestCase
{
    /**
     * Tests NumArray::add with scalar values
     */
    public function testAddSingle()
    {
        $numArray1 = new NumArray(3);
        $numArray2 = new NumArray(-7);

        $expectedNumArray = new NumArray(-4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with scalar value and vector
     */
    public function testAddSingleVector()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = new NumArray(3);

        $expectedNumArray = NumPHP::arange(4, 8);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with two vectors
     */
    public function testAddTwoVector()
    {
        $numArray1 = NumPHP::arange(1, 4);
        $numArray2 = NumPHP::arange(-19, -10, 3);

        $expectedNumArray = NumPHP::arange(-18, -6, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with scalar value and matrix
     */
    public function testAddMatrixSingle()
    {
        $numArray1 = new NumArray(56);
        $numArray2 = NumPHP::arange(1, 9)->reshape(3, 3);

        $expectedNumArray = NumPHP::arange(57, 65)->reshape(3, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with vector and matrix
     */
    public function testAddVectorMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 3);

        $expectedNumArray = new NumArray(
            [
                [2, 3, 4, 5],
                [7, 8, 9, 10],
                [12, 13, 14, 15],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with two matrices
     */
    public function testAddMatrixMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(-5, 6)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(-4, 18, 2)->reshape(3, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    /**
     * Tests NumArray::add with vector and array
     */
    public function testAddVectorArray()
    {
        $numArray = NumPHP::arange(1, 7);
        $array = [4, 5, 6, 7, 8, 9, 10];

        $expectedNumArray = NumPHP::arange(5, 17, 2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->add($array));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::add with vectors of different size
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Size 5 is different from size 4
     */
    public function testAddDifferentShape()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->add($numArray2);
    }

    /**
     * Tests if cache will be flushed after use of NumArray::add
     */
    public function testAddCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 6);

        $numArray->add(4);
        $this->assertFalse($numArray->inCache('key'));
    }
}
