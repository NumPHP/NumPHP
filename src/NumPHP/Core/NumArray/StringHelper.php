<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core\NumArray;

/**
 * Class StringHelper
 *
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class StringHelper
{
    /**
     * Returns a string representing an array
     *
     * @param mixed $data given data
     *
     * @return string
     *
     * @since 1.0.0
     */
    public static function toString($data)
    {
        return self::toStringRecursive($data);
    }

    /**
     * Returns a string representing an array recursive
     *
     * @param mixed $data  given data
     * @param int   $level current level
     *
     * @return string
     *
     * @since 1.0.0
     */
    protected static function toStringRecursive($data, $level = 0)
    {
        $repeat = str_repeat("  ", $level);
        if (is_array($data) && isset($data[0]) && is_array($data[0])) {
            $string = $repeat."[\n";
            for ($i = 0; $i < count($data)-1; $i++) {
                $string .= self::toStringRecursive($data[$i], $level+1).",\n";
            }
            if (count($data)) {
                $string .= self::toStringRecursive($data[$i], $level+1);
            }
            $string .= "\n".$repeat."]";
            return $string;
        }
        if (is_array($data)) {
            return $repeat.'['.implode(', ', $data)."]";
        }
        return $repeat.(string) $data;
    }
}
