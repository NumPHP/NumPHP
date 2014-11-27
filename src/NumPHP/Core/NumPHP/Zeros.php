<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core\NumPHP;

/**
 * Class Zeros
 * @package NumPHP\Core\NumPHP
 */
class Zeros
{
    /**
     * @param $shape
     * @return array|int
     */
    public static function getZeros(array $shape)
    {
        return self::getZeroArrayRecursive($shape);
    }

    /**
     * @param array $shape
     * @return array|int
     */
    protected static function getZeroArrayRecursive(array $shape)
    {
        if (count($shape)) {
            $zeros = [];
            $dim = array_shift($shape);
            for ($i = 0; $i < $dim; $i++) {
                $zeros[] = self::getZeroArrayRecursive($shape);
            }
            return $zeros;
        }
        return 0;
    }
}
