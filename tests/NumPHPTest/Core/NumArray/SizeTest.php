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

/**
 * Class SizeTest
 * @package NumPHPTest\Core\NumArray
 */
class SizeTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSize()
    {
        $numArray = new NumArray(1);
        $this->assertEquals(1, $numArray->getSize());
    }

    public function testGetSize1()
    {
        $numArray = new NumArray([1]);
        $this->assertEquals(1, $numArray->getSize());
    }

    public function testGetSize2()
    {
        $numArray = new NumArray([1, 2]);
        $this->assertEquals(2, $numArray->getSize());
    }

    public function testGetSize2x3()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
        $this->assertEquals(6, $numArray->getSize());
    }

    public function getSize2x3x4()
    {
        $numArray = new NumArray(
            [
                [
                    [1, 2, 3, 4],
                    [5, 6, 7, 8],
                    [9, 10, 11, 12],
                ],
                [
                    [13, 14, 15, 16],
                    [17, 18, 19, 20],
                    [21, 22, 23, 24],
                ]
            ]
        );
        $this->assertEquals(24, $numArray->getSize());
    }
}
