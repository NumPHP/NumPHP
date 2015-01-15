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
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class LinearSystemTest
 *
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class LinearSystemTest extends TestCase
{
    /**
     * Tests LinAlg::solve with 3x3 matrix
     */
    public function testSolveVector()
    {
        $matrix = new NumArray(
            [
                [ 11,  44,  1],
                [0.1, 0.4,  3],
                [  0,   1, -1]
            ]
        );
        $vector = NumPHP::ones(3);

        $expectedNumArray = new NumArray(
            [-1732/329, 438/329, 109/329]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            LinAlg::solve($matrix, $vector)
        );
    }

    /**
     * Tests LinAlg::solve with identity matrix and ones vector as arrays
     */
    public function testSolveVectorArray()
    {
        $matrix = NumPHP::identity(5)->getData();
        $vector = NumPHP::ones(5)->getData();

        $expectedNumArray = NumPHP::ones(5);
        $this->assertNumArrayEquals(
            $expectedNumArray,
            LinAlg::solve($matrix, $vector)
        );
    }

    /**
     * Tests LinAlg::solve with a matrix
     */
    public function testSolveMatrix()
    {
        $squareMatrix = new NumArray(
            [
                [1, 2, 3],
                [2, 3, 1],
                [3, 1, 2]
            ]
        );
        $matrix = new NumArray(
            [
                [38, 44, 50, 56],
                [26, 32, 38, 44],
                [26, 32, 38, 44]
            ]
        );

        $expectedNumArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $this->assertNumArrayEquals($expectedNumArray, LinAlg::solve($squareMatrix, $matrix));
    }

    /**
     * Tests if SingularMatrixException will be thrown, when using LinAlg::solve with singular matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\SingularMatrixException
     * @expectedExceptionMessage First Argument has to be a not singular square matrix
     */
    public function testSolveSingular()
    {
        $matrix = NumPHP::identity(4);
        $matrix->set(1, 1, 0);
        $vector = NumPHP::arange(1, 4);

        LinAlg::solve($matrix, $vector);
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using LinAlg::solve with 2x3x4 matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\InvalidArgumentException
     * @expectedExceptionMessage Second argument has to be a vector or a matrix, NumArray with dimension 3 given
     */
    public function testSolve2x3x4Matrix()
    {
        $identity = NumPHP::identity(2);
        $matrix = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        LinAlg::solve($identity, $matrix);
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using LinAlg::solve with not align matrix and vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\InvalidArgumentException
     * @expectedExceptionMessage Can not solve a linear system with matrix (4, 4) and matrix (3)
     */
    public function testSolveNotAlign()
    {
        $matrix = NumPHP::identity(4);
        $vector = NumPHP::ones(3);

        LinAlg::solve($matrix, $vector);
    }
}
