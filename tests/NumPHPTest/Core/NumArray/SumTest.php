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
 * Class SumTest
  * @package NumPHPTest\Core\NumArray
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
  */
class SumTest extends \PHPUnit_Framework_TestCase
{
    public function testSumSingle()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertEquals($expectedNumArray, $numArray->sum());
    }

    public function testSumVector()
    {
        $numArray = NumPHP::arange(1, 8);

        $expectedNumArray = new NumArray(36);
        $this->assertEquals($expectedNumArray, $numArray->sum());
    }

    public function testSumMatrix()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = new NumArray(78);
        $this->assertEquals($expectedNumArray, $numArray->sum());
    }

    public function testSumSingleAxis0()
    {
        $numArray = new NumArray(6);

        $expectedNumArray = new NumArray(6);
        $this->assertEquals($expectedNumArray, $numArray->sum(0));
    }

    public function testSumVectorAxis0()
    {
        $numArray = NumPHP::arange(1, 8);

        $expectedNumArray = new NumArray(36);
        $this->assertEquals($expectedNumArray, $numArray->sum(0));
    }

    public function testSumMatrixAxis0()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(15, 24, 3);
        $this->assertEquals($expectedNumArray, $numArray->sum(0));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testSumSingleAxis1()
    {
        $numArray = new NumArray(6);

        $numArray->sum(1);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testSumVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 8);

        $numArray->sum(1);
    }

    public function testSumMatrixAxis1()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(10, 42, 16);
        $this->assertEquals($expectedNumArray, $numArray->sum(1));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testSumMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);

        $numArray->sum(2);
    }

    public function testSumMatrix2x3x4Axis2()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        $expectedNumArray = NumPHP::arange(10, 90, 16)->reshape(2, 3);
        $this->assertEquals($expectedNumArray, $numArray->sum(2));
    }
}
