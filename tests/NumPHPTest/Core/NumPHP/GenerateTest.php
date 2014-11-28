<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumPHP;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class GenerateTest
 * @package NumPHPTest\Core\NumPHP
 */
class GenerateTest extends \PHPUnit_Framework_TestCase
{
    public function testOnes()
    {
        $this->assertEquals(new NumArray(1), NumPHP::ones());
    }

    public function testRand3()
    {
        $rand = NumPHP::rand(3);
        $this->assertInstanceOf('\NumPHP\Core\NumArray', $rand);
        $this->assertSame([3], $rand->getShape());
        $randData = $rand->getData();
        $this->assertCount(3, $randData);
        foreach ($randData as $entry) {
            $this->assertInternalType('float', $entry);
        }
    }

    public function testOnes3x2()
    {
        $expectedNumArray = new NumArray(
            [
                [1, 1],
                [1, 1],
                [1, 1],
            ]
        );
        print_r($expectedNumArray->getData());
        $this->assertEquals($expectedNumArray, NumPHP::ones(3, 2));
    }

    public function testZeros2x3x5()
    {
        $expectedNumArray = new NumArray(
            [
                [
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                ],
                [
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                    [0, 0, 0, 0, 0],
                ],
            ]
        );
        $this->assertEquals($expectedNumArray, NumPHP::zeros(2, 3, 5));
    }

    public function testZerosLike()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
        $expectedNumArray = NumPHP::zeros(2, 3);
        $this->assertEquals($expectedNumArray, NumPHP::zerosLike($numArray));
    }

    public function testOnesLike()
    {
        $numArray = new NumArray(
            [
                [1, 1],
                [1, 1],
                [1, 1],
            ]
        );
        $expectedNumArray = NumPHP::ones(3, 2);
        $this->assertEquals($expectedNumArray, NumPHP::onesLike($numArray));
    }

    public function testRandLike()
    {
        $numArray = new NumArray([1, 2, 3]);
        $rand = NumPHP::randLike($numArray);
        $this->assertInstanceOf('\NumPHP\Core\NumArray', $rand);
        $this->assertSame([3], $rand->getShape());
        $randData = $rand->getData();
        $this->assertCount(3, $randData);
        foreach ($randData as $entry) {
            $this->assertInternalType('float', $entry);
        }
    }
}
