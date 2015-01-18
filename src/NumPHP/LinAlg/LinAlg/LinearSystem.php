<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\Exception\InvalidArgumentException;
use NumPHP\LinAlg\Exception\SingularMatrixException;
use NumPHP\LinAlg\LinAlg;

/**
 * Class LinearSystem
 *
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class LinearSystem
{
    /**
     * Solves a linear system
     *
     * @param NumArray $squareMatrix matrix of size n*n
     * @param NumArray $numArray     vector of size n or matrix of size n*m
     *
     * @throws \NumPHP\LinAlg\Exception\SingularMatrixException will be thrown, if
     * `$squareMatrix` is singular
     * @throws \NumPHP\LinAlg\Exception\InvalidArgumentException will be thrown, if
     * linear system of `$squareMatrix` and `$numArray` can not be solved
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    public static function solve(NumArray $squareMatrix, NumArray $numArray)
    {
        if (!Helper::isNotSingularMatrix($squareMatrix)) {
            throw new SingularMatrixException(sprintf("First Argument has to be a not singular square matrix"));
        }
        if (!Helper::isVector($numArray) && !Helper::isMatrix($numArray)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Second argument has to be a vector or a matrix, NumArray with dimension %d given",
                    $numArray->getNDim()
                )
            );
        }
        $shape1 = $squareMatrix->getShape();
        $shape2 = $numArray->getShape();
        if ($shape1[0] !== $shape2[0]) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can not solve a linear system with matrix (%s) and matrix (%s)",
                    implode(', ', $shape1),
                    implode(', ', $shape2)
                )
            );
        }

        /**
         * The result of LinAlg::lud is a array with three NumArrays
         *
         * @var NumArray $pMatrix
         * @var NumArray $lMatrix
         * @var NumArray $uMatrix
         */
        list($pMatrix, $lMatrix, $uMatrix) = LinAlg::lud($squareMatrix);

        $yNumArray = self::forwardSubstitution($lMatrix, $pMatrix->getTranspose()->dot($numArray));
        $zNumArray = self::backSubstitution($uMatrix, $yNumArray);

        return $zNumArray;
    }

    /**
     * Forward Substitution solves a linear system with a lower triangular matrix of
     * size n*n and a vector of size n or matrix of size n*m
     *
     * @param NumArray $lMatrix   lower triangular matrix of size n*n
     * @param NumArray $numArray  vector of size n or matrix of size n*m
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    protected static function forwardSubstitution(NumArray $lMatrix, NumArray $numArray)
    {
        $shape = $numArray->getShape();
        if (Helper::isVector($numArray)) {
            $xVector = NumPHP::zerosLike($numArray);

            for ($i = 0; $i < $shape[0]; $i++) {
                $slice = sprintf('0:%d', $i);
                $sum = $lMatrix->get($i, $slice)->dot($xVector->get($slice));
                $xVector->set(
                    $i,
                    $numArray->get($i)->sub($sum)->div($lMatrix->get($i, $i))
                );
            }

            return $xVector;
        }
        // $numArray is a matrix
        $copy = clone $numArray;

        for ($i = 0; $i < $shape[1]; $i++) {
            $copy->set(':', $i, self::forwardSubstitution($lMatrix, $copy->get(':', $i)));
        }

        return $copy;
    }

    /**
     * Back Substitution solves a linear system with a upper triangular matrix of
     * size n*n and a vector of size n or a matrix of size n*m
     *
     * @param NumArray $uMatrix   upper triangular matrix of size n*n
     * @param NumArray $numArray  vector of size n or matrix of size n*m
     *
     * @return NumArray
     *
     * @since 1.0.0
     */
    protected static function backSubstitution(NumArray $uMatrix, NumArray $numArray)
    {
        $shape = $numArray->getShape();
        if (Helper::isVector($numArray)) {
            $xVector = NumPHP::zerosLike($numArray);

            for ($i = $shape[0]-1; $i >= 0; $i--) {
                $slice = sprintf("%d:%d", $i+1, $shape[0]);
                $sum = $uMatrix->get($i, $slice)->dot($xVector->get($slice));
                $xVector->set(
                    $i,
                    $numArray->get($i)->sub($sum)->div($uMatrix->get($i, $i))
                );
            }

            return $xVector;
        }
        // $numArray is a matrix
        $copy = clone $numArray;

        for ($i = 0; $i < $shape[1]; $i++) {
            $copy->set(':', $i, self::backSubstitution($uMatrix, $copy->get(':', $i)));
        }

        return $copy;
    }
}
