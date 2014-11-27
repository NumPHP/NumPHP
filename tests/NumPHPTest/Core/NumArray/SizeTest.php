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
 * Class SizeTest
 * @package NumPHPTest\Core\NumArray
 */
class SizeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSize()
    {
        $numArray = NumPHP::ones();
        $this->assertEquals(1, $numArray->getSize());
    }

    public function testGetSize1()
    {
        $numArray = NumPHP::zeros(1);
        $this->assertEquals(1, $numArray->getSize());
    }

    public function testGetSize2()
    {
        $numArray = NumPHP::zeros(2);
        $this->assertEquals(2, $numArray->getSize());
    }

    public function testGetSize2x3()
    {
        $numArray = NumPHP::zeros(2, 3);
        $this->assertEquals(6, $numArray->getSize());
    }

    public function getSize2x3x4()
    {
        $numArray = NumPHP::zeros(2, 3, 4);
        $this->assertEquals(24, $numArray->getSize());
    }
}
