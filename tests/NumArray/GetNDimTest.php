<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use PHPUnit\Framework\TestCase;

class GetNDimTest extends TestCase
{
    public function testGetNDim4()
    {
        $numArray = new NumArray([8, 9, 3, 6]);
        $this->assertSame(1, $numArray->getNDim());
    }

    public function testGetNDim2x3()
    {
        $numArray = new NumArray([
            [8, 6, 4],
            [3, 8, 0]
        ]);
        $this->assertSame(2, $numArray->getNDim());
    }
}
