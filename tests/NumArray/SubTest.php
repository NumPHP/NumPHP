<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

class SubTest extends TestCase
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function test2x3Sub4()
    {
        $numArray1 = NumArray::ones(2, 3);
        $numArray2 = NumArray::ones(4);
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->sub($numArray2);
    }

    public function test4Sub4()
    {
        $numArray1 = new NumArray([-5, -2, 3, 8]);
        $numArray2 = new NumArray([-7, -6, 0, 2]);
        $this->assertNumArrayEquals(new NumArray([2, 4, 3, 6]), $numArray1->sub($numArray2));
    }

    public function test2x3Sub2x3()
    {
        $numArray1 = new NumArray([
            [1, -5, 5],
            [0, -5, -1]
        ]);
        $numArray2 = new NumArray([
            [3, -9, 4],
            [7, -9, 4]
        ]);
        $this->assertNumArrayEquals(
            new NumArray([
                [-2, 4, 1],
                [-7, 4, -5]
            ]),
            $numArray1->sub($numArray2)
        );
    }
}
