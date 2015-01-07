<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Dot
  * @package NumPHP\Core\NumArray
  */
class Dot
{
    /**
     * @param $data1
     * @param array $shape1
     * @param $data2
     * @param array $shape2
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public static function dotArray($data1, array $shape1, $data2, array $shape2)
    {
        if (empty($shape1)) {
            return [
                'data' => self::dotScalarRecursive($data2, $data1),
                'shape' => $shape2,
            ];
        }
        if (empty($shape2)) {
            return [
                'data' => self::dotScalarRecursive($data1, $data2),
                'shape' => $shape1,
            ];
        }
        if (count($shape1) === 1) {
            if (count($shape2) === 1) {
                return [
                    'data' => self::dotVectorVector($data1, $data2),
                    'shape' => [],
                ];
            } elseif (count($shape2) === 2) {
                return [
                    'data' => self::dotVectorMatrix($data1, $data2),
                    'shape' => [1],
                ];
            }
        }
        $shape1Pop = $shape1;
        $dim = array_pop($shape1Pop);
        if (count($shape2) === 1 &&  $dim === $shape2[0]) {
            return [
                'data' => self::dotMatrixVector($data1, $data2),
                'shape' => $shape1Pop,
            ];
        }
        if (count($shape2) === 2 && $dim === $shape2[0]) {
            $shape2Pop = $shape2;
            array_shift($shape2Pop);
            return [
                'data' => self::dotMatrixMatrix($data1, $data2),
                'shape' => array_merge($shape1Pop, $shape2Pop),
            ];
        }

        throw new InvalidArgumentException(
            'Matrix with shape ('.implode(', ', $shape1).') and matrix with shape ('.implode(', ', $shape2).
            ') are not align.'
        );
    }

    /**
     * @param $data
     * @param $scalar
     * @return array|mixed
     */
    protected static function dotScalarRecursive($data, $scalar)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::dotScalarRecursive($value, $scalar);
            }

            return $data;
        }

        return $data * $scalar;
    }

    /**
     * @param array $data1
     * @param array $data2
     * @return mixed
     */
    protected static function dotVectorVector(array $data1, array $data2)
    {
        if (count($data1) !== count($data2)) {
            throw new InvalidArgumentException(
                'Vector size '.count($data1). ' is different to vector size '.count($data2)
            );
        }

        $sum = 0;
        foreach ($data1 as $key => $value) {
            $sum += $value * $data2[$key];
        }

        return $sum;
    }

    /**
     * @param array $data1
     * @param array $data2
     * @return array
     */
    protected static function dotVectorMatrix(array $data1, array $data2)
    {
        if (count($data1) !== count($data2)) {
            throw new InvalidArgumentException(
                'Vector size '.count($data1). ' is different to matrix size '.count($data2)
            );
        }

        $sum = 0;
        foreach ($data1 as $key => $value) {
            $sum += $value * $data2[$key][0];
        }

        return [$sum];
    }

    /**
     * @param array $data1
     * @param array $data2
     * @return array|mixed
     */
    protected static function dotMatrixVector(array $data1, array $data2)
    {
        if (is_array($data1[0])) {
            foreach ($data1 as $key => $value) {
                $data1[$key] = self::dotMatrixVector($value, $data2);
            }

            return $data1;
        }

        return self::dotVectorVector($data1, $data2);
    }

    /**
     * @param array $data1
     * @param array $data2
     * @return array
     */
    protected static function dotMatrixMatrix(array $data1, array $data2)
    {
        $product = [];
        $size2 = count($data2[0]);
        foreach ($data1 as $i => $rowI) {
            $row = [];
            for ($j = 0; $j < $size2; $j++) {
                $sum = 0;
                foreach ($rowI as $key => $value1) {
                    $sum += $value1 * $data2[$key][$j];
                }
                $row[$j] = $sum;
            }
            $product[$i] = $row;
        }

        return $product;
    }
}
