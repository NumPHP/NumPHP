<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class LinAlgTest
 *
 * @package   NumPHPTest\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class LinAlgTest extends TestCase
{
    /**
     * Tests LinAlg::det with 3x3 matrix
     */
    public function testDet3x3()
    {
        $numArray = new NumArray(
            [
                [1, 6, 1],
                [2, 3, 2],
                [4, 2, 1],
            ]
        );

        $this->assertSame(27.0, LinAlg::det($numArray));
    }

    /**
     * Tests LinAlg::det with 4x4 matrix
     */
    public function testDet4x4()
    {
        $array = [
            [1,  2,  3,  4],
            [5,  6,  7,  8],
            [9, 10, 11, 12],
            [5,  6,  7,  8],
        ];

        $this->assertSame(0.0, LinAlg::det($array));
    }

    /**
     * Tests if NoSquareMatrixException will be thrown, when using LinAlg::det with
     * 2x3 matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoSquareMatrixException
     * @expectedExceptionMessage Matrix with shape (2, 3) given, matrix has to be square
     */
    public function testDet2x3()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        LinAlg::det($numArray);
    }

    public function testDetCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache(LinAlg::CACHE_KEY_DETERMINANT, 8);

        $this->assertSame(8, LinAlg::det($numArray));
    }

    /**
     * Tests LinAlg::inv with a 2*2 matrix
     */
    public function testInv()
    {
        $matrix = new NumArray(
            [
                [ 4, 7],
                [ 2, 6]
            ]
        );

        $expectedNumArray = new NumArray(
            [
                [ 0.6, -0.7],
                [-0.2,  0.4]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, LinAlg::inv($matrix));
    }

    /**
     * Tests LinAlg::inv with a 3*3 array
     */
    public function testInvArray()
    {
        $matrix = [
            [ 1,  0, 4],
            [-9,  0, 5],
            [ 1, -3, 0]
        ];

        $expectedNumArray = new NumArray(
            [
                [ 5/41,  -4/41,    0],
                [5/123, -4/123, -1/3],
                [ 9/41,   1/41,    0]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, LinAlg::inv($matrix));
    }

    /**
     * Tests LinAlg::inv cache
     */
    public function testInvCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache(LinAlg::CACHE_KEY_INVERSE, 8);

        $this->assertSame(8, LinAlg::inv($numArray));
    }

    /**
     * Tests if SingularMatrixException will be thrown, when using LinAlg::inv with singular matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\SingularMatrixException
     * @expectedExceptionMessage Matrix is singular
     */
    public function testInvSingular()
    {
        $matrix = new NumArray([[0]]);

        LinAlg::inv($matrix);
    }
}
