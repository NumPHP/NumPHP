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
                'data' => self::dotScalar($data2, $data1),
                'shape' => $shape2,
            ];
        }
        if (empty($shape2)) {
            return [
                'data' => self::dotScalar($data1, $data2),
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
                    'data' => self::dotVectorMatrix($data1, $data2, $shape2),
                    'shape' => [$shape2[1]],
                ];
            }
        }
        $shape1Pop = $shape1;
        $dim = array_pop($shape1Pop);
        if (count($shape2) === 1 &&  $dim === $shape2[0]) {
            return [
                'data' => self::dotMatrixVector($data1, $shape1, $data2),
                'shape' => $shape1Pop,
            ];
        }
        if (count($shape2) === 2 && $dim === $shape2[0]) {
            $shape2Pop = $shape2;
            array_shift($shape2Pop);
            return [
                'data' => self::dotMatrixMatrix($data1, $shape1, $data2, $shape2),
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
     * Multiplies the data with a scalar
     *
     * @param mixed $data   given data
     * @param float $scalar given scalar
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function dotScalar($data, $scalar)
    {
        if (is_array($data)) {
            return array_map(
                function ($value) use ($scalar) {
                    return $value * $scalar;
                },
                $data
            );
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
            $sum += $value*$data2[$key];
        }

        return $sum;
    }

    /**
     * Multiplies a vector with a matrix
     *
     * @param array $data1  vector
     * @param array $data2  matrix
     * @param array $shape2 shape of matrix
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown if the vector and matrix size differ
     *
     * @since 1.0.0
     */
    protected static function dotVectorMatrix(array $data1, array $data2, array $shape2)
    {
        $count = count($data1);
        if ($count !== $shape2[0]) {
            throw new InvalidArgumentException(
                sprintf(
                    "Vector size %d is different to matrix size %d",
                    $count,
                    $shape2[0]
                )
            );
        }

        $transposeData = Transpose::getTranspose($data2, $shape2);
        $chunks = array_chunk($transposeData, $count);
        $data = [];
        foreach ($chunks as $chunk) {
            $data[] = self::dotVectorVector($data1, $chunk);
        }

        return $data;
    }

    /**
     * Multiplies a matrix with a vector
     *
     * @param array $data1  matrix
     * @param array $shape1 shape of matrix
     * @param array $data2  vector
     *
     * @return array|mixed
     *
     * @throws InvalidArgumentException will be thrown if the vector and matrix size differ
     *
     * @since 1.0.0
     */
    protected static function dotMatrixVector(array $data1, array $shape1, array $data2)
    {
        $count = count($data2);
        if ($count !== $shape1[1]) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can't dot matrix of shape (%s) and vector of shape (%s)",
                    implode(', ', $shape1),
                    count($data2)
                )
            );
        }

        $chunks = array_chunk($data1, $count);
        $data = [];
        foreach ($chunks as $chunk) {
            $data[] = self::dotVectorVector($chunk, $data2);
        }

        return $data;
    }

    /**
     * Multiplies two matrices
     *
     * @param array $data1  matrix1
     * @param array $shape1 shape of matrix1
     * @param array $data2  matrix2
     * @param array $shape2 shape of matrix2
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown if the matrix sizes differ
     *
     * @since 1.0.0
     */
    protected static function dotMatrixMatrix(array $data1, array $shape1, array $data2, array $shape2)
    {
        $count = $shape1[1];
        if ($count !== $shape2[0]) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can't dot matrix of shape (%s) and matrix of shape (%s)",
                    implode(', ', $shape1),
                    implode(', ', $shape2)
                )
            );
        }

        $product = [];
        $chunks1 = array_chunk($data1, $count);
        $chunks2 = array_chunk(Transpose::getTranspose($data2, $shape2), $count);
        foreach ($chunks1 as $chunk1) {
            foreach ($chunks2 as $chunk2) {
                $product[] = self::dotVectorVector($chunk1, $chunk2);
            }
        }

        return $product;
    }
}
