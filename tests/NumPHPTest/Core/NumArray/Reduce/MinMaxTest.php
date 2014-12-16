<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray\Reduce;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class MinMaxTest
  * @package NumPHPTest\Core\NumArray\Reduce
  */
class MinTest extends \PHPUnit_Framework_TestCase
{
    public function testMinSingle()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertEquals($expectedNumArray, $numArray->min());
    }

    public function testMinVector()
    {
        $numArray = new NumArray(
            [-5, 7, 9, -34]
        );

        $expectedNumArray = new NumArray(-34);
        $this->assertEquals($expectedNumArray, $numArray->min());
    }

    public function testMinMatrix()
    {
        $numArray = new NumArray(
            [
                [6, 3],
                [-1, 11],
            ]
        );

        $expectedNumArray = new NumArray(-1);
        $this->assertEquals($expectedNumArray, $numArray->min());
    }

    public function testMinSingleAxis0()
    {
        $numArray = new NumArray(99);

        $expectedNumArray = new NumArray(99);
        $this->assertEquals($expectedNumArray, $numArray->min(0));
    }

    public function testMinVectorAxis0()
    {
        $numArray = NumPHP::arange(1, 5);

        $expectedNumArray = new NumArray(1);
        $this->assertEquals($expectedNumArray, $numArray->min(0));
    }

    public function testMinMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [34, 346, -12],
                [56, -78, 12],
                [345, -6, 99],
            ]
        );

        $expectedNumArray = new NumArray(
            [34, -78, -12]
        );
        $this->assertEquals($expectedNumArray, $numArray->min(0));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMinSingleAxis1()
    {
        $numArray = new NumArray(5);

        $numArray->min(1);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMinVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 5);

        $numArray->min(1);
    }

    public function testMinMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [34, 346, -12],
                [56, -78, 12],
                [345, -6, 99],
            ]
        );

        $expectedNumArray = new NumArray(
            [-12, -78, -6]
        );
        $this->assertEquals($expectedNumArray, $numArray->min(1));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testNimMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 9)->reshape(3, 3);

        $numArray->min(2);
    }
}
