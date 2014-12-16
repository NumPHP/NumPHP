<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray\Filter;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;

/**
 * Class Abs
  * @package NumPHPTest\Core\NumArray\Filter
  */
class AbsTest extends \PHPUnit_Framework_TestCase
{
    public function testAbsSingle()
    {
        $numArray = new NumArray(-1);

        $expectedNumArray = new NumArray(1);
        $this->assertEquals($expectedNumArray, $numArray->abs());
    }

    public function testAbsVector()
    {
        $numArray = new NumArray(
            [-4, 6, -89]
        );

        $expectedNumArray = new NumArray(
            [4, 6, 89]
        );
        $this->assertEquals($expectedNumArray, $numArray->abs());
    }

    public function testAbsMatrix()
    {
        $numArray = new NumArray(
            [
                [1, -2, -3],
                [-4, -5, 6],
            ]
        );

        $expectedNumArray = NumPHP::arange(1, 6)->reshape(2, 3);
        $this->assertEquals($expectedNumArray, $numArray->abs());
    }
}
