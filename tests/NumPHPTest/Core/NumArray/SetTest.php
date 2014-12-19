<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class SetTest
 * @package NumPHPTest\Core\NumArray
 */
class SetTest extends TestCase
{
    public function testSetSingleEntry()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [6, 7, 8, 9, 10],
                [11, 12, 13, 9, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->set(9, 2, 3));
    }

    public function testSetSingleNumArray()
    {
        $numArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $expectedNumArray = new NumArray(
            [
                [1, -1, 3],
                [4, 5, 6],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->set(new NumArray(-1), 0, 1));
    }

    public function testSetRow()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [-6, -7, -8, -9, -10],
                [11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->set([-6, -7, -8, -9, -10], 1));
    }

    public function testSetRowNumArray()
    {
        $numArray = NumPHP::arange(1, 20)->reshape(4, 5);
        $expectedNumArray = new NumArray(
            [
                [1, 2, 3, 4, 5],
                [-6, -7, -8, -9, -10],
                [11, 12, 13, 14, 15],
                [16, 17, 18, 19, 20],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, $numArray->set(new NumArray([-6, -7, -8, -9, -10]), 1));
    }
}
