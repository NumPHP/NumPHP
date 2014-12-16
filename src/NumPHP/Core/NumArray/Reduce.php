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
use NumPHP\Core\NumArray;

/**
 * Class Reduce
  * @package NumPHP\Core\NumArray
  */
class Reduce
{
    /**
     * @param NumArray $numArray
     * @param $callback
     * @param $axis
     * @return NumArray
     */
    public static function reduceArray(NumArray $numArray, $callback, $axis)
    {
        if ($axis && $axis >= $numArray->getNDim()) {
            throw new InvalidArgumentException('Axis '.$axis.' out of bounds');
        }

        return new NumArray(
            self::reduceRecursive($numArray->getData(), $callback, $axis)
        );
    }

    /**
     * @param $data
     * @param callback $callback
     * @param int $axis
     * @return mixed
     */
    protected static function reduceRecursive($data, $callback, $axis = null)
    {
        if (is_array($data)) {
            if (!is_null($axis) && $axis > 0) {
                foreach ($data as $key => $value) {
                    $data[$key] = self::reduceRecursive($value, $callback, $axis -1);
                }

                return $data;
            }
            $sum = array_shift($data);
            foreach ($data as $value) {
                $sum = Map::mapArray($sum, $value, $callback);
            }

            if ($axis === 0) {
                return $sum;
            }

            return self::reduceRecursive($sum, $callback);
        }

        return $data;
    }
}
