<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class GetTest
 * @package NumPHPTest\Core\NumArray
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class GetTest extends TestCase
{
    public function testGet()
    {
        $numArray = new NumArray(1);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get());
    }

    public function testGet1()
    {
        $numArray = new NumArray([1]);

        $expectedNumArray = new NumArray([1]);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get());
    }

    public function testGet1Args0()
    {
        $numArray = new NumArray([1]);

        $expectedNumArray = new NumArray(1);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(0));
    }

    public function testGet2()
    {
        $numArray = NumPHP::arange(1, 2);
        $this->assertNumArrayEquals($numArray, $numArray->get());
    }

    public function testGet2Args1()
    {
        $numArray = NumPHP::arange(1, 2);

        $expectedNumArray = new NumArray(2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(1));
    }

    public function testGet4Args1Slice3()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = NumPHP::arange(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:3'));
    }

    public function testGet3Args1Slice()
    {
        $numArray = NumPHP::arange(1, 3);
        $expectedNumArray = NumPHP::arange(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:'));
    }

    public function testGet3ArgsSlice2()
    {
        $numArray = NumPHP::arange(1, 3);
        $expectedNumArray = NumPHP::arange(1, 2);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':2'));
    }

    public function testGet2x4()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);
        $this->assertNumArrayEquals($numArray, $numArray->get());
    }

    public function testGet2x4Args0()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);
        $expectedNumArray = NumPHP::arange(1, 4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(0));
    }

    public function testGet2x4Args1x2()
    {
        $numArray = NumPHP::arange(1, 8)->reshape(2, 4);

        $expectedNumArray = new NumArray(7);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(1, 2));
    }

    public function testGet3x4Args1Slice3()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $expectedNumArray = new NumArray(
            [
                [7, 8],
                [11, 12]
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('1:3', '2:4'));
    }

    public function testGet3x4ArgsSlicex3()
    {
        $numArray = NumPHP::arange(1, 12)->reshape(3, 4);
        $expectedNumArray = new NumArray(
            [3, 7, 11]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':', 2));
    }

    public function testGet3ArgsMinus1()
    {
        $numArray = NumPHP::arange(1, 4);

        $expectedNumArray = new NumArray(4);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(-1));
    }

    public function testGet4ArgsMinus1Slice()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = new NumArray([4]);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get('-1:'));
    }

    public function testGet4ArgsSliceMinus1()
    {
        $numArray = NumPHP::arange(1, 4);
        $expectedNumArray = NumPHP::arange(1, 3);
        $this->assertNumArrayEquals($expectedNumArray, $numArray->get(':-1'));
    }
}
