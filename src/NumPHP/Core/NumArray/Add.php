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
 * Class Add
  * @package NumPHP\Core\NumArray
  */
class Add
{
    const OPERATION_PLUS = 'plus';
    const OPERATION_MINUS = 'minus';

    /**
     * @param $addend1
     * @param $addend2
     * @param string $operation
     * @return array|mixed
     */
    public static function addArray($addend1, $addend2, $operation = self::OPERATION_PLUS)
    {
        return self::addRecursive($addend1, $addend2, $operation);
    }

    /**
     * @param $data1
     * @param $data2
     * @param $operation
     * @return array|mixed
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected static function addRecursive($data1, $data2, $operation)
    {
        if (is_array($data1)) {
            if (is_array($data2)) {
                if (count($data1) !== count($data2)) {
                    throw new InvalidArgumentException('Shape '.count($data1).' is different from '.count($data2));
                }
                for ($i = 0; $i < count($data1); $i++) {
                    $data1[$i] = self::addRecursive($data1[$i], $data2[$i], $operation);
                }
            } else {
                for ($i = 0; $i < count($data1); $i++) {
                    $data1[$i] = self::addRecursive($data1[$i], $data2, $operation);
                }
            }
        } else {
            if (is_array($data2)) {
                for ($i = 0; $i < count($data2); $i++) {
                    $data2[$i] = self::addRecursive($data1, $data2[$i], $operation);
                }

                return $data2;
            }
            if ($operation === self::OPERATION_PLUS) {
                $data1 += $data2;
            } elseif ($operation === self::OPERATION_MINUS) {
                $data1 -= $data2;
            } else {
                throw new InvalidArgumentException('Operation '.$operation.' is not allowed');
            }
        }

        return $data1;
    }
}
