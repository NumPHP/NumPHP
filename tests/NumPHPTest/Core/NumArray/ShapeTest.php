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
        $this->assertEquals([], $numArray->getShape());
    }

    public function testShape1()
    {
        $numArray = NumPHP::zeros(1);
        $this->assertEquals([1], $numArray->getShape());
    }

    public function testGetShape2()
    {
        $numArray = NumPHP::zeros(2);
        $this->assertEquals([2], $numArray->getShape());
    }

    public function testGetShape2x0()
    {
        $numArray = NumPHP::zeros(2, 0);
        $this->assertEquals([2, 0], $numArray->getShape());
    }

    public function testGetShape2x4()
    {
        $numArray = NumPHP::zeros(2, 4);
        $this->assertEquals([2, 4], $numArray->getShape());
    }

    public function testGetShape2x3x4()
    {
        $numArray = NumPHP::ones(2, 3, 4);
        $this->assertEquals([2, 3, 4], $numArray->getShape());
    }
}
