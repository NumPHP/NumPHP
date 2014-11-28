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
     * @param array $shape
     * @param array $newShape
     * @return array
     */
    public static function reshape(array $data, array $shape, array $newShape)
    {
        $oldSize = Helper::multiply($shape);
        $newSize = Helper::multiply($newShape);
        if ($newSize !== $oldSize) {
            throw new InvalidArgumentException('Total size of new array must be unchanged');
        }
        return self::reshapeRecursive(
            self::reshapeToVectorRecursive($data),
            $newShape
        );
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

    /**
     * @param array $data
     * @return array
     */
    protected function reshapeToVectorRecursive(array $data)
    {
        $vector = [];
        foreach ($data as $row) {
            if (is_array($row)) {
                $vector = array_merge($vector, self::reshapeToVectorRecursive($row));
            } else {
                return $data;
            }
        }
        return $vector;
    }

    /**
     * @param array $data
     * @param $shape
     * @return array
     */
    protected function reshapeRecursive(array $data, $shape)
    {
        if (count($shape) > 1) {
            $reshaped = [];
            $axis = array_shift($shape);
            $length = count($data) / $axis;
            for ($i = 0; $i < $axis; $i++) {
                $reshaped[] = self::reshapeRecursive(array_slice($data, $i*$length, $length), $shape);
            }
            return $reshaped;
        }
        return $data;
    }
}
