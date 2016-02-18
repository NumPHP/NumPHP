<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Dot
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Dot
{
    /**
     * Multiplies two int, float or arrays
     *
     * @param mixed $data1  data of the first factor
     * @param array $shape1 shape of the first factor
     * @param mixed $data2  data of the second factor
     * @param array $shape2 shape of the second factor
     *
     * @return array
     *
     * @throws InvalidArgumentException wil be thrown of the two factors can not be
     * multiplied
     *
     * @since 1.0.0
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
            sprintf(
                "Matrix with shape (%s) and matrix with shape (%s) are not align.",
                implode(', ', $shape1),
                implode(', ', $shape2)
            )
        );
    }

    /**
     * Multiplies the data with a scalar recursive
     *
     * @param mixed $data   given data
     * @param float $scalar given scalar
     *
     * @return mixed
     *
     * @since 1.0.0
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
     * Multiplies two vectors
     *
     * @param array $data1 first vector
     * @param array $data2 second vector
     *
     * @return mixed
     *
     * @throws InvalidArgumentException will be thrown if the vector sizes differ
     *
     * @since 1.0.0
     */
    protected static function dotVectorVector(array $data1, array $data2)
    {
        if (count($data1) !== count($data2)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Vector size %d is different to vector size %d",
                    count($data1),
                    count($data2)
                )
            );
        }

        $sum = 0;
        foreach ($data1 as $key => $value) {
            $sum += $value * $data2[$key];
        }

        return $sum;
    }

    /**
     * Multiplies a vector with a matrix
     *
     * @param array $data1 vector
     * @param array $data2 matrix
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown if the vector and matrix size differ
     *
     * @since 1.0.0
     */
    protected static function dotVectorMatrix(array $data1, array $data2)
    {
        if (count($data1) !== count($data2)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Vector size %d is different to matrix size %d",
                    count($data1),
                    count($data2)
                )
            );
        }

        $sum = 0;
        foreach ($data1 as $key => $value) {
            $sum += $value * $data2[$key][0];
        }

        return [$sum];
    }

    /**
     * Multiplies a matrix with a vector
     *
     * @param array $data1 matrix
     * @param array $data2 vector
     *
     * @return array|mixed
     *
     * @throws InvalidArgumentException will be thrown if the vector and matrix size differ
     *
     * @since 1.0.0
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
     * Multiplies two matrices
     *
     * @param array $data1 matrix1
     * @param array $data2 matrix2
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown if the matrix sizes differ
     *
     * @since 1.0.0
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
