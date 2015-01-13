<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class NumPHPTest
 *
 * @package   NumPHPTest\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class NumPHPTest extends TestCase
{
    /**
     * Compares the version in README.md with NumPHP::VERSION
     */
    public function testREADMEVersion()
    {
        $readmeContent = file_get_contents(realpath(__DIR__.'/../../../README.md'));
        $this->assertNotFalse(
            strpos($readmeContent, '*NumPHP '.NumPHP::VERSION.'*'),
            'Version in README.md is not updated'
        );
    }

    /**
     * Tests NumPHP::arange without step
     */
    public function testArangeIntWithoutStep()
    {
        $expectedNumArray = new NumArray(
            [3, 4, 5, 6, 7]
        );
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::arange(3, 7));
    }

    /**
     * Tests NumPHP::arange with float values and step
     */
    public function testArangeFloatWithoutStep()
    {
        $expectedNumArray = new NumArray(
            [3.45, 4.45, 5.45, 6.45]
        );
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::arange(3.45, 7));

        $expectedNumArray = new NumArray(
            [3.45, 4.45, 5.45, 6.45, 7.45]
        );
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::arange(3.45, 7.45));
    }

    /**
     * Tests NumPHP::arange with integer step
     */
    public function testArangeIntWithStep()
    {
        $expectedNumArray = new NumArray(
            [3, 5, 7]
        );
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::arange(3, 7, 2));
    }

    /**
     * Tests NumPHP::arange with float step
     */
    public function testArangeFloatWithStep()
    {
        $expectedNumArray = new NumArray(
            [3.12, 4.66, 6.2]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            NumPHP::arange(3.12, 7, 1.54)
        );
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using NumPHP::arange
     * with negative step
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Step has to be a positive value
     */
    public function testArangeInvalidArgumentException()
    {
        NumPHP::arange(1, 2, -1);
    }

    /**
     * Tests NumPHP::linspace with size 0
     */
    public function testLinspace0()
    {
        $expectedNumArray = new NumArray([]);
        $this->assertNumArrayEquals(
            $expectedNumArray,
            NumPHP::linspace(1.5, 4.5, 0)
        );
    }

    /**
     * Tests NumPHP::linspace with size 1
     */
    public function testLinspace1()
    {
        $expectedNumArray = new NumArray([1.5]);
        $this->assertNumArrayEquals(
            $expectedNumArray,
            NumPHP::linspace(1.5, 4.5, 1)
        );
    }

    /**
     * Tests NumPHP::linspace with size 7
     */
    public function testLinspace()
    {
        $expectedNumArray = new NumArray(
            [1.5, 2, 2.5, 3, 3.5, 4, 4.5]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            NumPHP::linspace(1.5, 4.5, 7)
        );
    }

    /**
     * Test if InvalidArgumentException will be thrown, when using NumPHP::linspace
     * with negative `$number`
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Number has to be a positive value
     */
    public function testLinspaceInvalidArgumentException()
    {
        NumPHP::linspace(1.5, 4.5, -1);
    }
}
