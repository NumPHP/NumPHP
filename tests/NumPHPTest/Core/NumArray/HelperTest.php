<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray\Helper;

/**
 * Class HelperTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if InvalidArgumentException will be thrown when Helper::multiply is
     * called with not numeric values
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Array contains non numeric values
     */
    public function testMultiplyInvalidArgumentException()
    {
        Helper::multiply([1, 2, 'k']);
    }

    /**
     * Tests Helper::multiply with filled array
     */
    public function testMultiply()
    {
        $this->assertSame(840, Helper::multiply([5, 7, '24']));
    }

    /**
     * Tests Helper::multiply with empty array
     */
    public function testMultiplyEmpty()
    {
        $this->assertSame(1, Helper::multiply([]));
    }
}
