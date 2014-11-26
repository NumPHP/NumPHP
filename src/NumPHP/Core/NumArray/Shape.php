<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/26/14
 * Time: 7:36 AM
 */

namespace NumPHP\Core\NumArray;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Shape
 * @package NumPHP\Core\NumArray
 */
class Shape
{
    /**
     * @param $array
     * @return array
     */
    public static function getShape($array)
    {
        $shape = [];
        return self::getShapeRecursive($array, $shape);
    }

    /**
     * @param $array
     * @param $shape
     * @param int $level
     * @return array
     */
    protected static function getShapeRecursive($array, $shape, $level = 0)
    {
        if (is_array($array)) {
            $count = count($array);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException('Dimensions did not match');
            } else {
                $shape[$level] = $count;
            }
            foreach ($array as $row) {
                $shape = self::getShapeRecursive($row, $shape, $level+1);
            }
        }
        return $shape;
    }
}
