<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Map
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Map
{
    /**
     * Combines two int, float or arrays with the `$callback` function
     *
     * @param mixed    $array1   first data
     * @param mixed    $array2   second data
     * @param callback $callback callback function
     *
     * @return mixed
     *
     * @throws InvalidArgumentException will be thrown, if the sizes are different
     *
     * @since 1.0.0
     */
    public static function mapArray($array1, $array2, $callback)
    {
        return self::mapRecursive($array1, $array2, $callback);
    }

    /**
     * Combines two int, float or arrays with the `$callback` function recursive
     *
     * @param mixed    $data1    first data
     * @param mixed    $data2    second data
     * @param callback $callback callback function
     *
     * @return array|mixed
     *
     * @throws InvalidArgumentException will be thrown, if the sizes are different
     *
     * @since 1.0.0
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected static function mapRecursive($data1, $data2, $callback)
    {
        if (is_array($data1)) {
            $size1 = count($data1);
            if (is_array($data2)) {
                if (count($data1) !== count($data2)) {
                    throw new InvalidArgumentException(
                        sprintf(
                            "Size %s is different from size %s",
                            count($data1),
                            count($data2)
                        )
                    );
                }
                for ($i = 0; $i < $size1; $i++) {
                    $data1[$i] = self::mapRecursive(
                        $data1[$i],
                        $data2[$i],
                        $callback
                    );
                }
            } else {
                for ($i = 0; $i < $size1; $i++) {
                    $data1[$i] = self::mapRecursive($data1[$i], $data2, $callback);
                }
            }
        } else {
            if (is_array($data2)) {
                $size2 = count($data2);
                for ($i = 0; $i < $size2; $i++) {
                    $data2[$i] = self::mapRecursive($data1, $data2[$i], $callback);
                }

                return $data2;
            }
            $data1 = $callback($data1, $data2);
        }

        return $data1;
    }
}
