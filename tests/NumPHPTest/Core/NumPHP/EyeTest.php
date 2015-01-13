<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumPHP;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class EyeTest
 *
 * @package   NumPHPTest\Core\NumPHP
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class EyeTest extends TestCase
{
    /**
     * Tests NumPHP::eye with argument 1
     */
    public function testEye1()
    {
        $numArray = NumPHP::eye(1);

        $expectedNumArray = NumPHP::ones(1, 1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    /**
     * Tests NumPHP::eye with argument 4
     */
    public function testEye4()
    {
        $numArray = NumPHP::eye(4);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0, 0],
                [0, 1, 0, 0],
                [0, 0, 1, 0],
                [0, 0, 0, 1],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    /**
     * Tests NumPHP::eye with arguments 2, 3
     */
    public function testEye2x3()
    {
        $numArray = NumPHP::eye(2, 3);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0],
                [0, 1, 0],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    /**
     * Tests NumPHP::eye with arguments 4, 3
     */
    public function testEye4x3()
    {
        $numArray = NumPHP::eye(4, 3);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
                [0, 0, 0],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }

    /**
     * Tests NumPHP::identity with argument 3
     */
    public function testIdentity()
    {
        $numArray = NumPHP::identity(3);

        $expectedNumArray = NumPHP::eye(3, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray);
    }
}
