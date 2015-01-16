<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Get
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Get
{
    /**
     * Returns a sliced sub array
     *
     * @param mixed $data given data
     * @param array $args array of indices or slices like `:`, `3:`, `1:6`
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function getSubArray($data, array $args)
    {
        return self::getRecursive($data, $args);
    }

    /**
     * Returns a sliced sub array recursive
     *
     * @param mixed $data given data
     * @param array $args array of indices or slices like `:`, `3:`, `1:6`
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function getRecursive($data, array $args)
    {
        if (isset($args[0])) {
            $arg = array_shift($args);
            $indexArg = Helper::prepareIndexArgument($arg, $data);
            if (is_array($indexArg)) {
                $sliced = array_slice($data, $indexArg['from'], $indexArg['to'] - $indexArg['from']);
                foreach ($sliced as $index => $row) {
                    $sliced[$index] = self::getRecursive($row, $args);
                }
                return $sliced;
            }
            return self::getRecursive($data[$indexArg], $args);
        }
        return $data;
    }
}
