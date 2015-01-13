<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class StringTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests NumArray::__toString with scalar value
     */
    public function testToString()
    {
        $numArray = new NumArray(1);
        $this->expectOutputString("NumArray(1)\n");
        echo $numArray;
    }

    /**
     * Tests NumArray::__toString with vector
     */
    public function testToString2()
    {
        $numArray = NumPHP::arange(1, 2);
        $this->expectOutputString("NumArray([1, 2])\n");
        echo $numArray;
    }

    /**
     * Tests NumArray::__toString with matrix
     */
    public function testToString3x4()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $expectedOutput = "NumArray([\n  [1, 2, 3, 4],\n  [5, 6, 7, 8],\n  [9, 10,".
            " 11, 12]\n])\n";
        $this->expectOutputString($expectedOutput);
        echo $numArray;
    }
}
