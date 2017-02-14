<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

class DivTest extends TestCase
{
    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function test2x3Div4()
    {
        $numArray1 = NumArray::ones(2, 3);
        $numArray2 = NumArray::ones(4);
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->div($numArray2);
    }

    public function test4Div4()
    {
        $numArray1 = new NumArray([-6, 4, -9, -4]);
        $numArray2 = new NumArray([7, 7, 6, 9]);
        $this->assertNumArrayEquals(new NumArray([-6 / 7, 4 / 7, -3 / 2, -4 / 9]), $numArray1->div($numArray2));
    }

    public function test2x3Div2x3()
    {
        $numArray1 = new NumArray([
            [-7, 9, -8],
            [1, -5, -1]
        ]);
        $numArray2 = new NumArray([
            [1, -5, -2],
            [2, 6, 5]
        ]);
        $this->assertNumArrayEquals(
            new NumArray([
                [-7, -9 / 5, 4],
                [1 / 2, -5 / 6, -1 / 5]
            ]),
            $numArray1->div($numArray2)
        );
    }
}
