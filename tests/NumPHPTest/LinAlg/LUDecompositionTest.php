<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LUDecomposition;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class LUDecompositionTest
  * @package NumPHPTest\LinAlg
  */
class LUDecompositionTest extends TestCase
{
    public function testLUDecompositionSquare()
    {
        $numArray = new NumArray(
            [
                [1, 6, 1],
                [2, 3, 2],
                [4, 2, 1],
            ]
        );

        $expectedP = new NumArray(
            [
                [0, 1, 0],
                [0, 0, 1],
                [1, 0, 0],
            ]
        );
        $expectedL = new NumArray(
            [
                [  1,    0, 0],
                [1/4,    1, 0],
                [1/2, 4/11, 1],
            ]
        );
        $expectedU = new NumArray(
            [
                [4,    2,     1],
                [0, 11/2,   3/4],
                [0,    0, 27/22],
            ]
        );
        $result = LUDecomposition::lud($numArray);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals($expectedP, $result['P'], 'Matrix P is not equal');
        $this->assertNumArrayEquals($expectedL, $result['L'], 'Matrix L is not equal');
        $this->assertNumArrayEquals($expectedU, $result['U'], 'Matrix U is not equal');
    }

    public function testLUDecomposition2x4()
    {
        $numArray = new NumArray(
            [
                [4, 2, 1, 8],
                [2, 3, 5, 1],
            ]
        );

        $expectedP = NumPHP::identity(2);
        $expectedL = new NumArray(
            [
                [  1, 0],
                [1/2, 1],
            ]
        );
        $expectedU = new NumArray(
            [
                [4, 2,   1,  8],
                [0, 2, 9/2, -3],
            ]
        );
        $result = LUDecomposition::lud($numArray);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals($expectedP, $result['P'], 'Matrix P is not equal');
        $this->assertNumArrayEquals($expectedL, $result['L'], 'Matrix L is not equal');
        $this->assertNumArrayEquals($expectedU, $result['U'], 'Matrix U is not equal');
    }

    public function testLUDecomposition4x3()
    {
        $array = [
            [5, 1, 3],
            [4, 1, 2],
            [8, 6, 3],
            [2, 8, 5],
        ];

        $expectedP = new NumArray(
            [
                [0, 0, 1, 0],
                [0, 0, 0, 1],
                [1, 0, 0, 0],
                [0, 1, 0, 0],
            ]
        );
        $expectedL = new NumArray(
            [
                [1,        0,     0],
                [1/4,      1,     0],
                [5/8, -11/26,     1],
                [1/2,  -4/13, 47/76],
            ]
        );
        $expectedU = new NumArray(
            [
                [8,    6,     3],
                [0, 13/2,  17/4],
                [0,    0, 38/13],
            ]
        );
        $result = LUDecomposition::lud($array);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals($expectedP, $result['P'], 'Matrix P is not equal');
        $this->assertNumArrayEquals($expectedL, $result['L'], 'Matrix L is not equal');
        $this->assertNumArrayEquals($expectedU, $result['U'], 'Matrix U is not equal');
    }

    /**
     * @expectedException \NumPHP\LinAlg\Exception\InvalidArgumentException
     * @expectedExceptionMessage NumArray with dimension 1 given, NumArray should have 2 dimensions
     */
    public function testLUDecompositionVector()
    {
        $numArray = NumPHP::arange(1, 2);

        LUDecomposition::lud($numArray);
    }

    public function testLUDecompositionCache()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        LUDecomposition::lud($numArray);
        $expectedResult = $numArray->getCache(LUDecomposition::CACHE_KEY_LU_DECOMPOSITION);
        $this->assertSame($expectedResult, LUDecomposition::lud($numArray));
    }
}
