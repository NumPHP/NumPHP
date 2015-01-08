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
 * Class Set
 *
 * @category Core
 * @package  NumPHP\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class Set
{
    /**
     * Replaces a value or sub array at the given position
     *
     * @param mixed $origData given data
     * @param mixed $subData  replacing data
     * @param array $args     array of indices
     *
     * @return mixed
     */
    public static function setSubArray($origData, $subData, array $args)
    {
        return self::setRecursive($origData, $subData, $args);
    }

    /**
     * Replaces a value or sub array at the given position recursive
     *
     * @param mixed $origData given data
     * @param mixed $subData  replacing data
     * @param array $indexes  array of indices
     *
     * @return mixed
     */
    protected static function setRecursive($origData, $subData, array $indexes)
    {
        if (count($indexes)) {
            $index = array_shift($indexes);
            $origData[$index] = self::setRecursive(
                $origData[$index],
                $subData,
                $indexes
            );
            return $origData;
        }
        return $subData;
    }
}
