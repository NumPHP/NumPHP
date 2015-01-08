<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class SizeTest
 *
 * @category Core
 * @package  NumPHPTest\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class SizeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests NumArray::getSize on scalar
     *
     * @return void
     */
    public function testGetSize()
    {
        $numArray = NumPHP::ones();
        $this->assertSame(1, $numArray->getSize());
    }

    /**
     * Tests NumArray::getSize on scalar
     *
     * @return void
     */
    public function testGetSize1()
    {
        $numArray = NumPHP::zeros(1);
        $this->assertSame(1, $numArray->getSize());
    }

    /**
     * Tests NumArray::getSize on a vector
     *
     * @return void
     */
    public function testGetSize2()
    {
        $numArray = NumPHP::zeros(2);
        $this->assertSame(2, $numArray->getSize());
    }

    /**
     * Tests NumArray::getSize on a matrix
     *
     * @return void
     */
    public function testGetSize2x3()
    {
        $numArray = NumPHP::zeros(2, 3);
        $this->assertSame(6, $numArray->getSize());
    }

    /**
     * Tests NumArray::getSize on a 2x3x4 matrix
     *
     * @return void
     */
    public function getSize2x3x4()
    {
        $numArray = NumPHP::zeros(2, 3, 4);
        $this->assertSame(24, $numArray->getSize());
    }
}
