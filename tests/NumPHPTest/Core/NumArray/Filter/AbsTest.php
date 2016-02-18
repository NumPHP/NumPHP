<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray\Filter;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class Abs
 *
 * @package   NumPHPTest\Core\NumArray\Filter
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class AbsTest extends TestCase
{
    /**
     * Tests NumArray::abs with scalar value
     */
    public function testAbsSingle()
    {
        $numArray = new NumArray(-1);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->abs());
    }

    /**
     * Tests NumArray::abs with a vector
     */
    public function testAbsVector()
    {
        $numArray = new NumArray(
            [-4, 6, -89]
        );

        $expectedNumArray = new NumArray(
            [4, 6, 89]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->abs());
    }

    /**
     * Tests NumArray::abs with a matrix
     */
    public function testAbsMatrix()
    {
        $numArray = new NumArray(
            [
                [1, -2, -3],
                [-4, -5, 6],
            ]
        );

        $expectedNumArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->abs());
    }

    /**
     * Tests if cache will be flushed after using NumArray::abs
     */
    public function testAbsCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 6);

        $numArray->abs();
        $this->assertFalse($numArray->inCache('key'));
    }
}
