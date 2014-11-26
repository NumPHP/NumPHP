<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/25/14
 * Time: 2:08 PM
 */

namespace NumPHPTest\Core;

use NumPHP\Core\NumArray;

/**
 * Class NumArrayTest
 * @package NumPHPTest\Core
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NumArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \NumPHP\Core\Exception\InvalidArgumentException
     * @expectedExceptionMessage Dimensions did not match
     */
    public function testConstructInvalidArgumentException()
    {
        new NumArray([[1], [2, 3]]);
    }
}
