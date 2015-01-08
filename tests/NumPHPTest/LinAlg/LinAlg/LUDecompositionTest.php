<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  LinAlg
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;
use NumPHP\LinAlg\LinAlg\LUDecomposition;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class LUDecompositionTest
 *
 * @category LinAlg
 * @package  NumPHPTest\LinAlg\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class LUDecompositionTest extends TestCase
{
    /**
     * Tests LinAlg::lud with 3x3 matrix
     *
     * @return void
     */
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
        $result = LinAlg::lud($numArray);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals(
            $expectedP,
            $result['P'],
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $result['L'],
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $result['U'],
            'Matrix U is not equal'
        );
    }

    /**
     * Tests LinAlg::lud with 2x4 matrix
     *
     * @return void
     */
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
        $result = LinAlg::lud($numArray);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals(
            $expectedP,
            $result['P'],
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $result['L'],
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $result['U'],
            'Matrix U is not equal'
        );
    }

    /**
     * Tests LiNAlg::lud with 4x3 matrix
     *
     * @return void
     */
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
        $result = LinAlg::lud($array);
        $this->assertCount(3, $result);
        $this->assertNumArrayEquals(
            $expectedP,
            $result['P'],
            'Matrix P is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedL,
            $result['L'],
            'Matrix L is not equal'
        );
        $this->assertNumArrayEquals(
            $expectedU,
            $result['U'],
            'Matrix U is not equal'
        );
    }

    /**
     * Tests if NoMatrixException will be thrown, when using LinAlg::lud a vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\NoMatrixException
     * @expectedExceptionMessage NumArray with dimension 1 given, NumArray should
     * have 2 dimensions
     *
     * @return void
     */
    public function testLUDecompositionVector()
    {
        $numArray = NumPHP::arange(1, 2);

        LinAlg::lud($numArray);
    }

    /**
     * Tests cache of LinAlg::lud
     *
     * @return void
     */
    public function testLUDecompositionCache()
    {
        $numArray = NumPHP::arange(1, 4)->reshape(2, 2);

        LinAlg::lud($numArray);
        $expectedResult = $numArray->getCache(
            LUDecomposition::CACHE_KEY_LU_DECOMPOSITION
        );
        $this->assertSame($expectedResult, LinAlg::lud($numArray));
    }
}
