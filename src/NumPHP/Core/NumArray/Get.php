<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/26/14
 * Time: 7:43 AM
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\NumArray;

/**
 * Class Get
 * @package NumPHP\Core\NumArray
 */
class Get
{
    /**
     * @param $array
     * @param array $args
     * @return mixed|NumArray
     */
    public static function get($array, array $args)
    {
        $array = self::getRecursive($array, $args);

        if (is_array($array)) {
            return new NumArray($array);
        }
        return $array;
    }

    /**
     * @param $array
     * @param array $args
     * @return mixed
     */
    protected static function getRecursive($array, array $args)
    {
        if (isset($args[0])) {
            $arg = $args[0];
            $matches = [];
            array_shift($args);
            if (preg_match('/^(?P<from>\d*):(?P<to>\d*)$/', $arg, $matches)) {
                $fromValue = $matches['from'];
                $toValue = $matches['to'];
                $sliced = self::slice($array, $fromValue, $toValue);
                foreach ($sliced as $index => $row) {
                    $sliced[$index] = self::getRecursive($row, $args);
                }
                return $sliced;
            }
            return self::getRecursive($array[$arg], $args);
        }
        return $array;
    }

    /**
     * @param $array
     * @param $fromValue
     * @param $toValue
     * @return array
     */
    protected static function slice(array $array, $fromValue, $toValue)
    {
        if (!$fromValue) {
            $fromValue = 0;
        }
        if (!$toValue && $toValue !== 0) {
            $toValue = count($array);
        }
        return array_slice($array, $fromValue, $toValue-$fromValue);
    }
}
