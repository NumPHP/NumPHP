<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\Reduce;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class MaxTest
  * @package NumPHPTest\Core\Reduce
  */
class MaxTest extends TestCase
{
    public function testMaxSingle()
    {
        $numArray = new NumArray(7);

        $expectedNumArray = new NumArray(7);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    public function testMaxVector()
    {
        $numArray = new NumArray(
            [4, -1, 78, -4]
        );

        $expectedNumArray = new NumArray(78);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    public function testMaxMatrix()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(453);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max());
    }

    public function testMaxSingleAxis0()
    {
        $numArray = new NumArray(-6);

        $expectedNumArray = new NumArray(-6);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    public function testMaxVectorAxis0()
    {
        $numArray = new NumArray(
            [4, -1, 34, -4]
        );

        $expectedNumArray = new NumArray(34);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    public function testMaxMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(
            [354, 453, 67]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(0));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMaxSingleAxis1()
    {
        $numArray = new NumArray(7);

        $numArray->max(1);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMaxVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 2);

        $numArray->max(1);
    }

    public function testMaxMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [354, 56, -78],
                [-1, 453, 67],
            ]
        );

        $expectedNumArray = new NumArray(
            [354, 453]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->max(1));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testMaxMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        $numArray->max(2);
    }
}
