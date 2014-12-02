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
 * Class Set
 * @package NumPHP\Core\NumArray
 */
class Set
{
    /**
     * @param $origData
     * @param $subData
     * @param array $args
     * @return mixed
     */
    public static function setSubArray($origData, $subData, array $args)
    {
        return self::setRecursive($origData, $subData, $args);
    }

    /**
     * @param $origData
     * @param $subData
     * @param $indexes
     * @return mixed
     */
    protected static function setRecursive($origData, $subData, $indexes)
    {
        if (count($indexes)) {
            $index = array_shift($indexes);
            $origData[$index] = self::setRecursive($origData[$index], $subData, $indexes);
            return $origData;
        }
        return $subData;
    }
}
