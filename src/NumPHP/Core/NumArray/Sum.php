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
 * Class Sum
  * @package NumPHP\Core\NumArray
  */
class Sum
{
    /**
     * @param $data
     * @param int $axis
     * @return mixed
     */
    public static function sumArray($data, $axis = null)
    {
        return self::sumRecursive($data, $axis);
    }

    /**
     * @param $data
     * @param int $axis
     * @return mixed
     */
    protected static function sumRecursive($data, $axis = null)
    {
        if (is_array($data)) {
            if (!is_null($axis) && $axis > 0) {
                foreach ($data as $key => $value) {
                    $data[$key] = self::sumRecursive($value, $axis -1);
                }

                return $data;
            }
            $sum = array_shift($data);
            foreach ($data as $value) {
                $sum = Add::addArray($sum, $value);
            }

            if ($axis === 0) {
                return $sum;
            }

            return self::sumRecursive($sum);
        }

        return $data;
    }
}
