<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Shape
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Shape
{
    /**
     * Returns the shape of an value or array
     *
     * @param mixed $data given data
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown, if the dimensions did not match
     *
     * @since 1.0.0
     */
    public static function getShape($data)
    {
        $shape = self::getShapeRecursive($data, []);

        $expectedCount = array_product($shape);
        $currentProduct = 1;
        for ($i = 0; $i < count($shape)-1; $i++) {
            $currentProduct *= $shape[$i];
            $expectedCount += $currentProduct;
        }
        if (count($data, COUNT_RECURSIVE) !== $expectedCount) {
            throw new InvalidArgumentException("Dimensions did not match");
        }

        return $shape;
    }

    /**
     * Gives a multidimensional array a new shape
     *
     * @param array $data     given data
     * @param array $shape    old shape
     * @param array $newShape new shape
     *
     * @return array
     *
     * @throws InvalidArgumentException will be thrown, if the new shape has other size than the old one
     *
     * @since 1.0.0
     */
    public static function reshape(array $data, array $shape, array $newShape)
    {
        $oldSize = Helper::multiply($shape);
        $newSize = Helper::multiply($newShape);
        if ($newSize !== $oldSize) {
            throw new InvalidArgumentException(
                'Total size of new array must be unchanged'
            );
        }
        return self::reshapeRecursive(
            self::reshapeToVectorRecursive($data),
            $newShape
        );
    }

    /**
     * Returns the shape of an value or array recursive
     *
     * @param mixed $data  given data
     * @param array $shape the current shape
     *
     * @return array
     *
     * @since 1.0.0
     */
    protected static function getShapeRecursive($data, array $shape)
    {
        if (is_array($data)) {
            $count = count($data);
            $shape[] = $count;
            if ($count) {
                $shape = self::getShapeRecursive($data[0], $shape);
            }
        }
        return $shape;
    }

    /**
     * Reshapes an multidimensional array to an simple array
     *
     * @param array $data given data
     *
     * @return array
     *
     * @since 1.0.0
     */
    protected static function reshapeToVectorRecursive(array $data)
    {
        $vector = [];
        foreach ($data as $row) {
            if (is_array($row)) {
                $vector = array_merge($vector, self::reshapeToVectorRecursive($row));
            } else {
                return $data;
            }
        }
        return $vector;
    }

    /**
     * Reshapes an multidimensional array to a new shape recursive
     *
     * @param array $data  given data
     * @param array $shape new shape
     *
     * @return array
     *
     * @since 1.0.0
     */
    protected static function reshapeRecursive(array $data, array $shape)
    {
        if (count($shape) > 1) {
            $reshaped = [];
            $axis = array_shift($shape);
            $length = count($data) / $axis;
            for ($i = 0; $i < $axis; $i++) {
                $reshaped[] = self::reshapeRecursive(
                    array_slice($data, $i*$length, $length),
                    $shape
                );
            }
            return $reshaped;
        }
        return $data;
    }
}
