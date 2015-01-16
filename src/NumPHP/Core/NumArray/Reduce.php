<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;
use NumPHP\Core\NumArray;

/**
 * Class Reduce
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Reduce
{
    /**
     * Combines all elements of an NumArray at a given axis with the `$callback`
     * function
     *
     * @param NumArray $numArray given NumArray
     * @param callback $callback callback function
     * @param int      $axis     given axis
     *
     * @return NumArray
     *
     * @throws InvalidArgumentException will be thrown, if axis is out of bounds
     *
     * @since 1.0.0
     */
    public static function reduceArray(NumArray $numArray, $callback, $axis)
    {
        if ($axis && $axis >= $numArray->getNDim()) {
            throw new InvalidArgumentException('Axis '.$axis.' out of bounds');
        }

        return new NumArray(
            self::reduceRecursive($numArray->getData(), $callback, $axis)
        );
    }

    /**
     * Combines all elements of an NumArray at a given axis with the `$callback`
     * function recursive
     *
     * @param mixed    $data     given data
     * @param callback $callback callback fucntion
     * @param int      $axis     given axis
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function reduceRecursive($data, $callback, $axis = null)
    {
        if (is_array($data)) {
            if (!is_null($axis) && $axis > 0) {
                foreach ($data as $key => $value) {
                    $data[$key] = self::reduceRecursive($value, $callback, $axis -1);
                }

                return $data;
            }
            $sum = array_shift($data);
            foreach ($data as $value) {
                $sum = Map::mapArray($sum, $value, $callback);
            }

            if ($axis === 0) {
                return $sum;
            }

            return self::reduceRecursive($sum, $callback);
        }

        return $data;
    }
}
