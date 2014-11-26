<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/26/14
 * Time: 7:52 AM
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;

/**
 * Class GetTest
 * @package NumPHPTest\Core\NumArray
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class GetTest extends \PHPUnit_Framework_TestCase
{
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

    public function testGet3ArgsMinus1()
    {
        $numArray = new NumArray(
            [1, 2, 3, 4]
        );
        $this->assertEquals(4, $numArray->get(-1));
    }

    public function testGet4ArgsMinus1Slice()
    {
        $numArray = new NumArray(
            [1, 2, 3, 4]
        );
        $expectedNumArray = new NumArray(
            [4]
        );
        $this->assertEquals($expectedNumArray, $numArray->get('-1:'));
    }

    public function testGet4ArgsSliceMinus1()
    {
        $numArray = new NumArray(
            [1, 2, 3, 4]
        );
        $expectedNumArray = new NumArray(
            [1, 2, 3]
        );
        $this->assertEquals($expectedNumArray, $numArray->get(':-1'));
    }
}
