<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\NumArray\Filter
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\NumArray\Filter;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class Abs
 *
 * @category Core
 * @package  NumPHPTest\Core\NumArray\Filter
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class AbsTest extends TestCase
{
    /**
     * Tests NumArray::abs with scalar value
     *
     * @return void
     */
    public function testAbsSingle()
    {
        $numArray = new NumArray(-1);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->abs());
    }

    /**
     * Tests NumArray::abs with a vector
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
     */
    public function testAbsCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 6);

        $numArray->abs();
        $this->assertFalse($numArray->inCache('key'));
    }
}
