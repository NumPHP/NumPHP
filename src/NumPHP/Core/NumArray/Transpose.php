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
 * Class Transpose
 * @package NumPHP\Core\NumArray
 */
class Transpose
{
    const CACHE_KEY_TRANSPOSE = 'transpose';

    /**
     * @param $data
     * @param array $shape
     * @return array|mixed|\NumPHP\Core\NumArray
     */
    public static function getTranspose($data, array $shape)
    {
        return self::getTransposeRecursive($data, $shape);
    }

    /**
     * @param $data
     * @param $shape
     * @param array $indexes
     * @param null $currentIndex
     * @return array|mixed|\NumPHP\Core\NumArray
     */
    protected static function getTransposeRecursive($data, $shape, array $indexes = array(), $currentIndex = null)
    {
        if (!is_null($currentIndex)) {
            $indexes[] = $currentIndex;
        }
        if (count($shape)) {
            $transpose = [];
            $axis = array_pop($shape);
            for ($i = 0; $i < $axis; $i++) {
                $transpose[] = self::getTransposeRecursive($data, $shape, $indexes, $i);
            }
            return $transpose;
        }
        return Get::getSubArray($data, array_reverse($indexes));
    }
}
