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
use NumPHP\LinAlg\LinAlg\LUDecomposition;

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
        if ($array->getNDim() !== 2) {
            throw new NoMatrixException(
                sprintf(
                    "NumArray with dimension %d given, NumArray should have 2 ".
                    "dimensions",
                    $array->getNDim()
                )
            );
        }
        $shape = $array->getShape();
        if ($shape[0] !== $shape[1]) {
            throw new NoSquareMatrixException(
                sprintf(
                    "NumArray with shape (%s) given, NumArray has to be square",
                    implode(', ', $shape)
                )
            );
        }

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
}
