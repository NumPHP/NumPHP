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
use NumPHP\LinAlg\Exception\NoMatrixException;
use NumPHP\LinAlg\Exception\NoSquareMatrixException;
use NumPHP\LinAlg\Exception\NoVectorException;

/**
 * Class Helper
 *
 * @category LinAlg
 * @package  NumPHP\LinAlg\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
abstract class Helper
{
    /**
     * Tests if a NumArray is a matrix
     *
     * @param NumArray $numArray given NumArray
     *
     * @return void
     * @throws NoMatrixException
     */
    public static function checkMatrix(NumArray $numArray)
    {
        if ($numArray->getNDim() !== 2) {
            throw new NoMatrixException(
                sprintf(
                    "NumArray with dimension %d given, NumArray should have 2 ".
                    "dimensions",
                    $numArray->getNDim()
                )
            );
        }
    }

    /**
     * Tests if a NumArray is a vector
     *
     * @param NumArray $numArray given NumArray
     *
     * @return void
     * @throws NoVectorException
     */
    public static function checkVector(NumArray $numArray)
    {
        if ($numArray->getNDim() !== 1) {
            throw new NoVectorException(
                sprintf(
                    "NumArray with dimension %d given, NumArray should have 1 ".
                    "dimension",
                    $numArray->getNDim()
                )
            );
        }
    }

    /**
     * Tests if a NumArray is a square matrix
     *
     * @param NumArray $numArray given NumArray
     *
     * @return void
     * @throws NoMatrixException
     * @throws NoSquareMatrixException
     */
    public static function checkSquareMatrix(NumArray $numArray)
    {
        self::checkMatrix($numArray);
        $shape = $numArray->getShape();
        if ($shape[0] !== $shape[1]) {
            throw new NoSquareMatrixException(
                sprintf(
                    "NumArray with shape (%s) given, NumArray has to be square",
                    implode(', ', $shape)
                )
            );
        }
    }
}
