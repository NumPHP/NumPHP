<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\Framework;

use NumPHP\Core\NumArray;
use NumPHPTest\Core\Framework\Constraint\NumArrayEqual;

/**
 * Class TestCase
 *
 * @package   NumPHPTest\Core\Framework
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
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
     * @since 1.0.0
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
