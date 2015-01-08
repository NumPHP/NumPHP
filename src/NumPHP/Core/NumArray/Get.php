<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHP\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\Core\NumArray;

/**
 * Class Get
 *
 * @category Core
 * @package  NumPHP\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class Get
{
    /**
     * Returns a sliced sub array
     *
     * @param mixed $data given data
     * @param array $args array of indices or slices like `:`, `3:`, `1:6`
     *
     * @return mixed
     */
    public static function getSubArray($data, array $args)
    {
        return self::getRecursive($data, $args);
    }

    /**
     * Returns a sliced sub array recursive
     *
     * @param mixed $data given data
     * @param array $args array of indices or slices like `:`, `3:`, `1:6`
     *
     * @return mixed
     */
    protected static function getRecursive($data, array $args)
    {
        if (isset($args[0])) {
            $arg = $args[0];
            $matches = [];
            array_shift($args);
            $pregMatch = preg_match(
                '/^(?P<from>([-]{0,1}\d+)*):(?P<to>([-]{0,1}\d+)*)$/',
                $arg,
                $matches
            );
            if ($pregMatch) {
                $fromValue = $matches['from'];
                $toValue = $matches['to'];
                $sliced = self::slice($data, $fromValue, $toValue);
                foreach ($sliced as $index => $row) {
                    $sliced[$index] = self::getRecursive($row, $args);
                }
                return $sliced;
            }
            if ($arg < 0) {
                $arg += count($data);
            }
            return self::getRecursive($data[$arg], $args);
        }
        return $data;
    }

    /**
     * Slices a array and returns a sub array from `$fromValue` to `$toValue`
     *
     * @param array $data      given array
     * @param int   $fromValue start of slicing
     * @param int   $toValue   end of slicing
     *
     * @return array
     */
    protected static function slice(array $data, $fromValue, $toValue)
    {
        if (!$fromValue) {
            $fromValue = 0;
        }
        if (!$toValue && $toValue !== 0) {
            $toValue = count($data);
        }
        return array_slice($data, $fromValue, $toValue-$fromValue);
    }
}
