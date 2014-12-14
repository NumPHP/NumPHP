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
     * @return NumArray
     */
    public static function zeros()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args, 0));
    }

    /**
     * @param NumArray $numArray
     * @return NumArray
     */
    public static function zerosLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape(), 0));
    }

    /**
     * @return NumArray
     */
    public static function ones()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args, 1));
    }

    /**
     * @param NumArray $numArray
     * @return NumArray
     */
    public static function onesLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape(), 1));
    }

    /**
     * @return NumArray
     */
    public static function rand()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args));
    }

    /**
     * @param NumArray $numArray
     * @return NumArray
     */
    public static function randLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape()));
    }

    /**
     * @param $mAxis
     * @param int $nAxis
     * @return NumArray
     */
    public static function eye($mAxis, $nAxis = -1)
    {
        if ($nAxis === -1) {
            $nAxis = $mAxis;
        }
        $eye = self::zeros($mAxis, $nAxis);
        for ($i = 0; $i < min($mAxis, $nAxis); $i++) {
            $eye->set(1, $i, $i);
        }

        return $eye;
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
