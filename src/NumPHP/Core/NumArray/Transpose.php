<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Transpose
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Transpose
{
    const CACHE_KEY_TRANSPOSE = 'transpose';

    /**
     * Creates a transposed value or array
     *
     * @param mixed $data  given data
     * @param array $shape the shape of the data
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    public static function getTranspose($data, array $shape)
    {
        if (is_array($data)) {
            $keyArray = [];
            self::getTransposeIndexes($shape, $keyArray);

            return array_combine($keyArray, $data);
        }

        return $data;
    }

    protected static function getTransposeIndexes(array $shape, &$indexes, $sum = 0, $fac = 1)
    {
        if (count($shape) == 1) {
            $axis = array_shift($shape);
            for ($i = 0; $i < $axis; $i++) {
                $indexes[] = $sum + $fac * $i;
            }
        } else {
            $axis = array_shift($shape);
            for ($i = 0; $i < $axis; $i++) {
                self::getTransposeIndexes($shape, $indexes, $sum + $fac * $i, $fac * $axis);
            }
        }
    }
}
