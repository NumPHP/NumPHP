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
use NumPHP\LinAlg\Exception\NoSquareMatrixException;

/**
 * Class CholeskyDecomposition
 *
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.2
 */
abstract class CholeskyDecomposition
{
    const CACHE_KEY_CHOLESKY = 'cholesky';

    /**
     * Calculates lower triangular matrix L of given symmetric positive definite matrix
     *
     * @param NumArray $squareMatrix symmetric positive definite matrix
     *
     * @throws InvalidArgumentException will be thrown, when `$squareMatrix` is not symmetric positive definite
     * @throws NoSquareMatrixException  will be thrown, when `$squareMatrix` is not square
     *
     * @since     1.0.2
     *
     * @return NumArray
     */
    public static function cholesky(NumArray $squareMatrix)
    {
        if (!Helper::isSquareMatrix($squareMatrix)) {
            throw new NoSquareMatrixException(
                sprintf(
                    "Matrix with shape (%s) given, matrix has to be square",
                    implode(', ', $squareMatrix->getShape())
                )
            );
        }

        $shape = $squareMatrix->getShape();
        $size = $shape[0];
        $aMatrix = clone $squareMatrix;
        $lMatrix = NumPHP::zerosLike($aMatrix);

        for ($k = 0; $k < $size; $k++) {
            $diaElem = $aMatrix->get($k, $k)->getData();
            if ($diaElem <= 0) {
                throw new InvalidArgumentException("Matrix is not positive definite");
            }
            $diaElem = sqrt($diaElem);
            $lMatrix->set($k, $k, $diaElem);
            for ($i = $k+1; $i < $size; $i++) {
                if ($squareMatrix->get($i, $k) != $squareMatrix->get($k, $i)) {
                    throw new InvalidArgumentException("Matrix is not symmetric");
                }
                $lMatrix->set($i, $k, $aMatrix->get($i, $k)->getData()/$diaElem);
                for ($j = $k+1; $j <= $i; $j++) {
                    $aMatrix->set(
                        $i,
                        $j,
                        $aMatrix->get($i, $j)->sub($lMatrix->get($i, $k)->dot($lMatrix->get($j, $k)))
                    );
                }
            }
        }

        return $lMatrix;
    }
}
