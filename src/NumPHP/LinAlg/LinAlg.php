<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\NoSquareMatrixException;
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
 * @since     1.0.0
 */
abstract class LinAlg
{
    const VERSION = '1.0.0-dev6';

    const CACHE_KEY_DETERMINANT = 'determinant';

    /**
     * Calculates the determinant of a matrix
     *
     * @param mixed $array matrix
     *
     * @throws NoSquareMatrixException will be thrown, if given array is no square matrix
     *
     * @return int
     */
    public static function det($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        } elseif ($array->inCache(self::CACHE_KEY_DETERMINANT)) {
            return $array->getCache(self::CACHE_KEY_DETERMINANT);
        }
        if (!Helper::isSquareMatrix($array)) {
            throw new NoSquareMatrixException(
                sprintf("Matrix with shape (%s) given, matrix has to be square", implode(', ', $array->getShape()))
            );
        }
        $shape = $array->getShape();

        $lud = self::lud($array);
        /**
         * Upper triangular matrix
         *
         * @var NumArray $uMatrix
         */
        $uMatrix = $lud['U'];
        $det = 1;
        for ($i = 0; $i < $shape[0]; $i++) {
            $det *= $uMatrix->get($i, $i)->getData();
        }

        $array->setCache(self::CACHE_KEY_DETERMINANT, $det);

        return $det;
    }

    /**
     * Factors a matrix into a pivot matrix, a lower and upper triangular matrix
     *
     * @param mixed $array matrix
     *
     * @throws \NumPHP\LinAlg\Exception\NoMatrixException will be thrown, if `$array` is no matrix
     *
     * @return array
     */
    public static function lud($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        } elseif ($array->inCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION)) {
            return $array->getCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION);
        }

        $result = LUDecomposition::lud($array);
        $array->setCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION, $result);

        return $result;
    }

    /**
     * Solves a linear system of a n*n matrix and a vector of size n
     *
     * @param mixed $squareMatrix matrix of size n*n
     * @param mixed $matrix       vector of size n or matrix of size n*m
     *
     * @throws \NumPHP\LinAlg\Exception\SingularMatrixException will be thrown, if `$squareMatrix` is singular
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
}
