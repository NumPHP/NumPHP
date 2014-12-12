<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
        if (is_array($data) && is_array($data[0])) {
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
