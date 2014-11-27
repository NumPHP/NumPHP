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

/**
 * Class ShapeTest
 * @package NumPHPTest\Core\NumArray
 */
class ShapeTest extends \PHPUnit_Framework_TestCase
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
}
