<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;
use NumPHP\LinAlg\LinAlg\LUDecomposition;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class LUDecompositionTest
 *
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class LUDecompositionTest extends TestCase
{
    /**
     * Tests LinAlg::lud with 3x3 matrix
     */
    public function testLUDecompositionSquare()
    {
        $numArray = new NumArray(
            [
                [1, 6, 1],
                [2, 3, 2],
                [4, 2, 1],
            ]
        );

        $expectedP = new NumArray(
            [
                [0, 1, 0],
                [0, 0, 1],
                [1, 0, 0],
            ]
        );
        $expectedL = new NumArray(
            [
                [  1,    0, 0],
                [1/4,    1, 0],
                [1/2, 4/11, 1],
            ]
        );
        $expectedU = new NumArray(
            [
                [4,    2,     1],
                [0, 11/2,   3/4],
                [0,    0, 27/22],
            ]
        );
        list($pMatrix, $lMatrix, $uMatrix) = LinAlg::lud($numArray);
        $this->assertNumArrayEquals(
            $expectedP,
            $pMatrix,
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $lMatrix,
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $uMatrix,
            'Matrix U is not equal'
        );
    }

    /**
     * Tests LinAlg::lud with 2x4 matrix
     */
    public function testLUDecomposition2x4()
    {
        $numArray = new NumArray(
            [
                [4, 2, 1, 8],
                [2, 3, 5, 1],
            ]
        );

        $expectedP = NumPHP::identity(2);
        $expectedL = new NumArray(
            [
                [  1, 0],
                [1/2, 1],
            ]
        );
        $expectedU = new NumArray(
            [
                [4, 2,   1,  8],
                [0, 2, 9/2, -3],
            ]
        );
        list($pMatrix, $lMatrix, $uMatrix) = LinAlg::lud($numArray);
        $this->assertNumArrayEquals(
            $expectedP,
            $pMatrix,
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $lMatrix,
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $uMatrix,
            'Matrix U is not equal'
        );
    }

    /**
     * Tests LinAlg::lud with 4x3 matrix
     */
    public function testLUDecomposition4x3()
    {
        $array = [
            [5, 1, 3],
            [4, 1, 2],
            [8, 6, 3],
            [2, 8, 5]
        ];

        $expectedP = new NumArray(
            [
                [0, 0, 1, 0],
                [0, 0, 0, 1],
                [1, 0, 0, 0],
                [0, 1, 0, 0]
            ]
        );
        $expectedL = new NumArray(
            [
                [1,        0,     0],
                [1/4,      1,     0],
                [5/8, -11/26,     1],
                [1/2,  -4/13, 47/76]
            ]
        );
        $expectedU = new NumArray(
            [
                [8,    6,     3],
                [0, 13/2,  17/4],
                [0,    0, 38/13]
            ]
        );
        list($pMatrix, $lMatrix, $uMatrix) = LinAlg::lud($array);
        $this->assertNumArrayEquals(
            $expectedP,
            $pMatrix,
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $lMatrix,
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $uMatrix,
            'Matrix U is not equal'
        );
    }

    /**
     * Tests LinAlg::lud with singular 4x4 matrix
     */
    public function testLUDecompositionSingularMatrix()
    {
        $matrix = NumPHP::identity(4);
        $matrix->set(2, 2, 0);

        $expectedP = NumPHP::identity(4);
        $expectedL = NumPHP::identity(4);
        $expectedU = NumPHP::identity(4);
        $expectedU->set(2, 2, 0);

        list($pMatrix, $lMatrix, $uMatrix) = LinAlg::lud($matrix);
        $this->assertNumArrayEquals(
            $expectedP,
            $pMatrix,
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $lMatrix,
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $uMatrix,
            'Matrix U is not equal'
        );
    }

    /**
     * Tests if NoMatrixException will be thrown, when using LinAlg::lud a vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoMatrixException
     * @expectedExceptionMessage NumArray with dimension 1 given, NumArray should have 2 dimensions
     */
    public function testLUDecompositionVector()
    {
        $numArray = NumPHP::arange(1, 2);

        LinAlg::lud($numArray);
    }

    /**
     * Tests cache of LinAlg::lud
     */
    public function testLUDecompositionCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION, 8);

        $this->assertSame(8, LinAlg::lud($numArray));
    }
}
