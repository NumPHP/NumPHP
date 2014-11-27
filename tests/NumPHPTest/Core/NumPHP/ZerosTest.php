<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumPHP;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class ZerosTest
 * @package NumPHPTest\Core\NumPHP
 */
class ZerosTest extends \PHPUnit_Framework_TestCase
{
    public function testZeros()
    {
        $this->assertEquals(new NumArray(0), NumPHP::zeros([]));
    }

    public function testZeros3()
    {
        $this->assertEquals(new NumArray([0, 0, 0]), NumPHP::zeros([3]));
    }

    public function testZeros3x2()
    {
        $expectedNumArray = new NumArray(
            [
                [0, 0],
                [0, 0],
                [0, 0],
            ]
        );
        $this->assertEquals($expectedNumArray, NumPHP::zeros([3, 2]));
    }

    public function testZeros2x3x5()
    {
        $expectedNumArray = new NumArray(
            [
                [
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                ],
                [
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                ],
            ]
        );
        $this->assertEquals($expectedNumArray, NumPHP::zeros([2, 3, 5]));
    }
}
