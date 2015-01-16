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
        return self::getTransposeRecursive($data, $shape);
    }

    /**
     * Creates a transposed value or array recursive
     *
     * @param mixed $data         given data
     * @param array $shape        the current shape
     * @param array $indexes      given indexes
     * @param int   $currentIndex current index
     *
     * @return mixed
     *
     * @since 1.0.0
     */
    protected static function getTransposeRecursive(
        $data,
        array $shape,
        array $indexes = array(),
        $currentIndex = null
    ) {
        if (!is_null($currentIndex)) {
            $indexes[] = $currentIndex;
        }
        if (count($shape)) {
            $transpose = [];
            $axis = array_pop($shape);
            for ($i = 0; $i < $axis; $i++) {
                $transpose[] = self::getTransposeRecursive(
                    $data,
                    $shape,
                    $indexes,
                    $i
                );
            }
            return $transpose;
        }
        return Get::getSubArray($data, array_reverse($indexes));
    }
}
