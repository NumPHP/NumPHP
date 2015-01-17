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
 * Class CholeskyDecompositionTest
 *
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */
class CholeskyDecompositionTest extends TestCase
{
    /**
     * Tests if LinAlg::cholesky works as expected with valid input
     */
    public function testCholesky()
    {
        $squareMatrix = new NumArray(
            [
                [ 1,   5,  -3],
                [ 5,  74, -78],
                [-3, -78, 115]
            ]
        );

        $expectedLMatrix = new NumArray(
            [
                [ 1,  0, 0],
                [ 5,  7, 0],
                [-3, -9, 5]
            ]
        );

        $this->assertNumArrayEquals($expectedLMatrix, LinAlg::cholesky($squareMatrix));
    }

    public function testCholeskyArray()
    {
        $matrix = [
            [ 1156,  170,  2108,  -2074],
            [  170,   89,   238,   -321],
            [ 2108,  238,  4046,  -3863],
            [-2074, -321, -3863, 570815]
        ];

        $expectedLMatrix = new NumArray(
            [
                [ 34,  0,  0,   0],
                [  5,  8,  0,   0],
                [ 62, -9, 11,   0],
                [-61, -2, -9, 753]
            ]
        );

        $this->assertNumArrayEquals($expectedLMatrix, LinAlg::cholesky($matrix));
    }

    /**
     * Tests if NoSquareMatrixException will be thrown, when using LinAlg::cholesky with not square matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoSquareMatrixException
     * @expectedExceptionMessage Matrix with shape (2, 3) given, matrix has to be square
     */
    public function testCholeskyNotSquare()
    {
        $matrix = NumPHP::arange(1, 6)->reshape(2, 3);

        LinAlg::cholesky($matrix);
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using LinAlg::cholesky with not positive definite matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\InvalidArgumentException
     * @expectedExceptionMessage Matrix is not positive definite
     */
    public function testCholeskyNotPositiveDefinite()
    {
        $matrix = new NumArray([[-1]]);

        LinAlg::cholesky($matrix);
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using LinAlg::cholesky with not symmetric matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoSymmetricMatrixException
     * @expectedExceptionMessage Matrix is not symmetric
     */
    public function testCholeskyNotSymmetric()
    {
        $matrix = new NumArray(
            [
                [1, 2],
                [3, 1]
            ]
        );

        LinAlg::cholesky($matrix);
    }

    public function testCholeskyCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache(LinAlg\CholeskyDecomposition::CACHE_KEY_CHOLESKY, 8);

        $this->assertSame(8, LinAlg::cholesky($numArray));
    }
}
