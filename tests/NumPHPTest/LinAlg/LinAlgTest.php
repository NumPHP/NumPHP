<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;

/**
 * Class LinAlgTest
 *
 * @package   NumPHPTest\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class LinAlgTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Compares the version in README.md with LinAlg::VERSION
     */
    public function testREADMEVersion()
    {
        $readmeContent = file_get_contents(realpath(__DIR__.'/../../../README.md'));
        $this->assertNotFalse(
            strpos($readmeContent, '*NumPHP '.LinAlg::VERSION.'*'),
            'Version in README.md is not updated'
        );
    }

    /**
     * Tests LinAlg::det with 3x3 matrix
     */
    public function testDet3x3()
    {
        $numArray = new NumArray(
            [
                [1, 6, 1],
                [2, 3, 2],
                [4, 2, 1],
            ]
        );

        $this->assertSame(27.0, LinAlg::det($numArray));
    }

    /**
     * Tests LinAlg::det with 4x4 matrix
     */
    public function testDet4x4()
    {
        $array = [
            [1,  2,  3,  4],
            [5,  6,  7,  8],
            [9, 10, 11, 12],
            [5,  6,  7,  8],
        ];

        $this->assertSame(0.0, LinAlg::det($array));
    }

    /**
     * Tests if NoSquareMatrixException will be thrown, when using LinAlg::det with
     * 2x3 matrix
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoSquareMatrixException
     * @expectedExceptionMessage Matrix with shape (2, 3) given, matrix has to
     * be square
     */
    public function testDet2x3()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        LinAlg::det($numArray);
    }
}
