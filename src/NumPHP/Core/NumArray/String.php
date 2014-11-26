<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/26/14
 * Time: 7:49 AM
 */

namespace NumPHP\Core\NumArray;

/**
 * Class String
 * @package NumPHP\Core\NumArray
 */
class String
{
    /**
     * @param $array
     * @return string
     */
    public static function toString($array)
    {
        return self::toStringRecursive($array);
    }

    /**
     * @param $array
     * @param int $level
     * @return string
     */
    protected static function toStringRecursive($array, $level = 0)
    {
        $repeat = str_repeat("  ", $level);
        if (is_array($array)) {
            $string = $repeat."(\n";
            for ($i = 0; $i < count($array)-1; $i++) {
                $string .= self::toStringRecursive($array[$i], $level+1).",\n";
            }
            if (count($array)) {
                $string .= self::toStringRecursive($array[$i], $level+1);
            }
            $string .= "\n".$repeat.")";
            return $string;
        }
        return $repeat.(string) $array;
    }
}
