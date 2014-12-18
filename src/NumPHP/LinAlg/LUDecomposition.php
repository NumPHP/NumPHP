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
        $numArray = clone $array;

        $shape = $numArray->getShape();
        $mAxis = $shape[0];
        $nAxis = $shape[1];
        $size = min($mAxis, $nAxis);
        $pArray = range(0, $mAxis-1);
        $lMatrix = NumPHP::zeros($mAxis, $size);
        $uMatrix = NumPHP::zeros($size, $nAxis);

        for ($i = 0; $i < $size; $i++) {
            // pivoting
            $max = abs($numArray->get($i, $i)->getData());
            $maxIndex = $i;
            for ($j = $i+1; $j < $mAxis; $j++) {
                $abs = abs($numArray->get($j, $i)->getData());
                if ($abs > $max) {
                    $max = $abs;
                    $maxIndex = $j;
                }
            }
            if ($maxIndex !== $i) {
                $temp = $numArray->get($i);
                $numArray->set($numArray->get($maxIndex), $i);
                $numArray->set($temp, $maxIndex);
                $temp = $uMatrix->get($i);
                $uMatrix->set($uMatrix->get($maxIndex), $i);
                $uMatrix->set($temp, $maxIndex);
                $temp = $lMatrix->get($i);
                $lMatrix->set($lMatrix->get($maxIndex), $i);
                $lMatrix->set($temp, $maxIndex);
                $temp = $pArray[$i];
                $pArray[$i] = $pArray[$maxIndex];
                $pArray[$maxIndex] = $temp;
            }
            if ($i === 0) {
                $uMatrix->set($numArray->get(0), 0);
            }
            // elimination
            for ($j = $i+1; $j < $mAxis; $j++) {
                $fac = $numArray->get($j, $i)->getData()/$numArray->get($i, $i)->getData();
                $lMatrix->set($fac, $j, $i);
                $uMatrix->set(0, $j, $i);
                for ($k = $i+1; $k < $nAxis; $k++) {
                    $value = $numArray->get($j, $k)->minus($numArray->get($i, $k)->dot($fac));
                    $numArray->set($value, $j, $k);
                    $uMatrix->set($value, $j, $k);
                }
            }
        }

        return [
            'P' => self::buildPivotMatrix($pArray),
            'L' => $lMatrix->add(NumPHP::eye($mAxis, $size)),
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
