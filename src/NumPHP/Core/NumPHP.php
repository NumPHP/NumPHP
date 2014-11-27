<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\InvalidArgumentException;
use NumPHP\Core\NumPHP\Generate;

/**
 * Class NumPHP
 * @package NumPHP\Core
 */
abstract class NumPHP
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

    /**
     * @param $low
     * @param $high
     * @param int $step
     * @return NumArray
     */
    public static function arange($low, $high, $step = 1)
    {
        if ($step < 0) {
            throw new InvalidArgumentException('Step has to be a positiv value');
        }
        return new NumArray(range($low, $high, $step));
    }

    /**
     * @param $low
     * @param $high
     * @param $number
     * @return NumArray
     */
    public static function linspace($low, $high, $number)
    {
        if ($number < 0) {
            throw new InvalidArgumentException('Number has to be a positiv value');
        }
        $data = [];
        switch ($number) {
            case 0:
                break;
            case 1:
                $data = [$low];
                break;
            default:
                $step = ($high - $low) / ($number - 1);
                $sum = $low;
                for ($i = 0; $i < $number; $i++) {
                    $data[] = $sum;
                    $sum += $step;
                }
                break;
        }
        return new NumArray($data);
    }
}
