<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/25/14
 * Time: 2:08 PM
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;

/**
 * Class NumArrayTest
 * @package NumPHPTest\Core
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testGetShape()
    {
        $numArray = new NumArray(1);
        $this->assertEquals([], $numArray->getShape());
    }

    public function testShape1()
    {
        $numArray = new NumArray([1]);
        $this->assertEquals([1], $numArray->getShape());
    }

    public function testGetShape2()
    {
        $numArray = new NumArray([1, 2]);
        $this->assertEquals([2], $numArray->getShape());
    }

    public function testGetShape2x0()
    {
        $numArray = new NumArray(
            [
                [],
                [],
            ]
        );
        $this->assertEquals([2, 0], $numArray->getShape());
    }

    public function testGetShape2x4()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
            ]
        );
        $this->assertEquals([2, 4], $numArray->getShape());
    }

    public function testGetShape2x3x4()
    {
        $numArray = new NumArray(
            [
                [
                    [1, 2, 3, 4],
                    [5, 6, 7, 8],
                    [9, 10, 11, 12],
                ],
                [
                    [13, 14, 15, 16],
                    [17, 18, 19, 20],
                    [21, 22, 23, 24],
                ]
            ]
        );
        $this->assertEquals([2, 3, 4], $numArray->getShape());
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Dimensions did not match
     */
    public function testGetShape2x2InvalidArgumentException()
    {
        new NumArray([[1], [2, 3]]);
    }

    public function testGet()
    {
        $numArray = new NumArray(1);
        $this->assertEquals(1, $numArray->get());
    }

    public function testGet1()
    {
        $numArray = new NumArray([1]);
        $this->assertEquals($numArray, $numArray->get());
    }

    public function testGet1Args0()
    {
        $numArray = new NumArray([1]);
        $this->assertEquals(1, $numArray->get(0));
    }

    public function testGet2()
    {
        $numArray = new NumArray([1, 2]);
        $this->assertEquals($numArray, $numArray->get());
    }

    public function testGet2Args1()
    {
        $numArray = new NumArray([1, 2]);
        $this->assertEquals(2, $numArray->get(1));
    }

    public function testGet4Args1Slice3()
    {
        $numArray = new NumArray([1, 2, 3, 4]);
        $expectedNumArray = new NumArray([2, 3]);
        $this->assertEquals($expectedNumArray, $numArray->get('1:3'));
    }

    public function testGet3Args1Slice()
    {
        $numArray = new NumArray([1, 2, 3]);
        $expectedNumArray = new NumArray([2, 3]);
        $this->assertEquals($expectedNumArray, $numArray->get('1:'));
    }

    public function testGet3ArgsSlice2()
    {
        $numArray = new NumArray([1, 2, 3]);
        $expectedNumArray = new NumArray([1, 2]);
        $this->assertEquals($expectedNumArray, $numArray->get(':2'));
    }

    public function testGet2x4()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
            ]
        );
        $this->assertEquals($numArray, $numArray->get());
    }

    public function testGet2x4Args0()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
            ]
        );
        $expectedNumArray = new NumArray(
            [1, 2, 3, 4]
        );
        $this->assertEquals($expectedNumArray, $numArray->get(0));
    }

    public function testGet2x4Args1x2()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
            ]
        );
        $this->assertEquals(7, $numArray->get(1, 2));
    }

    public function testGet3x4Args1Slice3()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
                [9, 10, 11, 12],
            ]
        );
        $expectedNumArray = new NumArray(
            [
                [7, 8],
                [11, 12]
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray->get('1:3', '2:4'));
    }

    public function testGet3x4ArgsSlicex3()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
                [9, 10, 11, 12],
            ]
        );
        $expectedNumArray = new NumArray(
            [3, 7, 11]
        );
        $this->assertEquals($expectedNumArray, $numArray->get(':', 2));
    }
}
