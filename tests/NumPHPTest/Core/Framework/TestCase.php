<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHPTest\Core\Framework
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\Core\Framework;

use NumPHP\Core\NumArray;
use NumPHPTest\Core\Framework\Constraint\NumArrayEqual;

/**
 * Class TestCase
 *
 * @category Core
 * @package  NumPHPTest\Core\Framework
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Evaluates if two NumArrays are equal
     *
     * @param NumArray $expected expected NumArray
     * @param NumArray $actual   actual NumArray
     * @param string   $message  message when failing
     *
     * @return void
     */
    public static function assertNumArrayEquals(
        NumArray $expected,
        NumArray $actual,
        $message = ''
    ) {
        $constraint = new NumArrayEqual($expected);

        self::assertThat($actual, $constraint, $message);
    }
}
