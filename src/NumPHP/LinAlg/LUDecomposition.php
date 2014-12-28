<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\Exception\InvalidArgumentException;

/**
 * Class LUDecomposition
  * @package NumPHP\LinAlg
  */
class LUDecomposition
{
    const CACHE_KEY_LU_DECOMPOSITION = 'lu-decomposition';

    /**
     * @param $array
     * @return array
     * @throws InvalidArgumentException
     */
    public static function lud($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        } elseif ($array->inCache(self::CACHE_KEY_LU_DECOMPOSITION)) {
            // check if result is in array cache
            return $array->getCache(self::CACHE_KEY_LU_DECOMPOSITION);
        }
        if ($array->getNDim() !== 2) {
            throw new InvalidArgumentException(
                'NumArray with dimension '.$array->getNDim().' given, NumArray should have 2 dimensions'
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
                $fac = $numArray->get($j, $i)->getData()/$numArray->get($i, $i)->getData();
                $lMatrix->set($fac, $j, $i);
                for ($k = $i+1; $k < $nAxis; $k++) {
                    $value = $numArray->get($j, $k)->sub($numArray->get($i, $k)->dot($fac));
                    $numArray->set($value, $j, $k);
                }
            }
        }
        $result = [
            'P' => self::buildPivotMatrix($pArray),
            'L' => $lMatrix->add(NumPHP::eye($mAxis, $size)),
            'U' => self::buildUMatrix($numArray),
        ];
        // write result into array cache
        $array->setCache(self::CACHE_KEY_LU_DECOMPOSITION, $result);

        return $result;
    }

    /**
     * @param array $pArray
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
     * @param NumArray $numArray
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
     * @param NumArray $numArray
     * @param $iIndex
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
