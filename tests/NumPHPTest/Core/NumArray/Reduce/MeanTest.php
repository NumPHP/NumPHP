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
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class MeanTest
  * @package NumPHPTest\Core\NumArray\Reduce
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
  */
class MeanTest extends TestCase
{
    public function testMeanSingle()
    {
        $numArray = new NumArray(5);

        $expectedNumArray = new NumArray(5);
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    public function testMeanVector()
    {
        $numArray = new NumArray(
            [45, 2, -5]
        );

        $expectedNumArray = new NumArray(14);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean());
    }

    public function testMeanMatrix()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);

        $expectedNumArray = new NumArray(3.5);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean());
    }

    public function testMeanSingleAxis0()
    {
        $numArray = new NumArray(-4);

        $expectedNumArray = new NumArray(-4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    public function testMeanVectorAxis0()
    {
        $numArray = new NumArray(
            [45, 2, -5]
        );

        $expectedNumArray = new NumArray(14);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    public function testMeanMatrixAxis0()
    {
        $numArray = new NumArray(
            [
                [12, -43, 6],
                [-3, 89, 23],
            ]
        );

        $expectedNumArray = new NumArray(
            [4.5, 23, 14.5]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMeanSingleAxis1()
    {
        $numArray = new NumArray(5);

        $numArray->mean(1);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 1 out of bounds
     */
    public function testMeanVectorAxis1()
    {
        $numArray = NumPHP::arange(1, 2);

        $numArray->mean(1);
    }

    public function testMeanMatrixAxis1()
    {
        $numArray = new NumArray(
            [
                [12, -43, 6],
                [-3, 89, 23],
            ]
        );

        $expectedNumArray = new NumArray(
            [-25/3, 109/3]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(1));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Axis 2 out of bounds
     */
    public function testMeanMatrixAxis2()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        $numArray->mean(2);
    }

    public function testMeanMatrix2x3x4Axis0()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);

        $expectedNumArray = NumPHP::arange(7, 18)->reshape(3, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->mean(0));
    }
}
