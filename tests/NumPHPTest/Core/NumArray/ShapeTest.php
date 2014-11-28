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
 * Class ShapeTest
 * @package NumPHPTest\Core\NumArray
 */
class ShapeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetShape()
    {
        $numArray = NumPHP::zeros();
        $this->assertSame([], $numArray->getShape());
    }

    public function testShape1()
    {
        $numArray = NumPHP::zeros(1);
        $this->assertSame([1], $numArray->getShape());
    }

    public function testGetShape2()
    {
        $numArray = NumPHP::zeros(2);
        $this->assertSame([2], $numArray->getShape());
    }

    public function testGetShape2x0()
    {
        $numArray = NumPHP::zeros(2, 0);
        $this->assertSame([2, 0], $numArray->getShape());
    }

    public function testGetShape2x4()
    {
        $numArray = NumPHP::zeros(2, 4);
        $this->assertSame([2, 4], $numArray->getShape());
    }

    public function testGetShape2x3x4()
    {
        $numArray = NumPHP::ones(2, 3, 4);
        $this->assertSame([2, 3, 4], $numArray->getShape());
    }

    /**
     * @expectedException \NumPHP\Core\Exception\BadMethodCallException
     * @expectedExceptionMessage NumArray data is not an array
     */
    public function testReshapeBadMethodCallException()
    {
        $numArray = NumPHP::ones();
        $numArray->reshape();
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Total size of new array must be unchanged
     */
    public function testReshapeInvalidArgumentException()
    {
        $numArray = NumPHP::ones(2, 3);
        $numArray->reshape(2, 2);
    }

    public function testReshape2x3To1x6()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
        $this->assertEquals(NumPHP::arange(1, 6), $numArray->reshape(6));
    }

    public function testReshape3x4To2x6()
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
                [1, 2, 3, 4, 5, 6],
                [7, 8, 9, 10, 11, 12],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray->reshape(2, 6));
    }
}
