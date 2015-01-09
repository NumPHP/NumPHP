<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  LinAlg
 * @package   NumPHP\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\Exception\InvalidArgumentException;

/**
 * Class SolveLinearSystem
 *
 * @category LinAlg
 * @package  NumPHP\LinAlg\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
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

        return new NumArray($squareMatrix->dot($vector)->getData());
    }
}
