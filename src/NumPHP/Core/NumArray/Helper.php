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

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class Helper
 *
 * @category Core
 * @package  NumPHP\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class Helper
{
    /**
     * Multiplies all entries of an array
     *
     * @param array $array given array of floats or integers
     *
     * @return float
     * @throws InvalidArgumentException will be thrown, if a value in the array is
     * not numeric
     */
    public static function multiply(array $array)
    {
        return array_reduce(
            $array,
            function ($prod, $item) {
                if (!is_numeric($item)) {
                    throw new InvalidArgumentException(
                        'Array contains non numeric values'
                    );
                }
                return $prod * $item;
            },
            1
        );
    }
}
