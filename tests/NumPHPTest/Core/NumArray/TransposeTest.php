<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class TransposeTest
 * @package NumPHPTest\Core\NumArray
 */
class TransposeTest extends \PHPUnit_Framework_TestCase
{
    public function testTranspose()
    {
        $numArray = new NumArray(1);
        $this->assertEquals($numArray, $numArray->getTranspose());
    }

    public function testTranspose3()
    {
        $numArray = NumPHP::arange(1, 3);
        $this->assertEquals($numArray, $numArray->getTranspose());
    }

    public function testTranspose2x3()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $expectedNumArray = new NumArray(
            [
                [1, 4],
                [2, 5],
                [3, 6],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray->getTranspose());
    }

    public function testTranspose2x3x4()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);
        $expectedNumArray = new NumArray(
            [
                [
                    [1, 13],
                    [5, 17],
                    [9, 21],
                ],
                [
                    [2, 14],
                    [6, 18],
                    [10,22],
                ],
                [
                    [3, 15],
                    [7, 19],
                    [11, 23],
                ],
                [
                    [4, 16],
                    [8, 20],
                    [12, 24],
                ]
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray->getTranspose());
    }
}
