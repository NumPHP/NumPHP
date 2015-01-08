<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray\Helper;

/**
 * Class HelperTest
 *
 * @category Core
 * @package  NumPHPTest\Core\NumArray
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if InvalidArgumentException will be thrown when Helper::multiply is
     * called with not numeric values
     *
     * @expectedException        \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Array contains non numeric values
     *
     * @return void
     */
    public function testMultiplyInvalidArgumentException()
    {
        Helper::multiply([1, 2, 'k']);
    }

    /**
     * Tests Helper::multiply with filled array
     *
     * @return void
     */
    public function testMultiply()
    {
        $this->assertSame(840, Helper::multiply([5, 7, '24']));
    }

    /**
     * Tests Helper::multiply with empty array
     *
     * @return void
     */
    public function testMultiplyEmpty()
    {
        $this->assertSame(1, Helper::multiply([]));
    }
}
