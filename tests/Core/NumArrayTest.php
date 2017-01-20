<?php
declare(strict_types=1);

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;

class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    public function testData()
    {
        $data = [1, 2, 3, 4];
        $numArray = new NumArray($data);

        $this->assertSame($data, $numArray->getData());
    }
}
