<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class NumArrayTest
 *
 * @package   NumPHPTest\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests if InvalidArgumentException will be thrown, when creating a NumArray
     * with wrong input
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Dimensions did not match
     */
    public function testConstructInvalidArgumentException()
    {
        new NumArray([[1], [2, 3]]);
    }

    /**
     * Tests NumArray::getData
     */
    public function testGetData()
    {
        $array = [1, 2, 3];
        $numArray = new NumArray($array);
        $this->assertSame($array, $numArray->getData());
    }

    /**
     * Tests NumArray::getNDim
     */
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
