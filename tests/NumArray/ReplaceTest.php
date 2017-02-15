<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\Exception\InvalidArgumentException;
use NumPHP\Exception\OutOfBoundsException;
use NumPHP\NumArray;
use NumPHPTest\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ReplaceTest extends TestCase
{
    /**
     * @dataProvider replace3Provider
     */
    public function testReplace3(array $args, array $result)
    {
        $numArray = new NumArray([2, -4, -5]);
        $this->assertNumArrayEquals(new NumArray($result), $numArray->replace(...$args));
    }

    public function replace3Provider(): array
    {
        return [
            [[-8, '-3'], [-8, -4, -5]],
            [[7, '-2'], [2, 7, -5]],
            [[3, '-1'], [2, -4, 3]],
            [[-3, '0'], [-3, -4, -5]],
            [[-2, '1'], [2, -2, -5]],
            [[-3, '2'], [2, -4, -3]],
        ];
    }

    public function testReplace3IndexMinus4()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Index -4 out of bounds');
        NumArray::arange(0, 3)->replace(3, '-4');
    }

    public function testReplace3Index3()
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage('Index 3 out of bounds');
        NumArray::arange(0, 3)->replace(5, '3');
    }

    public function testReplaceNoIndex()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Argument $data is not type of NumArray');
        NumArray::arange(0, 3)->replace(5);
    }

    /**
     * @dataProvider replace3SliceProvider
     */
    public function testReplace3Slice(array $args, array $result)
    {
        $args[0] = new NumArray($args[0]);
        $numArray = (new NumArray([-3, 6, 4]))->replace(...$args);
        $this->assertNumArrayEquals(new NumArray($result), $numArray);
    }

    public function replace3SliceProvider(): array
    {
        return [
            [[[6, 8, 0], ':'], [6, 8, 0]],
            [[[1, 8, -8], '-4:'], [1, 8, -8]],
            [[[8, -1, 9], '-3:'], [8, -1, 9]],
            [[[-6, -5], '-2:'], [-3, -6, -5]],
            [[[3], '-1:'], [-3, 6, 3]],
            [[[0, 8, -7], '0:'], [0, 8, -7]],
            [[[-8, 3], '1:'], [-3, -8, 3]],
            [[[0], '2:'], [-3, 6, 0]],
            [[[], '3:'], [-3, 6, 4]],
            [[[], '4:'], [-3, 6, 4]],
            [[[], ':-4'], [-3, 6, 4]],
            [[[], ':-3'], [-3, 6, 4]],
            [[[0], ':-2'], [0, 6, 4]],
            [[[0, -8], ':-1'], [0, -8, 4]],
            [[[], ':0'], [-3, 6, 4]],
            [[[7], ':1'], [7, 6, 4]],
            [[[5, 8], ':2'], [5, 8, 4]],
            [[[-4, -1, 7], ':3'], [-4, -1, 7]],
            [[[-6, 3, -3], ':4'], [-6, 3, -3]],
            [[[], '0:0'], [-3, 6, 4]],
            [[[-4], '0:1'], [-4, 6, 4]],
            [[[3, 1], '0:2'], [3, 1, 4]],
            [[[-2, 6, 6], '0:3'], [-2, 6, 6]],
            [[[], '1:1'], [-3, 6, 4]],
            [[[-7], '1:2'], [-3, -7, 4]],
            [[[-6, 0], '1:3'], [-3, -6, 0]],
            [[[], '2:2'], [-3, 6, 4]],
            [[[3], '2:3'], [-3, 6, 3]],
            [[[], '3:3'], [-3, 6, 4]],
        ];
    }

    /**
     * @dataProvider replace2x3Provider
     */
    public function testReplace2x3(array $args, array $result)
    {
        $numArray = new NumArray([
            [-3, 4, -8],
            [-1, 1, 3]
        ]);
        $this->assertNumArrayEquals(new NumArray($result), $numArray->replace(...$args));
    }

    public function replace2x3Provider(): array
    {
        return [
            [[-8, '0', '0'], [[-8, 4, -8], [-1, 1, 3]]],
            [[8, '0', '1'], [[-3, 8, -8], [-1, 1, 3]]],
            [[4, '0', '2'], [[-3, 4, 4], [-1, 1, 3]]],
            [[9, '1', '0'], [[-3, 4, -8], [9, 1, 3]]],
            [[-4, '1', '1'], [[-3, 4, -8], [-1, -4, 3]]],
            [[5, '1', '2'], [[-3, 4, -8], [-1, 1, 5]]],
        ];
    }

    /**
     * @dataProvider replace4x5Provider
     */
    public function testReplace4x5(array $args, array $result)
    {
        $args[0] = new NumArray($args[0]);
        $numArray = NumArray::arange(0, 20)->reshape(4, 5)->replace(...$args);
        $this->assertNumArrayEquals(new NumArray($result), $numArray);
    }

    /**
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function replace4x5Provider(): array
    {
        return [
            [
                [NumArray::arange(-20, 0)->reshape(4, 5)->getData(), ':'],
                NumArray::arange(-20, 0)->reshape(4, 5)->getData()
            ],
            [
                [NumArray::arange(-20, 0)->reshape(4, 5)->getData(), ':', ':'],
                NumArray::arange(-20, 0)->reshape(4, 5)->getData()
            ],
            [
                [NumArray::arange(-12, 0)->reshape(4, 3)->getData(), ':', ':3'],
                [
                    [-12.0, -11.0, -10.0, 3.0, 4.0],
                    [-9.0, -8.0, -7.0, 8.0, 9.0],
                    [-6.0, -5.0, -4.0, 13.0, 14.0],
                    [-3.0, -2.0, -1.0, 18.0, 19.0]
                ]
            ],
            [
                [NumArray::arange(-12, 0)->reshape(4, 3)->getData(), ':', '2:'],
                [
                    [0.0, 1.0, -12.0, -11.0, -10.0],
                    [5.0, 6.0, -9.0, -8.0, -7.0],
                    [10.0, 11.0, -6.0, -5.0, -4.0],
                    [15.0, 16.0, -3.0, -2.0, -1.0]
                ]
            ],
            [
                [NumArray::arange(-8, 0)->reshape(4, 2)->getData(), ':', '1:3'],
                [
                    [0.0, -8.0, -7.0, 3.0, 4.0],
                    [5.0, -6.0, -5.0, 8.0, 9.0],
                    [10.0, -4.0, -3.0, 13.0, 14.0],
                    [15.0, -2.0, -1.0, 18.0, 19.0]
                ]
            ],
            [
                [NumArray::arange(-4, 0)->getData(), ':', '4'],
                [
                    [0.0, 1.0, 2.0, 3.0, -4.0],
                    [5.0, 6.0, 7.0, 8.0, -3.0],
                    [10.0, 11.0, 12.0, 13.0, -2.0],
                    [15.0, 16.0, 17.0, 18.0, -1.0]
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), '2:'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData()
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), '2:', ':'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData()
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), '2:', ':3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [-6.0, -5.0, -4.0, 13.0, 14.0],
                    [-3.0, -2.0, -1.0, 18.0, 19.0]
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), '2:', '2:'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [10.0, 11.0, -6.0, -5.0, -4.0],
                    [15.0, 16.0, -3.0, -2.0, -1.0]
                ]
            ],
            [
                [NumArray::arange(-4, 0)->reshape(2, 2)->getData(), '2:', '1:3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [10.0, -4.0, -3.0, 13.0, 14.0],
                    [15.0, -2.0, -1.0, 18.0, 19.0]
                ]
            ],
            [
                [NumArray::arange(-2, 0)->getData(), '2:', '4'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [10.0, 11.0, 12.0, 13.0, -2.0],
                    [15.0, 16.0, 17.0, 18.0, -1.0]
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), ':2'],
                [
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), ':2', ':'],
                [
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), ':2', ':3'],
                [
                    [-6.0, -5.0, -4.0, 3.0, 4.0],
                    [-3.0, -2.0, -1.0, 8.0, 9.0],
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), ':2', '2:'],
                [
                    [0.0, 1.0, -6.0, -5.0, -4.0],
                    [5.0, 6.0, -3.0, -2.0, -1.0],
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-4, 0)->reshape(2, 2)->getData(), ':2', '1:3'],
                [
                    [0.0, -4.0, -3.0, 3.0, 4.0],
                    [5.0, -2.0, -1.0, 8.0, 9.0],
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-2, 0)->getData(), ':2', '4'],
                [
                    [0.0, 1.0, 2.0, 3.0, -2.0],
                    [5.0, 6.0, 7.0, 8.0, -1.0],
                    NumArray::arange(10, 15)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), '1:3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-10, 0)->reshape(2, 5)->getData(), '1:3', ':'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(-10, -5)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), '1:3', ':3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    [-6.0, -5.0, -4.0, 8.0, 9.0],
                    [-3.0, -2.0, -1.0, 13.0, 14.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-6, 0)->reshape(2, 3)->getData(), '1:3', '2:'],
                [
                    NumArray::arange(0, 5)->getData(),
                    [5.0, 6.0, -6.0, -5.0, -4.0],
                    [10.0, 11.0, -3.0, -2.0, -1.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-4, 0)->reshape(2, 2)->getData(), '1:3', '1:3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    [5.0, -4.0, -3.0, 8.0, 9.0],
                    [10.0, -2.0, -1.0, 13.0, 14.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-2, 0)->getData(), '1:3', '4'],
                [
                    NumArray::arange(0, 5)->getData(),
                    [5.0, 6.0, 7.0, 8.0, -2.0],
                    [10.0, 11.0, 12.0, 13.0, -1.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-5, 0)->getData(), '2'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-5, 0)->getData(), '2', ':'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    NumArray::arange(-5, 0)->getData(),
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-3, 0)->getData(), '2', ':3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [-3.0, -2.0, -1.0, 13.0, 14.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-3, 0)->getData(), '2', '2:'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [10.0, 11.0, -3.0, -2.0, -1.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
            [
                [NumArray::arange(-2, 0)->getData(), '2', '1:3'],
                [
                    NumArray::arange(0, 5)->getData(),
                    NumArray::arange(5, 10)->getData(),
                    [10.0, -2.0, -1.0, 13.0, 14.0],
                    NumArray::arange(15, 20)->getData(),
                ]
            ],
        ];
    }
}
