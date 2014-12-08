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

/**
 * Class AddTest
  * @package NumPHPTest\Core\NumArray
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
  */
class AddTest extends \PHPUnit_Framework_TestCase
{
    public function testAddSingle()
    {
        $numArray1 = new NumArray(3);
        $numArray2 = new NumArray(-7);

        $expectedNumArray = new NumArray(-4);
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddSingleVector()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = new NumArray(3);

        $expectedNumArray = NumPHP::arange(4, 8);
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddTwoVector()
    {
        $numArray1 = NumPHP::arange(1, 4);
        $numArray2 = NumPHP::arange(-19, -10, 3);

        $expectedNumArray = NumPHP::arange(-18, -6, 4);
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddMatrixSingel()
    {
        $numArray1 = new NumArray(56);
        $numArray2 = NumPHP::arange(1, 9)->reshape(3, 3);

        $expectedNumArray = NumPHP::arange(57, 65)->reshape(3, 3);
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddVectorMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(1, 3);

        $expectedNumArray = new NumArray(
            [
                [2, 3, 4, 5],
                [7, 8, 9, 10],
                [12, 13, 14, 15],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddMatrixMatrix()
    {
        $numArray1 = NumPHP::arange(1, 12)->reshape(3, 4);
        $numArray2 = NumPHP::arange(-5, 6)->reshape(3, 4);

        $expectedNumArray = NumPHP::arange(-4, 18, 2)->reshape(3, 4);
        $this->assertEquals($expectedNumArray, $numArray1->add($numArray2));
    }

    public function testAddVectorArray()
    {
        $numArray = NumPHP::arange(1, 7);
        $array = [4, 5, 6, 7, 8, 9, 10];

        $expectedNumArray = NumPHP::arange(5, 17, 2);
        $this->assertEquals($expectedNumArray, $numArray->add($array));
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Shape 5 is different from 4
     */
    public function testAddDifferentShape()
    {
        $numArray1 = NumPHP::arange(1, 5);
        $numArray2 = NumPHP::arange(1, 4);

        $numArray1->add($numArray2);
    }

    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Operation numphp is not allowed
     */
    public function testAddUnknownOperation()
    {
        NumArray\Add::addArray([1], [1], 'numphp');
    }

    public function testMinusSingle()
    {
        $numArray1 = new NumArray(-6);
        $numArray2 = new NumArray(45);

        $expectedNumArray = new NumArray(-51);
        $this->assertEquals($expectedNumArray, $numArray1->minus($numArray2));
    }

    public function testMinusVectorSingle()
    {
        $numArray1 = new NumArray(45);
        $numArray2 = NumPHP::arange(3, 8);

        $expectedNumArray = NumPHP::arange(42, 37);
        $this->assertEquals($expectedNumArray, $numArray1->minus($numArray2));
    }
}
