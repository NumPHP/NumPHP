<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\LinAlg\LinAlgTest;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;

/**
 * Class LinAlgTest
  * @package NumPHPTest\LinAlg\LinAlgTest
  */
class LinAlgTest extends \PHPUnit_Framework_TestCase
{
    public function testREADMEVersion()
    {
        $readmeContent = file_get_contents(realpath(__DIR__.'/../../../README.md'));
        $this->assertNotFalse(
            strpos($readmeContent, '*NumPHP '.LinAlg::VERSION.'*'),
            'Version in README.md is not updated'
        );
    }

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
     * @expectedException \NumPHP\LinAlg\Exception\NoSquareMatrixException
     * @expectedExceptionMessage NumArray with shape (2, 3) given, NumArray has to be square
     */
    public function testDet2x3()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        LinAlg::det($numArray);
    }

    /**
     * @expectedException \NumPHP\LinAlg\Exception\NoMatrixException
     * @expectedExceptionMessage NumArray with dimension 3 given, NumArray should have 2 dimensions
     */
    public function testDet2x2x2()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 2, 2);

        LinAlg::det($numArray);
    }
}
