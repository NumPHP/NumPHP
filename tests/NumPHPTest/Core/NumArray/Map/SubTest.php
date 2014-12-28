<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray\Map;

use NumPHP\Core\NumPHP;
use NumPHPTest\Core\Framework\TestCase;
use NumPHP\Core\NumArray;

/**
 * Class SubTest
  * @package NumPHPTest\Core\NumArray\Map
  */
class SubTest extends TestCase
{
    public function testMinusSingle()
    {
        $numArray1 = new NumArray(-6);
        $numArray2 = new NumArray(45);

        $expectedNumArray = new NumArray(-51);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->sub($numArray2));
    }

    public function testMinusVectorSingle()
    {
        $numArray1 = new NumArray(45);
        $numArray2 = NumPHP::arange(3, 8);

        $expectedNumArray = NumPHP::arange(42, 37);
        $this->assertNumArrayEquals($expectedNumArray, $numArray1->sub($numArray2));
    }

    public function testMinusCache()
    {
        $numArray = new NumArray(5);
        $numArray->setCache('key', 7);

        $numArray->sub(3);
        $this->assertFalse($numArray->inCache('key'));
    }
}
