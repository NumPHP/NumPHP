<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  LinAlg
 * @package   NumPHP\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\NoMatrixException;
use NumPHP\LinAlg\Exception\NoSquareMatrixException;
use NumPHP\LinAlg\LinAlg\Helper;
use NumPHP\LinAlg\LinAlg\LUDecomposition;
use NumPHP\LinAlg\LinAlg\SolveLinearSystem;

/**
 * Class LinAlg
 *
 * @category LinAlg
 * @package  NumPHP\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class LinAlg
{
    const VERSION = '1.0.0-dev5';

    /**
     * Calculates the determinant of a matrix
     *
     * @param mixed $array matrix
     *
     * @return int
     * @throws NoMatrixException will be thrown, if given array is no matrix
     * @throws NoSquareMatrixException will be thrown, if given array is no square
     * matrix
     */
    public static function det($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        }
        Helper::checkSquareMatrix($array);
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

        return $det;
    }

    /**
     * Factors a matrix into a pivot matrix, a lower and upper triangular matrix
     *
     * @param mixed $array matrix
     *
     * @return array
     * @throws NoMatrixException will be thrown, if `$array` is no matrix
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
     * @param mixed $vector       vector of size n
     *
     * @return NumArray
     */
    public static function solve($squareMatrix, $vector)
    {
        if (!$squareMatrix instanceof NumArray) {
            $squareMatrix = new NumArray($squareMatrix);
        }
        if (!$vector instanceof NumArray) {
            $vector = new NumArray($vector);
        }

        return SolveLinearSystem::solve($squareMatrix, $vector);
    }
}
