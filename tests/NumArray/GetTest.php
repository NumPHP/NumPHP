<?php
declare(strict_types=1);

namespace NumPHPTest\NumArray;

use NumPHP\NumArray;
use PHPUnit\Framework\TestCase;

class GetTest extends TestCase
{
    /**
     * @dataProvider get3IntResultProvider
     */
    public function testGet3IntResult(string $arg, int $result)
    {
        $numArray = new NumArray([-8, -3, 6]);
        $this->assertSame($result, $numArray->get($arg));
    }

    public function get3IntResultProvider(): array
    {
        return [
            ['0', -8],
            ['1', -3],
            ['2', 6],
        ];
    }

    /**
     * @dataProvider get3NumArrayResultProvider
     */
    public function testGet3NumArrayResult(string $arg, array $result)
    {
        $numArray = new NumArray([-6, -9, 2]);
        $this->assertTrue($numArray->get($arg)->isEqual(new NumArray($result)));
    }

    public function get3NumArrayResultProvider(): array
    {
        return [
            [':', [-6, -9, 2]],
            ['0:', [-6, -9, 2]],
            ['1:', [-9, 2]],
            ['2:', [2]],
            ['3:', []],
            [':0', []],
            [':1', [-6]],
            [':2', [-6, -9]],
            [':3', [-6, -9, 2]],
            ['0:0', []],
            ['0:1', [-6]],
            ['0:2', [-6, -9]],
            ['0:3', [-6, -9, 2]],
            ['1:1', []],
            ['1:2', [-9]],
            ['1:3', [-9, 2]],
            ['2:2', []],
            ['2:3', [2]],
            ['3:3', []],
        ];
    }

    /**
     * @dataProvider get2x3IntResultProvider
     */
    public function testGet2x3IntResult(string $arg1, string $arg2, int $result)
    {
        $numArray = new NumArray([
            [8, -2, 3],
            [0, 9, -1]
        ]);
        $this->assertSame($result, $numArray->get($arg1, $arg2));
    }

    public function get2x3IntResultProvider(): array
    {
        return [
            ['0', '0', 8],
            ['0', '1', -2],
            ['0', '2', 3],
            ['1', '0', 0],
            ['1', '1', 9],
            ['1', '2', -1],
        ];
    }

    /**
     * @dataProvider get4x5NumArrayResultProvider
     */
    public function testGet4x5NumArrayResult(array $args, array $result)
    {
        $numArray = NumArray::arange(0, 20)->reshape(4, 5)->get(...$args);
        $expected = new NumArray($result);
        $this->assertTrue(
            $numArray->isEqual($expected),
            sprintf("Failed asserting that \n%s\nequals\n%s.", $numArray->__toString(), $expected->__toString())
        );
    }

    public function get4x5NumArrayResultProvider(): array
    {
        return [
            [[':'], NumArray::arange(0, 20)->reshape(4, 5)->getData()],
            [[':', ':'], NumArray::arange(0, 20)->reshape(4, 5)->getData()],
            [[':', ':3'], [[0.0, 1.0, 2.0], [5.0, 6.0, 7.0], [10.0, 11.0, 12.0], [15.0, 16.0, 17.0]]],
            [[':', '2:'], [[2.0, 3.0, 4.0], [7.0, 8.0, 9.0], [12.0, 13.0, 14.0], [17.0, 18.0, 19.0]]],
            [[':', '1:3'], [[1.0, 2.0], [6.0, 7.0], [11.0, 12.0], [16.0, 17.0]]],
            [[':', '4'], [4.0, 9.0, 14.0, 19.0]],
            [['2:'], NumArray::arange(10, 20)->reshape(2, 5)->getData()],
            [['2:', ':'], NumArray::arange(10, 20)->reshape(2, 5)->getData()],
            [['2:', ':3'], [[10.0, 11.0, 12.0], [15.0, 16.0, 17.0]]],
            [['2:', '2:'], [[12.0, 13.0, 14.0], [17.0, 18.0, 19.0]]],
            [['2:', '1:3'], [[11.0, 12.0], [16.0, 17.0]]],
            [['2:', '4'], [14.0, 19.0]],
            [[':2'], NumArray::arange(0, 10)->reshape(2, 5)->getData()],
            [[':2', ':'], NumArray::arange(0, 10)->reshape(2, 5)->getData()],
            [[':2', ':3'], [[0.0, 1.0, 2.0], [5.0, 6.0, 7.0]]],
            [[':2', '2:'], [[2.0, 3.0, 4.0], [7.0, 8.0, 9.0]]],
            [[':2', '1:3'], [[1.0, 2.0],[6.0, 7.0]]],
            [[':2', '4'], [4.0, 9.0]],
            [['1:3'], NumArray::arange(5, 15)->reshape(2, 5)->getData()],
            [['1:3', ':'], NumArray::arange(5, 15)->reshape(2, 5)->getData()],
            [['1:3', ':3'], [[5.0, 6.0, 7.0], [10.0, 11.0, 12.0]]],
            [['1:3', '2:'], [[7.0, 8.0, 9.0], [12.0, 13.0, 14.0]]],
            [['1:3', '1:3'], [[6.0, 7.0], [11.0, 12.0]]],
            [['1:3', '4'], [9.0, 14.0]],
            [['2'], NumArray::arange(10, 15)->getData()],
            [['2', ':'], NumArray::arange(10, 15)->getData()],
            [['2', ':3'], [10.0, 11.0, 12.0]],
            [['2', '2:'], [12.0, 13.0, 14.0]],
            [['2', '1:3'], [11.0, 12.0]],
        ];
    }
}
