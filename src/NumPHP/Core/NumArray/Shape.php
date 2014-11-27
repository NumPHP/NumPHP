<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
     * @param $data
     * @return array
     */
    public static function getShape($data)
    {
        $shape = [];
        return self::getShapeRecursive($data, $shape);
    }

    /**
     * @param array $data
     * @param $shape
     * @param $newShape
     * @return array
     */
    public static function reshape(array $data, $shape, $newShape)
    {
        $oldSize = Helper::multiply($shape);
        $newSize = Helper::multiply($newShape);
        if ($newSize !== $oldSize) {
            throw new InvalidArgumentException('Total size of new array must be unchanged');
        }
        return $data;
    }

    /**
     * @param $data
     * @param $shape
     * @param int $level
     * @return array
     */
    protected static function getShapeRecursive($data, $shape, $level = 0)
    {
        if (is_array($data)) {
            $count = count($data);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException('Dimensions did not match');
            } else {
                $shape[$level] = $count;
            }
            foreach ($data as $row) {
                $shape = self::getShapeRecursive($row, $shape, $level+1);
            }
        }
        return $shape;
    }
}
