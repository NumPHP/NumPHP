<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class ArangeTest extends TestCase
{
    /**
     * @dataProvider arangeProvider
     */
    public function testArange($arg, $result)
    {
        $numArray = NumArray::arange(...$arg);
        $expected = new NumArray($result);
        $this->assertTrue(
            $numArray->isEqual($expected),
            sprintf("Failed asserting that \n%s\nequals\n%s.", $numArray->__toString(), $expected->__toString())
        );
    }

    public function arangeProvider(): array
    {
        return [
            [[0, 0], []],
            [[0, 4, -1], []],
            [[0, 4], [0.0, 1.0, 2.0, 3.0]],
            [[0.5, 0.5], []],
            [[0.5, 3.5], [0.5, 1.5, 2.5]],
            [[0.5, 3.6], [0.5, 1.5, 2.5, 3.5]],
            [[0, 3, 0.5], [0.0, 0.5, 1.0, 1.5, 2.0, 2.5]],
            [[0.5, 2.5, 0.5], [0.5, 1.0, 1.5, 2.0]],
            [[0.5, 2.6, 0.5], [0.5, 1.0, 1.5, 2.0, 2.5]],
            [[0, -4], []],
            [[-1, -1], []],
            [[0, -4, -1], [0.0, -1.0, -2.0, -3.0]],
            [[-0.5, -0.5, -1], []],
            [[-0.5, -3.5, -1], [-0.5, -1.5, -2.5]],
            [[-0.5, -3.6, -1], [-0.5, -1.5, -2.5, -3.5]],
            [[0, -3, -0.5], [0.0, -0.5, -1.0, -1.5, -2.0, -2.5]],
            [[-0.5, -2.5, -0.5], [-0.5, -1.0, -1.5, -2.0]],
            [[-0.5, -2.6, -0.5], [-0.5, -1.0, -1.5, -2.0, -2.5]],
            [[-1.5, 1.5], [-1.5, -0.5, 0.5]],
            [[-1.5, 1.5, 0.5], [-1.5, -1.0, -0.5, 0.0, 0.5, 1.0]],
            [[1.5, -1.5, -1.0], [1.5, 0.5, -0.5]],
            [[1.5, -1.5, -0.5], [1.5, 1.0, 0.5, 0.0, -0.5, -1.0]],
        ];
    }
}
