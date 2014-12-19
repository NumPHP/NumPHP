<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\Framework;
use NumPHP\Core\NumArray;
use NumPHPTest\Core\Framework\Constraint\NumArrayEqual;

/**
 * Class TestCase
  * @package NumPHPTest\Core\Framework
  */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param NumArray $expected
     * @param NumArray $actual
     * @param string $message
     */
    public static function assertNumArrayEquals(NumArray $expected, NumArray $actual, $message = '')
    {
        $constraint = new NumArrayEqual($expected);

        self::assertThat($actual, $constraint, $message);
    }
}
