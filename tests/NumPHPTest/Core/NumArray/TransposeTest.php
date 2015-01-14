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
 * Class TransposeTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class TransposeTest extends TestCase
{
    /**
     * Tests NumArray::getTranspose on scalar value
     */
    public function testTranspose()
    {
        $numArray = new NumArray(1);
        $this->assertNumArrayEquals($numArray, $numArray->getTranspose());
    }

    /**
     * Tests NumArray::getTranspose on a vector
     */
    public function testTranspose3()
    {
        $numArray = NumPHP::arange(1, 3);
        $this->assertNumArrayEquals($numArray, $numArray->getTranspose());
    }

    /**
     * Tests NumArray::getTranspose on a matrix
     */
    public function testTranspose2x3()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $expectedNumArray = new NumArray(
            [
                [1, 4],
                [2, 5],
                [3, 6],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->getTranspose());
    }

    /**
     * Tests NumArray::getTranspose on a 2x3x4 matrix
     */
    public function testTranspose2x3x4()
    {
        $numArray = NumPHP::arange(1, 24)->reshape(2, 3, 4);
        $expectedNumArray = new NumArray(
            [
                [
                    [1, 13],
                    [5, 17],
                    [9, 21],
                ],
                [
                    [2, 14],
                    [6, 18],
                    [10,22],
                ],
                [
                    [3, 15],
                    [7, 19],
                    [11, 23],
                ],
                [
                    [4, 16],
                    [8, 20],
                    [12, 24],
                ]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->getTranspose());
    }

    /**
     * Tests caching of NumArray::getTranspose
     */
    public function testTransposeCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache(NumArray\Transpose::CACHE_KEY_TRANSPOSE, 8);

        $this->assertSame(8, $numArray->getTranspose());
    }
}
