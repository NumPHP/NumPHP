<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core;

use NumPHP\Core\NumPHP\Generate;

/**
 * Class NumPHP
 * @package NumPHP\Core
 */
class NumPHP
{
    /**
     * @param array $shape
     * @return NumPHP
     */
    public static function zeros(array $shape)
    {
        return new NumArray(Generate::generateArray($shape, 0));
    }

    /**
     * @param array $shape
     * @return NumArray
     */
    public static function ones(array $shape)
    {
        return new NumArray(Generate::generateArray($shape, 1));
    }

    /**
     * @param array $shape
     * @return NumArray
     */
    public static function random(array $shape)
    {
        return new NumArray(Generate::generateArray($shape));
    }
}
