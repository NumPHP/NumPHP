<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
     * @param $data
     * @param array $args
     * @return mixed|NumArray
     */
    public static function getSubArray($data, array $args)
    {
        $data = self::getRecursive($data, $args);

        if (is_array($data)) {
            return new NumArray($data);
        }
        return $data;
    }

    /**
     * @param $data
     * @param array $args
     * @return mixed
     */
    protected static function getRecursive($data, array $args)
    {
        if (isset($args[0])) {
            $arg = $args[0];
            $matches = [];
            array_shift($args);
            if (preg_match('/^(?P<from>([-]{0,1}\d+)*):(?P<to>([-]{0,1}\d+)*)$/', $arg, $matches)) {
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
     * @param $data
     * @param $fromValue
     * @param $toValue
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
