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
 * Class Generate
 * @package NumPHP\Core\NumPHP
 */
class Generate
{
    /**
     * @param array $shape
     * @param null $value
     * @return mixed
     */
    public static function generateArray(array $shape, $value = null)
    {
        return self::generateArrayRecursive($shape, $value);
    }

    /**
     * @param array $shape
     * @param null $value
     * @return array|int|null
     */
    protected static function generateArrayRecursive(array $shape, $value = null)
    {
        if (count($shape)) {
            $zeros = [];
            $dim = array_shift($shape);
            for ($i = 0; $i < $dim; $i++) {
                $zeros[] = self::generateArrayRecursive($shape, $value);
            }
            return $zeros;
        }
        if (is_null($value)) {
            return mt_rand() + mt_rand() / mt_getrandmax();
        }
        return $value;
    }
}
