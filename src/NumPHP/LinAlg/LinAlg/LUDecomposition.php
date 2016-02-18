<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\Exception\NoMatrixException;

/**
 * Class LUDecomposition
 *
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class LUDecomposition
{
    const CACHE_KEY_LU_DECOMPOSITION = 'lu-decomposition';

    /**
     * Factors a matrix into a pivot matrix, a lower and upper triangular matrix
     *
     * @param NumArray $array matrix
     *
     * @throws NoMatrixException will be thrown, if `array` is no matrix
     *
     * @return array
     *
     * @since 1.0.0
     */
    public static function lud(NumArray $array)
    {
        if (!Helper::isMatrix($array)) {
            throw new NoMatrixException(
                sprintf("NumArray with dimension %d given, NumArray should have 2 dimensions", $array->getNDim())
            );
        }
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
                $numArray->set($i, $numArray->get($maxIndex));
                $numArray->set($maxIndex, $temp);
                $temp = $lMatrix->get($i);
                $lMatrix->set($i, $lMatrix->get($maxIndex));
                $lMatrix->set($maxIndex, $temp);
                $temp = $pArray[$i];
                $pArray[$i] = $pArray[$maxIndex];
                $pArray[$maxIndex] = $temp;
            }
            // elimination
            for ($j = $i+1; $j < $mAxis; $j++) {
                $fac = 0;
                $facNumerator = $numArray->get($j, $i)->getData();
                $facDenominator = $numArray->get($i, $i)->getData();
                if ($facDenominator) {
                    $fac = $facNumerator/$facDenominator;
                }
                $lMatrix->set($j, $i, $fac);
                $slice = sprintf("%d:", $i+1);
                $numArray->set($j, $slice, $numArray->get($j, $slice)->sub($numArray->get($i, $slice)->mult($fac)));
            }
        }

        return [
            self::buildPivotMatrix($pArray),
            self::buildLMatrix($lMatrix),
            self::buildUMatrix($numArray),
        ];
    }

    /**
     * Builds pivot matrix out of an pivot vector
     *
     * @param array $pArray pivot vector
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    protected static function buildPivotMatrix(array $pArray)
    {
        $size = count($pArray);
        $pMatrix = NumPHP::zeros($size, $size);
        foreach ($pArray as $key => $value) {
            $pMatrix->set($value, $key, 1);
        }

        return $pMatrix;
    }

    /**
     * Build the upper triangular matrix from given matrix
     *
     * @param NumArray $numArray given matrix
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    protected static function buildUMatrix(NumArray $numArray)
    {
        $shape = $numArray->getShape();
        $nAxis = $shape[1];
        $size = min($shape[0], $nAxis);

        $uMatrix = NumPHP::zeros($size, $nAxis);
        for ($i = 0; $i < $size; $i++) {
            $slice = sprintf("%d:", $i);
            $uMatrix->set($i, $slice, $numArray->get($i, $slice));
        }

        return $uMatrix;
    }

    /**
     * Build the lower triangular matrix from given matrix
     *
     * @param NumArray $numArray given matrix
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    protected static function buildLMatrix(NumArray $numArray)
    {
        $shape = $numArray->getShape();
        $numArray->add(NumPHP::eye($shape[0], $shape[1]));

        return $numArray;
    }

    /**
     * Searches the pivot index in an array
     *
     * @param NumArray $numArray given array
     * @param int      $iIndex   index
     *
     * @return int
     *
     * @since 1.0.0
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
