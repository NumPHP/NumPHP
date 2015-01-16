<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;

/**
 * Class Helper
 *
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class Helper
{
    /**
     * Tests if a NumArray is a matrix
     *
     * @param NumArray $numArray given NumArray
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function isMatrix(NumArray $numArray)
    {
        return $numArray->getNDim() === 2;
    }

    /**
     * Tests if a NumArray is a vector
     *
     * @param NumArray $numArray given NumArray
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function isVector(NumArray $numArray)
    {
        return $numArray->getNDim() === 1;
    }

    /**
     * Tests if a NumArray is a square matrix
     *
     * @param NumArray $numArray given NumArray
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function isSquareMatrix(NumArray $numArray)
    {
        $shape = $numArray->getShape();
        return self::isMatrix($numArray) && $shape[0] === $shape[1];
    }

    /**
     * Tests if a matrix is not singular
     *
     * @param NumArray $numArray given NumArray
     *
     * @todo better use matrix_rank to check if a matrix is singular
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function isNotSingularMatrix(NumArray $numArray)
    {
        return self::isSquareMatrix($numArray) && LinAlg::det($numArray) != 0;
    }
}
