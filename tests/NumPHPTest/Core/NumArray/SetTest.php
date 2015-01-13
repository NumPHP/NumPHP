<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class SetTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class SetTest extends TestCase
{
    /**
     * Tests NumArray::set with single value
     */
    public function testSetSingleEntry()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [6, 7, 8, 9, 10],
                [11, 12, 13, 9, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->set(9, 2, 3));
    }

    /**
     * Tests NumArray::set with single value
     */
    public function testSetSingleNumArray()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $expectedNumArray = new NumArray(
            [
                [1, -1, 3],
                [4, 5, 6],
            ]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            $numArray->set(new NumArray(-1), 0, 1)
        );
    }

    /**
     * Tests NumArray::set with a row
     */
    public function testSetRow()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [-6, -7, -8, -9, -10],
                [11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            $numArray->set([-6, -7, -8, -9, -10], 1)
        );
    }

    /**
     * Tests NumArray::set with a row
     */
    public function testSetRowNumArray()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [-6, -7, -8, -9, -10],
                [11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            $numArray->set(new NumArray([-6, -7, -8, -9, -10]), 1)
        );
    }

    /**
     * Tests if cache will be flushed after NumArray::set
     */
    public function testSetCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 6);

        $numArray->set(6);
        $this->assertFalse($numArray->inCache('key'));
    }
}
