<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;

class ToStringTest extends \PHPUnit_Framework_TestCase
{
    public function testToStringEmpty()
    {
        $numArray = new NumArray([]);
        $this->assertSame("[]", $numArray->__toString());
    }

    public function testToString3()
    {
        $numArray = new NumArray([6, 3, 0]);
        $this->assertSame("[6, 3, 0]", $numArray->__toString());
    }

    public function testToString2x3()
    {
        $numArray = new NumArray([
            [-2, 3, 9],
            [-7, 8, -8]
        ]);
        $this->assertSame("[\n  [-2, 3, 9],\n  [-7, 8, -8]\n]", $numArray->__toString());
    }
}
