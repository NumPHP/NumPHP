<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;

class GetSizeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSize4()
    {
        $numArray = new NumArray([6, 9, 3, 4]);
        $this->assertSame(4, $numArray->getSize());
    }

    public function testGetSize2x3()
    {
        $numArray = new NumArray([
            [6, 0, 2],
            [2, 3, 9]
        ]);
        $this->assertSame(6, $numArray->getSize());
    }
}
