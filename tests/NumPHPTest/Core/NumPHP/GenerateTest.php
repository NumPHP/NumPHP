<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumPHP;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class GenerateTest
 *
 * @package   NumPHPTest\Core\NumPHP
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class GenerateTest extends TestCase
{
    /**
     * @expectedException        \NumPHP\Core\Exception\MissingArgumentException
     * @expectedExceptionMessage Required Argument 'axis' not found
     */
    public function testGenerateMissingArgument()
    {
        NumPHP::generate(5);
    }

    /**
     * Tests NumArray::generate
     */
    public function testGenerate3x4()
    {
        $expectedNumArray = new NumArray(array_fill(0, 3, array_fill(0, 4, 5)));

        $this->assertNumArrayEquals($expectedNumArray, NumPHP::generate(5, 3, 4));
    }

    /**
     * Tests NumArray::ones
     */
    public function testZeros()
    {
        $expectedNumArray = new NumArray(array_fill(0, 2, array_fill(0, 4, 0)));

        $this->assertNumArrayEquals($expectedNumArray, NumPHP::zeros(2, 4));
    }

    /**
     * Tests NumArray::zerosLike
     */
    public function testZerosLike()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        $expectedNumArray = new NumArray(array_fill(0, 2, array_fill(0, 3, 0)));
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::zerosLike($numArray));
    }

    /**
     * Tests NumArray::ones
     */
    public function testOnes()
    {
        $expectedNumArray = new NumArray(array_fill(0, 2, array_fill(0, 4, 1)));

        $this->assertNumArrayEquals($expectedNumArray, NumPHP::ones(2, 4));
    }

    /**
     * Tests NumArray::onesLike
     */
    public function testOnesLike()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        $expectedNumArray = new NumArray(array_fill(0, 2, array_fill(0, 3, 1)));
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::onesLike($numArray));
    }
}
