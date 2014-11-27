<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class NumPHPTest
 */
class NumPHPTest extends \PHPUnit_Framework_TestCase
{
    public function testArangeIntWithoutStep()
    {
        $expectedNumArray = new NumArray(
            [3, 4, 5, 6, 7]
        );
        $this->assertEquals($expectedNumArray, NumPHP::arange(3, 7));
    }

    public function testArangeFloatWithoutStep()
    {
        $expectedNumArray = new NumArray(
            [3.45, 4.45, 5.45, 6.45]
        );
        $this->assertEquals($expectedNumArray, NumPHP::arange(3.45, 7));

        $expectedNumArray = new NumArray(
            [3.45, 4.45, 5.45, 6.45, 7.45]
        );
        $this->assertEquals($expectedNumArray, NumPHP::arange(3.45, 7.45));
    }

    public function testArangeIntWithStep()
    {
        $expectedNumArray = new NumArray(
            [3, 5, 7]
        );
        $this->assertEquals($expectedNumArray, NumPHP::arange(3, 7, 2));
    }

    public function testArangeFloatWithStep()
    {
        $expectedNumArray = new NumArray(
            [3.12, 4.66, 6.2]
        );
        $this->assertEquals($expectedNumArray, NumPHP::arange(3.12, 7, 1.54));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Step has to be a positiv value
     */
    public function testArangeInvalidArgumentException()
    {
        NumPHP::arange(1, 2, -1);
    }

    public function testLinspace0()
    {
        $this->assertEquals(new NumArray([]), NumPHP::linspace(1.5, 4.5, 0));
    }

    public function testLinspace1()
    {
        $this->assertEquals(new NumArray([1.5]), NumPHP::linspace(1.5, 4.5, 1));
    }

    public function testLinspace()
    {
        $expectedNumArray = new NumArray(
            [1.5, 2, 2.5, 3, 3.5, 4, 4.5]
        );
        $this->assertEquals($expectedNumArray, NumPHP::linspace(1.5, 4.5, 7));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Number has to be a positiv value
     */
    public function testLinspaceInvalidArgumentException()
    {
        NumPHP::linspace(1.5, 4.5, -1);
    }
}
