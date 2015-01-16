<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Filter
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Filter
{
    /**
     * Applies `$callback` on every element in `$data`
     *
     * @param mixed    $data     given data
     * @param callback $callback callback function
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function filterArray($data, $callback)
    {
        return self::filterRecursive($data, $callback);
    }

    /**
     * Applies `$callback` on every element in `$data` recursive
     *
     * @param mixed    $data     given data
     * @param callback $callback callback fucntion
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function filterRecursive($data, $callback)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::filterRecursive($value, $callback);
            }

            return $data;
        }

        return $callback($data);
    }
}
