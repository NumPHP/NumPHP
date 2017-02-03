<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class OnesTest extends TestCase
{
    public function testOnesEmpty()
    {
        $this->expectException(MissingArgumentException::class);
        $this->expectExceptionMessage('No $axis given');
        NumArray::ones();
    }

    public function testOnes4()
    {
        $numArray = new NumArray([1, 1, 1, 1]);
        $this->assertTrue($numArray->isEqual(NumArray::ones(4)));
    }

    public function testOnes2x3()
    {
        $numArray = new NumArray([
            [1, 1, 1],
            [1, 1, 1]
        ]);
        $this->assertTrue($numArray->isEqual(NumArray::ones(2, 3)));
    }
}
