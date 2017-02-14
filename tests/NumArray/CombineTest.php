<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

class CombineTest extends TestCase
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
    public function test2x3Combine4()
    {
        $numArray1 = NumArray::ones(2, 3);
        $numArray2 = NumArray::ones(4);
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->combine($numArray2, $this->callback);
    }

    public function test4Combine4()
    {
        $numArray1 = new NumArray([-2, 5, -7, 0]);
        $numArray2 = new NumArray([-5, 5, -8, -2]);
        $this->assertNumArrayEquals(new NumArray([3, 0, 1, 2]), $numArray1->combine($numArray2, $this->callback));
    }

    public function test2x3Combine2x3()
    {
        $numArray1 = new NumArray([
            [1, 6, -4],
            [5, -4, 8]
        ]);
        $numArray2 = new NumArray([
            [8, -1, 7],
            [9, 1, -5]
        ]);
        $this->assertNumArrayEquals(new NumArray([
                [7, 7, 11],
                [4, 5, 13]
            ]),
            $numArray1->combine($numArray2, $this->callback)
        );
    }
}
