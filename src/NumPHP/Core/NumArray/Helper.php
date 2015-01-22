<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Helper
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Helper
{
    /**
     * Calculates the indexes of a position with given shape
     *
     * @param int   $position position
     * @param array $shape    shape
     *
     * @return array
     */
    public static function getIndexesFromPosition($position, array $shape)
    {
        $indexes = [];
        for ($i = count($shape)-1; $i >= 0; $i--) {
            $axis = $shape[$i];
            $indexes[] = $position % $axis;
            $position /= $axis;
        }

        return array_reverse($indexes);
    }

    /**
     * Multiplies the indexes with factors to return the position in an NumArray. Use getFactorsFromShape to calculate
     * the factors from a shape
     *
     * @param array $indexes indexes
     * @param array $factors factors
     *
     * @return int
     */
    public static function getPositionFromIndexes(array $indexes, array $factors)
    {
        return array_sum(
            array_map(
                function ($value1, $value2) {
                    return $value1 * $value2;
                },
                $indexes,
                $factors
            )
        );
    }

    /**
     * Calculates the factors from a given shape
     *
     * @param array $shape shape
     *
     * @return array
     */
    public static function getFactorsFromShape(array $shape)
    {
        $factors = $shape;
        $factors[] = 1;
        array_shift($factors);
        $pre = 1;
        for ($i = count($factors)-1; $i >= 0; $i--) {
            $pre *= $factors[$i];
            $factors[$i] = $pre;
        }

        return $factors;
    }

    /**
     * Prepares the argument of an index. If `$index` is an integer it will returned and if `$index` is a string like
     * `1:5`, `:8` or `-4:` it will return an array with the keys `from` and `to`
     *
     * @param mixed $index given index argument
     * @param array $data  the given data where the indexes work on
     *
     * @return array|int
     *
     * @since 1.0.0
     */
    public static function prepareIndexArgument($index, array $data)
    {
        $matches = [];
        $pregMatch = preg_match('/^(?P<from>([-]{0,1}\d+)*):(?P<to>([-]{0,1}\d+)*)$/', $index, $matches);
        // argument is a slice like 5:8 for example
        if ($pregMatch) {
            $fromValue = $matches['from'];
            if (!$fromValue) {
                $fromValue = 0;
            }
            $toValue = $matches['to'];
            if (!$toValue && trim($toValue) !== "0") {
                $toValue = count($data);
            }

            return [
                'from' => (int) $fromValue,
                'to'   => (int) $toValue
            ];
        }

        $index = (int) $index;
        if ($index < 0) {
            $index += count($data);
        }

        return $index;
    }
}
