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
 * Class EyeTest
  * @package NumPHPTest\Core\NumPHP
  */
class EyeTest extends \PHPUnit_Framework_TestCase
{
    public function testEye1()
    {
        $numArray = NumPHP::eye(1);

        $expectedNumArray = NumPHP::ones(1, 1);
        $this->assertEquals($expectedNumArray, $numArray);
    }

    public function testEye4()
    {
        $numArray = NumPHP::eye(4);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0, 0],
                [0, 1, 0, 0],
                [0, 0, 1, 0],
                [0, 0, 0, 1],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray);
    }

    public function testEye2x3()
    {
        $numArray = NumPHP::eye(2, 3);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0],
                [0, 1, 0],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray);
    }

    public function testEye4x3()
    {
        $numArray = NumPHP::eye(4, 3);

        $expectedNumArray = new NumArray(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
                [0, 0, 0],
            ]
        );
        $this->assertEquals($expectedNumArray, $numArray);
    }

    public function testIdentity()
    {
        $numArray = NumPHP::identity(3);

        $expectedNumArray = NumPHP::eye(3, 3);
        $this->assertEquals($expectedNumArray, $numArray);
    }
}
