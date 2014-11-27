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
 * Class Helper
 * @package NumPHP\Core\NumArray
 */
abstract class Helper
{
    /**
     * @param array $array
     * @return int
     */
    public static function multiply(array $array)
    {
        return array_reduce(
            $array,
            function ($prod, $item) {
                if (!is_numeric($item)) {
                    throw new InvalidArgumentException('Array contains non numeric values');
                }
                return $prod * $item;
            },
            1
        );
    }
}
