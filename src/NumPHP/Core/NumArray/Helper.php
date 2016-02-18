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
     * Multiplies all entries of an array
     *
     * @param array $array given array of floats or integers
     *
     * @return float
     *
     * @throws InvalidArgumentException will be thrown, if a value in the array is not numeric
     *
     * @since 1.0.0
     */
    public static function multiply(array $array)
    {
        return array_reduce(
            $array,
            function ($prod, $item) {
                if (!is_numeric($item)) {
                    throw new InvalidArgumentException(
                        'Array contains non numeric values'
                    );
                }
                return $prod * $item;
            },
            1
        );
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
