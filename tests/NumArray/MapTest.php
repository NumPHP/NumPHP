<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\InvalidArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

class MapTest extends TestCase
{
    private $callback;

    public function setUp()
    {
        $this->callback = function ($val1, $val2) {
            return abs($val1 - $val2);
        };
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function test2x3Map4()
    {
        $numArray1 = NumArray::ones(2, 3);
        $numArray2 = NumArray::ones(4);
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->map($this->callback, $numArray2);
    }

    public function test4Map4()
    {
        $numArray1 = new NumArray([-2, 5, -7, 0]);
        $numArray2 = new NumArray([-5, 5, -8, -2]);
        $this->assertNumArrayEquals(new NumArray([3, 0, 1, 2]), $numArray1->map($this->callback, $numArray2));
    }

    public function test2x3Map2x3()
    {
        $numArray1 = new NumArray([
            [1, 6, -4],
            [5, -4, 8]
        ]);
        $numArray2 = new NumArray([
            [8, -1, 7],
            [9, 1, -5]
        ]);
        $this->assertNumArrayEquals(
            new NumArray([
                [7, 7, 11],
                [4, 5, 13]
            ]),
            $numArray1->map($this->callback, $numArray2)
        );
    }

    public function test4MapThreeArguments()
    {
        $numArray1 = new NumArray([6, 0, -7, 9]);
        $numArray2 = new NumArray([-3, 2, 5, -1]);
        $numArray3 = new NumArray([9, -7, 7, -1]);
        $callback = function ($val1, $val2, $val3) {
            return ($val1 + $val2) * $val3;
        };
        $this->assertNumArrayEquals(
            new NumArray([27, -14, -14, -8]),
            $numArray1->map($callback, $numArray2, $numArray3)
        );
    }
}
