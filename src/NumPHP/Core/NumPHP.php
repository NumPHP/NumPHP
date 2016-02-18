<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\InvalidArgumentException;
use NumPHP\Core\NumPHP\Generate;

/**
 * Class NumPHP
 *
 * @package   NumPHP\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @api
 * @since     1.0.0
 */
abstract class NumPHP
{
    const VERSION = '1.1.0';

    /**
     * Returns a NumArray filled with `0`
     *
     * @param int $axis,... given axis
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function zeros()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args, 0));
    }

    /**
     * Returns a NumArray with the same size, but filled with `0`
     *
     * @param NumArray $numArray given NumArray
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function zerosLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape(), 0));
    }

    /**
     * Returns a NumArray filled with `1`
     *
     * @param int $axis,... given axis
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function ones()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args, 1));
    }

    /**
     * Returns a NumArray with the same size, but filled with `1`
     *
     * @param NumArray $numArray given NumArray
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function onesLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape(), 1));
    }

    /**
     * Returns a NumArray filled with random values
     *
     * @param int $axis,... given axis
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function rand()
    {
        $args = func_get_args();
        return new NumArray(Generate::generateArray($args));
    }

    /**
     * Returns a NumArray with the same size, but filled with random values
     *
     * @param NumArray $numArray given NumArray
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function randLike(NumArray $numArray)
    {
        return new NumArray(Generate::generateArray($numArray->getShape()));
    }

    /**
     * Returns a matrix (NumArray) filled with `0` and `1` on the main diagonal
     *
     * @param int $mAxis size of the m axis
     * @param int $nAxis size of the n axis, if not given `$nAxis` = `$mAxis`
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function eye($mAxis, $nAxis = -1)
    {
        $mAxis = (int) $mAxis;
        $nAxis = (int) $nAxis;
        if ($nAxis < 0) {
            $nAxis = $mAxis;
        }
        $eye = self::zeros($mAxis, $nAxis);
        $min = min($mAxis, $nAxis);
        for ($i = 0; $i < $min; $i++) {
            $eye->set($i, $i, 1);
        }

        return $eye;
    }

    /**
     * Returns a identity matrix (NumArray) filled with `0` and `1` on the main
     * diagonal
     *
     * @param int $mAxis size of the m axis and n axis
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public static function identity($mAxis)
    {
        return self::eye($mAxis, $mAxis);
    }

    /**
     * Creates a vector (NumArray) from `$low` to `$high` with `$step` steps
     *
     * @param float $low  beginning of the vector
     * @param float $high end of the vector
     * @param float $step steps, if not given `$step` = `1.0`
     *
     * @return NumArray
     *
     * @throws InvalidArgumentException will be thrown if `$step` is negative
     *
     * @api
     * @since 1.0.0
     */
    public static function arange($low, $high, $step = 1.0)
    {
        if ($step < 0) {
            throw new InvalidArgumentException('Step has to be a positive value');
        }
        return new NumArray(range($low, $high, $step));
    }

    /**
     * Creates a vector (NumArray) from `$low` to `$high` with the size of `$number`
     *
     * @param float $low    beginning of the vector
     * @param float $high   end of the vector
     * @param int   $number size of the vector
     *
     * @return NumArray
     *
     * @throws InvalidArgumentException will be thrown if `$number` is negative
     *
     * @api
     * @since 1.0.0
     */
    public static function linspace($low, $high, $number)
    {
        if ($number < 0) {
            throw new InvalidArgumentException('Number has to be a positive value');
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
