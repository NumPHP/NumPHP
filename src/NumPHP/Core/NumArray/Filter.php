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
 * Class Filter
  * @package NumPHP\Core\NumArray
  */
class Filter
{
    /**
     * @param $data
     * @param callback $callback
     * @return mixed
     */
    public static function filterArray($data, $callback)
    {
        return self::filterRecursive($data, $callback);
    }

    /**
     * @param $data
     * @param callback $callback
     * @return mixed
     */
    protected static function filterRecursive($data, $callback)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::filterRecursive($value, $callback);
            }

            return $data;
        }

        return $callback($data);
    }
}
