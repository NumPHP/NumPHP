<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\NumArray;

class AddTest extends \PHPUnit_Framework_TestCase
{
    public function test2x3Add4()
    {
        $numArray1 = new NumArray([
            [-4, 8, 1],
            [-8, -6, 2]
        ]);
        $numArray2 = new NumArray([8, -8, 1, -3]);
        $this->expectException(IllegalArgumentException::class);
        $this->expectExceptionMessage('Shape [2, 3] and [4] are different');
        $numArray1->add($numArray2);
    }

    public function test4Add4()
    {
        $numArray1 = new NumArray([-7, 8, 5, -7]);
        $numArray2 = new NumArray([6, -7, 1, -6]);
        $this->assertTrue($numArray1->add($numArray2)->isEqual(new NumArray([-1, 1, 6, -13])));
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
        $this->assertTrue($numArray1->add($numArray2)->isEqual(new NumArray([
            [6, -7, 12],
            [-10, -8, -5]
        ])));
    }
}