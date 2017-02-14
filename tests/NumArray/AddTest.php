<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

class AddTest extends TestCase
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function test2x3Add4()
    {
        $numArray1 = NumArray::ones(2, 3);
        $numArray2 = NumArray::ones(4);
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->add($numArray2);
    }

    public function test4Add4()
    {
        $numArray1 = new NumArray([-7, 8, 5, -7]);
        $numArray2 = new NumArray([6, -7, 1, -6]);
        $this->assertNumArrayEquals(new NumArray([-1, 1, 6, -13]), $numArray1->add($numArray2));
    }

    public function test2x3Add2x3()
    {
        $numArray1 = new NumArray([
            [0, 1, 5],
            [-4, -1, 0]
        ]);
        $numArray2 = new NumArray([
            [6, -8, 7],
            [-6, -7, -5]
        ]);
        $this->assertNumArrayEquals(new NumArray([
                [6, -7, 12],
                [-10, -8, -5]
            ]),
            $numArray1->add($numArray2)
        );
    }
}
