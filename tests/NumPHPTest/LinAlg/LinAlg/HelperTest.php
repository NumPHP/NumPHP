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
     * Tests if Helper::isMatrix works with valid matrix
     */
    public function testCheckMatrixValid()
    {
        $numArray = NumPHP::ones(2, 3);
        $this->assertTrue(Helper::isMatrix($numArray));
    }

    /**
     * Tests if Helper::isMatrix works with invalid matrix
     */
    public function testCheckMatrixInvalid()
    {
        $numArray = NumPHP::ones(3);
        $this->assertFalse(Helper::isMatrix($numArray));
    }

    /**
     * Tests if Helper::isVector works with valid vector
     */
    public function testCheckVectorValid()
    {
        $numArray = NumPHP::ones(3);
        $this->assertTrue(Helper::isVector($numArray));
    }

    /**
     * Tests if Helper::isVector works with invalid vector
     */
    public function testCheckVectorInvalid()
    {
        $numArray = NumPHP::ones(3, 2);
        $this->assertFalse(Helper::isVector($numArray));
    }

    /**
     * Tests if Helper::isSquareMatrix works with valid square matrix
     */
    public function testCheckSquareMatrixValid()
    {
        $numArray = NumPHP::eye(3);
        $this->assertTrue(Helper::isSquareMatrix($numArray));
    }

    /**
     * Tests if Helper::isSquareMatrix works with invalid square matrix
     */
    public function testCheckSquareMatrixInvalid()
    {
        $numArray = NumPHP::ones(2, 3);
        $this->assertFalse(Helper::isSquareMatrix($numArray));
    }

    /**
     * Tests if Helper::isNotSingularMatrix works with valid not singular matrix
     */
    public function testCheckNotSingularMatrixValid()
    {
        $numArray = NumPHP::identity(4);
        $this->assertTrue(Helper::isNotSingularMatrix($numArray));
    }

    /**
     * Tests if Helper::isNotSingularMatrix works with invalid not singular matrix
     */
    public function testCheckNotSingularMatrixInvalid()
    {
        $numArray = NumPHP::identity(4);
        $numArray->set(2, 2, 0);
        $this->assertFalse(Helper::isNotSingularMatrix($numArray));
    }
}
