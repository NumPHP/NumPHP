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
    /**
     * @param $array
     * @return array
     * @throws InvalidArgumentException
     */
    public static function lud($array)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        }
        if ($array->getNDim() !== 2) {
            throw new InvalidArgumentException(
                'NumArray with dimension '.$array->getNDim().' given, NumArray should have 2 dimensions'
            );
        }

        $shape = $array->getShape();
        $size = min($shape[0], $shape[1]);
        $pArray = range(0, $size-1);
        $lMatrix = NumPHP::identity($shape[0]);
        $uMatrix = clone $array;

        for ($i = 0; $i < $size; $i++) {
            // pivoting
            $max = abs($uMatrix->get($i, $i)->getData());
            $maxIndex = $i;
            for ($j = $i+1; $j < $shape[0]; $j++) {
                $abs = abs($uMatrix->get($j, $i)->getData());
                if ($abs > $max) {
                    $max = $abs;
                    $maxIndex = $j;
                }
            }
            if ($maxIndex !== $i) {
                $temp = $uMatrix->get($i);
                $uMatrix->set($uMatrix->get($maxIndex), $i);
                $uMatrix->set($temp, $maxIndex);
                $temp = $pArray[$i];
                $pArray[$i] = $pArray[$maxIndex];
                $pArray[$maxIndex] = $temp;
            }
            // elimination
            for ($j = $i+1; $j < $shape[0]; $j++) {
                $fac = $uMatrix->get($j, $i)->getData()/$uMatrix->get($i, $i)->getData();
                $lMatrix->set($fac, $j, $i);
                $uMatrix->set(0, $j, $i);
                for ($k = $i+1; $k < $shape[1]; $k++) {
                    $uMatrix->set($uMatrix->get($j, $k)->minus($uMatrix->get($i, $k)->dot($fac)), $j, $k);
                }
            }
        }

        return [
            'P' => self::buildPivotMatrix($pArray),
            'L' => $lMatrix,
            'U' => $uMatrix,
        ];
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
}
