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
 * Class Filter
 *
 * @category Core
 * @package  NumPHP\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class Filter
{
    /**
     * Applies `$callback` on every element in `$data`
     *
     * @param mixed    $data     given data
     * @param callback $callback callback function
     *
     * @return mixed
     */
    public static function filterArray($data, $callback)
    {
        return self::filterRecursive($data, $callback);
    }

    /**
     * Applies `$callback` on every element in `$data` recursive
     *
     * @param mixed    $data     given data
     * @param callback $callback callback fucntion
     *
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
