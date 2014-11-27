<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray\Helper;

/**
 * Class HelperTest
 * @package NumPHPTest\Core\NumArray
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Array contains non numeric values
     */
    public function testMultiplyInvalidArgumentException()
    {
        Helper::multiply([1, 2, 'k']);
    }

    public function testMultiply()
    {
        $this->assertSame(840, Helper::multiply([5, 7, '24']));
    }

    public function testMultiplyEmpty()
    {
        $this->assertSame(1, Helper::multiply([]));
    }
}
