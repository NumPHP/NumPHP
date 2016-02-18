<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumPHP;

/**
 * Class Generate
 *
 * @package   NumPHP\Core\NumPHP
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Generate
{
    /**
     * Generates an array with the given shape and value
     *
     * @param array $shape shape of the array
     * @param null  $value value of the array, if not given `$value` will be random
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function generateArray(array $shape, $value = null)
    {
        return self::generateArrayRecursive($shape, $value);
    }

    /**
     * Generates an array with the given shape and value recursive
     *
     * @param array $shape shape of the array
     * @param mixed $value value of the array, if not given `$value` will be random
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function generateArrayRecursive(array $shape, $value = null)
    {
        if (count($shape)) {
            $array = [];
            $dim = array_shift($shape);
            for ($i = 0; $i < $dim; $i++) {
                $array[] = self::generateArrayRecursive($shape, $value);
            }
            return $array;
        }
        if (is_null($value)) {
            return mt_rand() / mt_getrandmax();
        }
        return $value;
    }
}
