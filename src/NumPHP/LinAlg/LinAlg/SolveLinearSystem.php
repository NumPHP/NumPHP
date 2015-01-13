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
use NumPHP\LinAlg\LinAlg;

/**
 * Class SolveLinearSystem
 *
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
abstract class SolveLinearSystem
{
    /**
     * Solves a linear system
     *
     * @param NumArray $squareMatrix matrix of size n*n
     * @param NumArray $vector       vector of size n
     *
     * @return NumArray
     * @throws \NumPHP\LinAlg\Exception\NoMatrixException will be thrown, if
     * `$squareMatrix` is not a matrix
     * @throws \NumPHP\LinAlg\Exception\NoSquareMatrixException will be thrown, if
     * `$squareMatrix` is not square
     * @throws \NumPHP\LinAlg\Exception\SingularMatrixException will be thrown, if
     * `$squareMatrix` is singular
     * @throws \NumPHP\LinAlg\Exception\NoVectorException will be thrown, if
     * `$vector` is no vector
     * @throws \NumPHP\LinAlg\Exception\InvalidArgumentException will be thrown, if
     * linear system of `$squareMatrix` and `$vector` can not be solved
     */
    public static function solve(NumArray $squareMatrix, NumArray $vector)
    {
        Helper::checkNotSingularMatrix($squareMatrix);
        $matrixShape = $squareMatrix->getShape();
        $vectorShape = $vector->getShape();
        if ($matrixShape[0] !== $vectorShape[0]) {
            throw new InvalidArgumentException(
                sprintf(
                    "Can not solve a linear system with matrix (%s) and vector ".
                    "(%s)",
                    implode(', ', $matrixShape),
                    implode(', ', $vectorShape)
                )
            );
        }

        $lud = LinAlg::lud($squareMatrix);
        /**
         * The result of LinAlg::lud is a array with three NumArrays
         *
         * @var NumArray $pMatrix
         * @var NumArray $lMatrix
         * @var NumArray $uMatrix
         */
        $pMatrix = clone $lud['P'];
        $lMatrix = clone $lud['L'];
        $uMatrix = clone $lud['U'];

        $pMatrix->dot($vector);
        $yVector = self::forwardSubstitution($lMatrix, $pMatrix);
        $zVector = self::backSubstitution($uMatrix, $yVector);

        return $zVector;
    }

    /**
     * Forward Substitution solves a linear system with a lower triangular matrix of
     * size n*n and a vector of size n
     *
     * @param NumArray $lMatrix lower triangular matrix of size n*n
     * @param NumArray $vector  vector of size n
     *
     * @return NumArray
     */
    protected static function forwardSubstitution(
        NumArray $lMatrix,
        NumArray $vector
    ) {
        $vectorShape = $vector->getShape();
        $xVector = NumPHP::zerosLike($vector);

        for ($i = 0; $i < $vectorShape[0]; $i++) {
            $sum = new NumArray(0);
            for ($j = 0; $j < $i; $j++) {
                $sum->add($lMatrix->get($i, $j)->dot($xVector->get($j)));
            }
            $xVector->set(
                $vector->get($i)->sub($sum)->getData()/
                $lMatrix->get($i, $i)->getData(),
                $i
            );
        }

        return $xVector;
    }

    /**
     * Back Substitution solves a linear system with a upper triangular matrix of
     * size n*n and a vector of size n
     *
     * @param NumArray $uMatrix upper triangular matrix of size n*n
     * @param NumArray $vector  vector of size n
     *
     * @return NumArray
     */
    protected static function backSubstitution(NumArray $uMatrix, NumArray $vector)
    {
        $vectorShape = $vector->getShape();
        $xVector = NumPHP::zerosLike($vector);

        for ($i = $vectorShape[0]-1; $i >= 0; $i--) {
            $sum = new NumArray(0);
            for ($j = $i+1; $j < $vectorShape[0]; $j++) {
                $sum->add($uMatrix->get($i, $j)->dot($xVector->get($j)));
            }
            $xVector->set(
                $vector->get($i)->sub($sum)->getData()/
                $uMatrix->get($i, $i)->getData(),
                $i
            );
        }

        return $xVector;
    }
}
