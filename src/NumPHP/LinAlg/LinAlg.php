<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\Exception\NoSquareMatrixException;
use NumPHP\LinAlg\Exception\SingularMatrixException;
use NumPHP\LinAlg\LinAlg\CholeskyDecomposition;
use NumPHP\LinAlg\LinAlg\Helper;
use NumPHP\LinAlg\LinAlg\LUDecomposition;
use NumPHP\LinAlg\LinAlg\LinearSystem;

/**
 * Class LinAlg
 *
 * @package   NumPHP\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @api
 * @since     1.0.0
 */
abstract class LinAlg
{
    const CACHE_KEY_DETERMINANT = 'determinant';
    const CACHE_KEY_INVERSE     = 'inverse';

    /**
     * Calculates the determinant of a matrix
     *
     * @param mixed $matrix matrix
     *
     * @throws NoSquareMatrixException will be thrown, if given array is no square matrix
     *
     * @api
     * @since 1.0.0
     *
     * @return float
     */
    public static function det($matrix)
    {
        if (!$matrix instanceof NumArray) {
            $matrix = new NumArray($matrix);
        } elseif ($matrix->inCache(self::CACHE_KEY_DETERMINANT)) {
            return $matrix->getCache(self::CACHE_KEY_DETERMINANT);
        }
        if (!Helper::isSquareMatrix($matrix)) {
            throw new NoSquareMatrixException(
                sprintf("Matrix with shape (%s) given, matrix has to be square", implode(', ', $matrix->getShape()))
            );
        }
        $shape = $matrix->getShape();

        $lud = self::lud($matrix);
        /**
         * Upper triangular matrix
         *
         * @var NumArray $uMatrix
         */
        $uMatrix = $lud[2];
        $det = 1;
        for ($i = 0; $i < $shape[0]; $i++) {
            $det *= $uMatrix->get($i, $i)->getData();
        }

        $matrix->setCache(self::CACHE_KEY_DETERMINANT, $det);

        return $det;
    }

    /**
     * Factors a matrix into a pivot matrix, a lower and upper triangular matrix
     *
     * @param mixed $matrix matrix
     *
     * @throws \NumPHP\LinAlg\Exception\NoMatrixException will be thrown, if `$array` is no matrix
     *
     * @api
     * @since 1.0.0
     *
     * @return array
     */
    public static function lud($matrix)
    {
        if (!$matrix instanceof NumArray) {
            $matrix = new NumArray($matrix);
        } elseif ($matrix->inCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION)) {
            return $matrix->getCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION);
        }

        $lud = LUDecomposition::lud($matrix);
        $matrix->setCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION, $lud);

        return self::lud($matrix);
    }

    /**
     * Calculates lower triangular matrix L of given symmetric positive definite matrix
     *
     * @param mixed $squareMatrix
     *
     * @throws Exception\InvalidArgumentException will be thrown, when `$squareMatrix` is not symmetric positive
     * definite
     * @throws NoSquareMatrixException    will be thrown, when `$squareMatrix` is not square
     * @throws NoSymmetricMatrixException will be thrown, when `$squareMatrix` is not symmetric
     *
     * @api
     * @since 1.0.2
     *
     * @return NumArray
     */
    public static function cholesky($squareMatrix)
    {
        if (!$squareMatrix instanceof NumArray) {
            $squareMatrix = new NumArray($squareMatrix);
        } elseif ($squareMatrix->inCache(CholeskyDecomposition::CACHE_KEY_CHOLESKY)) {
            return $squareMatrix->getCache(CholeskyDecomposition::CACHE_KEY_CHOLESKY);
        }

        $lMatrix = CholeskyDecomposition::cholesky($squareMatrix);
        $squareMatrix->setCache(CholeskyDecomposition::CACHE_KEY_CHOLESKY, $lMatrix);

        return self::cholesky($squareMatrix);
    }

    /**
     * Solves a linear system of a n*n matrix and a vector of size n
     *
     * @param mixed $squareMatrix matrix of size n*n
     * @param mixed $matrix       vector of size n or matrix of size n*m
     *
     * @throws \NumPHP\LinAlg\Exception\SingularMatrixException will be thrown, if `$squareMatrix` is singular
     *
     * @api
     * @since 1.0.0
     *
     * @return NumArray
     */
    public static function solve($squareMatrix, $matrix)
    {
        if (!$squareMatrix instanceof NumArray) {
            $squareMatrix = new NumArray($squareMatrix);
        }
        if (!$matrix instanceof NumArray) {
            $matrix = new NumArray($matrix);
        }

        return LinearSystem::solve($squareMatrix, $matrix);
    }

    /**
     * Calculates the inverse of a not singular square matrix
     *
     * @param mixed $squareMatrix not singular matrix
     *
     * @throws SingularMatrixException will be thrown, when `$squareMatrix` is singular
     *
     * @api
     * @since 1.0.0
     *
     * @return NumArray
     */
    public static function inv($squareMatrix)
    {
        if (!$squareMatrix instanceof NumArray) {
            $squareMatrix = new NumArray($squareMatrix);
        } elseif ($squareMatrix->inCache(self::CACHE_KEY_INVERSE)) {
            return $squareMatrix->getCache(self::CACHE_KEY_INVERSE);
        }
        if (!Helper::isNotSingularMatrix($squareMatrix)) {
            throw new SingularMatrixException("Matrix is singular");
        }

        $shape = $squareMatrix->getShape();
        $inv = self::solve($squareMatrix, NumPHP::identity($shape[0]));
        $squareMatrix->setCache(self::CACHE_KEY_INVERSE, $inv);

        return self::inv($squareMatrix);
    }
}
