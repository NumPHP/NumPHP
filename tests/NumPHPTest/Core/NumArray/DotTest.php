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
 * Class DotTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DotTest extends TestCase
{
    /**
     * Tests NumArray::dot with scalar value and int
     */
    public function testDotSingleScalar()
    {
        $numArray = new NumArray(-7);

        $expectedNumArray = new NumArray(-21);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->dot(3));
    }

    /**
     * Tests NumArray::dot with scalar values
     */
    public function testDotSingleSingle()
    {
        $numArray1 = new NumArray(8);
        $numArray2 = new NumArray(-4);

        $expectedNumArray = new NumArray(-32);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests NumArray::dot with vector and scalar value
     */
    public function testDotVectorScalar()
    {
        $numArray = NumPHP::arange(1, 5);

        $expectedNumArray = NumPHP::arange(4, 20, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->dot(4));
    }

    /**
     * Tests NumArray::dot with scalar value and vector
     */
    public function testDotScalarVector()
    {
        $numArray1 = new NumArray(-2);
        $numArray2 = NumPHP::arange(1, 5);

        $expectedNuMArray = new NumArray(
            [-2, -4, -6, -8, -10]
        );
        $this->assertNumArrayEquals($expectedNuMArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests NumArray::dot with two vectors
     */
    public function testDotVectorVector()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(4, 12, 2);

        $expectedNumArray = new NumArray(140);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests NumArray::dot with empty vectors
     */
    public function testDotEmptyVectorVector()
    {
        $vector1 = NumPHP::zeros(0);
        $vector2 = NumPHP::zeros(0);

        $expectedNumArray = new NumArray(0);
        $this->assertNumArrayEquals($expectedNumArray, $vector1->dot($vector2));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::dot
     * with two vectors of different size
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Vector size 3 is different to vector size 4
     */
    public function testDotVector3Vector4()
    {
        $numArray1 = NumPHP::arange(1, 3);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->dot($numArray2);
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::dot
     * with a vector and a 2x3x4 matrix that are not align
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Matrix with shape (3) and matrix with shape (2, 3, 4) are not align.
     */
    public function testDotVector3Matrix3d()
    {
        $numArray1 = NumPHP::arange(1, 3);
        $numArray2 = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        $numArray1->dot($numArray2);
    }

    /**
     * Tests NumArray::dot with matrix and scalar value
     */
    public function testDotMatrixScalar()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(5, 60, 5)->reshape(3, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->dot(5));
    }

    /**
     * Tests NumArray::dot with vector and matrix
     */
    public function testDotVectorMatrix()
    {
        $numArray1 = NumPHP::arange(1, 3);
        $numArray2 = NumPHP::arange(2, 4)->reshape(3, 1);

        $expectedNumArray = new NumArray(
            [20]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Test if InvalidArgumentException will be thrown, when using NumArray::dot
     * with a vector and matrix that are not align
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Vector size 3 is different to matrix size 4
     */
    public function testDotVector3Matrix4x1()
    {
        $numArray1 = NumPHP::arange(1, 3);
        $numArray2 = NumPHP::arange(2, 5)->reshape(4, 1);

        $numArray1->dot($numArray2);
    }

    /**
     * Tests NumArray::dot with matrix and vector
     */
    public function testDotMatrixVector()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 4);

        $expectedNumArray = NumPHP::arange(30, 110, 40);

        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::dot
     * with a matrix and a vector that are not align
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Matrix with shape (3, 3) and matrix with shape (4) are not align.
     */
    public function testDotMatrix3x3Vector4()
    {
        $numArray1 = NumPHP::arange(1, 9)->reshape(3, 3);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->dot($numArray2);
    }

    /**
     * Tests NumArray::dot with 2x3x4 matrix and vector
     */
    public function testDot3dMatrixVector()
    {
        $numArray1 = NumPHP::arange(1, 24)->reshape(2, 3, 4);
        $numArray2 = NumPHP::arange(1, 4);

        $expectedNumArray = NumPHP::arange(30, 230, 40)->reshape(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests NumArray::dot with two matrices
     */
    public function testDotMatrixMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(5, 28)->reshape(4, 6);

        $expectedNumArray = new NumArray(
            [
                [170, 180, 190, 200, 210, 220],
                [394, 420, 446, 472, 498, 524],
                [618, 660, 702, 744, 786, 828],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->dot($numArray2));
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumArray::dot
     * with two matrices that are not align
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Matrix with shape (3, 4) and matrix with shape (3, 3) are not align.
     */
    public function testDotMatrix3x4Matrix3x3()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 9)->reshape(3, 3);

        $numArray1->dot($numArray2);
    }

    /**
     * Tests if cache will be flushed after using NumArray::dot
     */
    public function testDotCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);

        $numArray->dot(5);
        $this->assertFalse($numArray->inCache('key'));
    }
}
