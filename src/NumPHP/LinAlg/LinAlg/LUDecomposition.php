<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  LinAlg
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\Exception\NoMatrixException;

/**
 * Class LUDecomposition
 *
 * @category LinAlg
 * @package  NumPHP\LinAlg\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class LUDecomposition
{
    const CACHE_KEY_LU_DECOMPOSITION = 'lu-decomposition';

    /**
     * Factors a matrix into a pivot matrix, a lower and upper triangular matrix
     *
     * @param NumArray $array matrix
     *
     * @return array
     * @throws NoMatrixException will be thrown, if `array` is no matrix
     */
    public static function lud(NumArray $array)
    {
        Helper::checkMatrix($array);
        $numArray = clone $array;

        $shape = $numArray->getShape();
        $mAxis = $shape[0];
        $nAxis = $shape[1];
        $size = min($mAxis, $nAxis);
        $pArray = range(0, $mAxis-1);
        $lMatrix = NumPHP::zeros($mAxis, $size);

        for ($i = 0; $i < $size; $i++) {
            // pivoting
            $maxIndex = self::getPivotIndex($numArray, $i);
            if ($maxIndex !== $i) {
                $temp = $numArray->get($i);
                $numArray->set($numArray->get($maxIndex), $i);
                $numArray->set($temp, $maxIndex);
                $temp = $lMatrix->get($i);
                $lMatrix->set($lMatrix->get($maxIndex), $i);
                $lMatrix->set($temp, $maxIndex);
                $temp = $pArray[$i];
                $pArray[$i] = $pArray[$maxIndex];
                $pArray[$maxIndex] = $temp;
            }
            // elimination
            for ($j = $i+1; $j < $mAxis; $j++) {
                $fac = $numArray->get($j, $i)->getData()/
                    $numArray->get($i, $i)->getData();
                $lMatrix->set($fac, $j, $i);
                for ($k = $i+1; $k < $nAxis; $k++) {
                    $value = $numArray->get($j, $k)
                        ->sub($numArray->get($i, $k)->dot($fac));
                    $numArray->set($value, $j, $k);
                }
            }
        }

        return [
            'P' => self::buildPivotMatrix($pArray),
            'L' => $lMatrix->add(NumPHP::eye($mAxis, $size)),
            'U' => self::buildUMatrix($numArray),
        ];
    }

    /**
     * Builds pivot matrix out of an pivot vector
     *
     * @param array $pArray pivot vector
     *
     * @return NumArray
     */
    protected static function buildPivotMatrix(array $pArray)
    {
        $size = count($pArray);
        $pMatrix = NumPHP::zeros($size, $size);
        foreach ($pArray as $key => $value) {
            $pMatrix->set(1, $value, $key);
        }

        return $pMatrix;
    }

    /**
     * Build the upper triangular matrix from given matrix
     *
     * @param NumArray $numArray given matrix
     *
     * @return NumArray
     */
    protected static function buildUMatrix(NumArray $numArray)
    {
        $shape = $numArray->getShape();
        $nAxis = $shape[1];
        $size = min($shape[0], $nAxis);

        $uMatrix = NumPHP::zeros($size, $nAxis);
        for ($i = 0; $i < $size; $i++) {
            $uMatrix->set($numArray->get($i), $i);
            for ($j = 0; $j < $i; $j++) {
                $uMatrix->set(0, $i, $j);
            }
        }

        return $uMatrix;
    }

    /**
     * Searches the pivot index in an array
     *
     * @param NumArray $numArray given array
     * @param int      $iIndex   index
     *
     * @return int
     */
    protected static function getPivotIndex(NumArray $numArray, $iIndex)
    {
        $shape = $numArray->getShape();
        $mAxis = $shape[0];

        $max = abs($numArray->get($iIndex, $iIndex)->getData());
        $maxIndex = $iIndex;
        for ($j = $iIndex+1; $j < $mAxis; $j++) {
            $abs = abs($numArray->get($j, $iIndex)->getData());
            if ($abs > $max) {
                $max = $abs;
                $maxIndex = $j;
            }
        }

        return $maxIndex;
    }
}
