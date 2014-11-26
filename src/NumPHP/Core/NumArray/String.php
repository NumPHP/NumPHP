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
     * @param $data
     * @return string
     */
    public static function toString($data)
    {
        return self::toStringRecursive($data);
    }

    /**
     * @param $array
     * @param int $level
     * @return string
     */
    protected static function toStringRecursive($data, $level = 0)
    {
        $repeat = str_repeat("  ", $level);
        if (is_array($data)) {
            $string = $repeat."(\n";
            for ($i = 0; $i < count($data)-1; $i++) {
                $string .= self::toStringRecursive($data[$i], $level+1).",\n";
            }
            if (count($data)) {
                $string .= self::toStringRecursive($data[$i], $level+1);
            }
            $string .= "\n".$repeat.")";
            return $string;
        }
        return $repeat.(string) $data;
    }
}
