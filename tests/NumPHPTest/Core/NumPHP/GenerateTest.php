<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\NumPHP
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\NumPHP;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class GenerateTest
 *
 * @category Core
 * @package  NumPHPTest\Core\NumPHP
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class GenerateTest extends TestCase
{
    /**
     * Tests NumPHP::ones without arguments
     *
     * @return void
     */
    public function testOnes()
    {
        $this->assertNumArrayEquals(new NumArray(1), NumPHP::ones());
    }

    /**
     * Tests NumPHP::rand
     *
     * @return void
     */
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

    /**
     * Tests NumPHP::ones with arguments 3, 2
     *
     * @return void
     */
    public function testOnes3x2()
    {
        $expectedNumArray = new NumArray(
            [
                [1, 1],
                [1, 1],
                [1, 1],
            ]
        );
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::ones(3, 2));
    }

    /**
     * Tests NumPHP::zeros with arguments 2, 3, 5
     *
     * @return void
     */
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
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::zeros(2, 3, 5));
    }

    /**
     * Tests NumPHP::zerosLike with 2x3 matrix
     *
     * @return void
     */
    public function testZerosLike()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
        $expectedNumArray = NumPHP::zeros(2, 3);
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::zerosLike($numArray));
    }

    /**
     * Tests NumPHP::onesLike with 3x2 matrix
     *
     * @return void
     */
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
        $this->assertNumArrayEquals($expectedNumArray, NumPHP::onesLike($numArray));
    }

    /**
     * Tests NumPHP::randLike with vector
     *
     * @return void
     */
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
