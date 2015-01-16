<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Set
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Set
{
    /**
     * Replaces a value or sub array at the given position
     *
     * @param mixed $origData given data
     * @param mixed $subData  replacing data
     * @param array $args     array of indices
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function setSubArray($origData, $subData, array $args)
    {
        return self::setRecursive($origData, $subData, $args);
    }

    /**
     * Replaces a value or sub array at the given position recursive
     *
     * @param mixed $origData given data
     * @param mixed $subData  replacing data
     * @param array $args  array of indices
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function setRecursive($origData, $subData, array $args)
    {
        if (isset($args[0])) {
            $arg = array_shift($args);
            $indexArg = Helper::prepareIndexArgument($arg, $origData);
            if (is_array($indexArg)) {
                $counter = 0;
                for ($i = $indexArg['from']; $i < $indexArg['to']; $i++) {
                    $origData[$i] = self::setRecursive($origData[$i], $subData[$counter], $args);
                    $counter++;
                }

                return $origData;
            }
            $origData[$indexArg] = self::setRecursive(
                $origData[$indexArg],
                $subData,
                $args
            );

            return $origData;
        }

        return $subData;
    }
}
