<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\LinAlg\LinAlg;

use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg\Helper;

/**
 * Class HelperTest
 *
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if Helper::checkMatrix works with valid matrix
     */
    public function testCheckMatrixValid()
    {
        $numArray = NumPHP::ones(2, 3);
        Helper::checkMatrix($numArray);
    }

    /**
     * Tests if Helper::checkMatrix throws NoMatrixException, when argument is a
     * vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoMatrixException
     * @expectedExceptionMessage NumArray with dimension 1 given, NumArray should
     * have 2 dimensions
     */
    public function testCheckMatrixInvalid()
    {
        $numArray = NumPHP::ones(3);
        Helper::checkMatrix($numArray);
    }

    /**
     * Tests if Helper::checkVector works with valid vector
     */
    public function testCheckVectorValid()
    {
        $numArray = NumPHP::ones(3);
        Helper::checkVector($numArray);
    }

    /**
     * Tests if Helper::checkVector throws NoVectorException, when argument is a
     * matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoVectorException
     * @expectedExceptionMessage NumArray with dimension 2 given, NumArray should
     * have 1 dimension
     */
    public function testCheckVectorInvalid()
    {
        $numArray = NumPHP::ones(3, 2);
        Helper::checkVector($numArray);
    }

    /**
     * Tests if Helper::checkSquareMatrix works with valid square matrix
     */
    public function testCheckSquareMatrixValid()
    {
        $numArray = NumPHP::eye(3);
        Helper::checkSquareMatrix($numArray);
    }

    /**
     * Tests if Helper::checkSquareMatrix throws NoSquareMatrixException, when
     * argument is a vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoSquareMatrixException
     * @expectedExceptionMessage Matrix with shape (2, 3) given, matrix has to
     * be square
     */
    public function testCheckSquareMatrixInvalid()
    {
        $numArray = NumPHP::ones(2, 3);
        Helper::checkSquareMatrix($numArray);
    }

    /**
     * Tests if Helper::checkNotSingular works with valid not singular matrix
     */
    public function testCheckNotSingularMatrixValid()
    {
        $numArray = NumPHP::identity(4);
        Helper::checkNotSingularMatrix($numArray);
    }

    /**
     * Tests if SingularMatrixException will be thrown, when using
     * Helper::checkNotSingularMatrix with singular matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\SingularMatrixException
     * @expectedExceptionMessage Matrix is singular
     */
    public function testCheckNotSingularMatrixInvalid()
    {
        $numArray = NumPHP::identity(4);
        $numArray->set(0, 2, 2);
        Helper::checkNotSingularMatrix($numArray);
    }
}
