<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class GetTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GetTest extends TestCase
{
    /**
     * Tests NumArray::get without arguments on scalar value
     */
    public function testGet()
    {
        $numArray = new NumArray(1);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get());
    }

    /**
     * Tests NumArray::get without arguments on scalar value
     */
    public function testGet1()
    {
        $numArray = new NumArray([1]);

        $expectedNumArray = new NumArray([1]);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get());
    }

    /**
     * Tests NumArray::get with argument 0 on vector with size 1
     */
    public function testGet1Args0()
    {
        $numArray = new NumArray([1]);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(0));
    }

    /**
     * Tests NumArray::get without argument on vector
     */
    public function testGet2()
    {
        $numArray = NumPHP::arange(1, 2);
        $expectedNumArray = NumPHP::arange(1, 2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get());
    }

    /**
     * Tests NumArray::get with argument 1 on vector
     */
    public function testGet2Args1()
    {
        $numArray = NumPHP::arange(1, 2);

        $expectedNumArray = new NumArray(2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(1));
    }

    /**
     * Tests NumArray::get with slicing argument `1:3` on vector
     */
    public function testGet4Args1Slice3()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = NumPHP::arange(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:3'));
    }

    /**
     * Tests NumArray::get with slicing argument `1:` on vector
     */
    public function testGet3Args1Slice()
    {
        $numArray = NumPHP::arange(1, 3);
        $expectedNumArray = NumPHP::arange(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:'));
    }

    /**
     * Tests NumArray::get with slicing argument `:2` on vector
     */
    public function testGet3ArgsSlice2()
    {
        $numArray = NumPHP::arange(1, 3);
        $expectedNumArray = NumPHP::arange(1, 2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':2'));
    }

    /**
     * Tests NumArray::get with slicing argument `0:0` on vector
     */
    public function testGet3Args0Slice0()
    {
        $numArray = NumPHP::arange(1, 3);
        $expectedNumArray = new NumArray([]);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('0:0'));
    }

    /**
     * Tests NumArray::get without argument on matrix
     */
    public function testGet2x4()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);
        $this->assertNumArrayEquals($numArray, $numArray->get());
    }

    /**
     * Tests NumArray::get with argument 0 on matrix
     */
    public function testGet2x4Args0()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);
        $expectedNumArray = NumPHP::arange(1, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(0));
    }

    /**
     * Tests NumArray::get with argument 1, 2 on matrix
     */
    public function testGet2x4Args1x2()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);

        $expectedNumArray = new NumArray(7);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(1, 2));
    }

    /**
     * Tests NumArray::get with slicing argument `1:3`, `2:4` on matrix
     */
    public function testGet3x4Args1Slice3()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $expectedNumArray = new NumArray(
            [
                [7, 8],
                [11, 12]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:3', '2:4'));
    }

    /**
     * Tests NumArray::get with slicing argument `:`, 2 on matrix
     */
    public function testGet3x4ArgsSlicex3()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $expectedNumArray = new NumArray(
            [3, 7, 11]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':', 2));
    }

    /**
     * Tests NumArray::get with negative argument on vector
     */
    public function testGet3ArgsMinus1()
    {
        $numArray = NumPHP::arange(1, 4);

        $expectedNumArray = new NumArray(4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(-1));
    }

    /**
     * Tests NumArray::get with negative slicing argument `-1:` on vector
     */
    public function testGet4ArgsMinus1Slice()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = new NumArray([4]);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('-1:'));
    }

    /**
     * Tests NumArray::get with negative slicing argument `:-1` on vector
     */
    public function testGet4ArgsSliceMinus1()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = NumPHP::arange(1, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':-1'));
    }
}
