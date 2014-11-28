<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class NumArrayTest
 * @package NumPHPTest\Core
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Dimensions did not match
     */
    public function testConstructInvalidArgumentException()
    {
        new NumArray([[1], [2, 3]]);
    }

    public function testGetData()
    {
        $array = [1, 2, 3];
        $numArray = new NumArray($array);
        $this->assertSame($array, $numArray->getData());
    }

    public function testNDim()
    {
        $numArray = new NumArray(1);
        $this->assertSame(0, $numArray->getNDim());

        $numArray = NumPHP::arange(1, 2);
        $this->assertSame(1, $numArray->getNDim());

        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $this->assertSame(2, $numArray->getNDim());
    }
}
