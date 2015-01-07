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
 * Class Map
  * @package NumPHP\Core\NumArray
  */
class Map
{
    /**
     * @param $array1
     * @param $array2
     * @param callback $callback
     * @return array|mixed
     */
    public static function mapArray($array1, $array2, $callback)
    {
        return self::mapRecursive($array1, $array2, $callback);
    }

    /**
     * @param $data1
     * @param $data2
     * @param callback $callback
     * @return array|mixed
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected static function mapRecursive($data1, $data2, $callback)
    {
        if (is_array($data1)) {
            $size1 = count($data1);
            if (is_array($data2)) {
                if (count($data1) !== count($data2)) {
                    throw new InvalidArgumentException('Shape '.count($data1).' is different from '.count($data2));
                }
                for ($i = 0; $i < $size1; $i++) {
                    $data1[$i] = self::mapRecursive($data1[$i], $data2[$i], $callback);
                }
            } else {
                for ($i = 0; $i < $size1; $i++) {
                    $data1[$i] = self::mapRecursive($data1[$i], $data2, $callback);
                }
            }
        } else {
            if (is_array($data2)) {
                $size2 = count($data2);
                for ($i = 0; $i < $size2; $i++) {
                    $data2[$i] = self::mapRecursive($data1, $data2[$i], $callback);
                }

                return $data2;
            }
            $data1 = $callback($data1, $data2);
        }

        return $data1;
    }
}
