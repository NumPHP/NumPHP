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

/**
 * Class StringTest
 * @package NumPHPTest\Core\NumArray
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $numArray = new NumArray(1);
        $this->expectOutputString("1");
        echo $numArray;
    }

    public function testToString2()
    {
        $numArray = new NumArray([1, 2]);
        $this->expectOutputString("(\n  1,\n  2\n)");
        echo $numArray;
    }

    public function testToString3x4()
    {
        $numArray = new NumArray(
            [
                [1, 2, 3, 4],
                [5, 6, 7, 8],
                [9, 10, 11, 12],
            ]
        );
        $expectedOutput = "(\n  (\n    1,\n    2,\n    3,\n    4\n  ),\n  (\n    5,\n    6,\n    7,\n    8\n  ),\n  (".
            "\n    9,\n    10,\n    11,\n    12\n  )\n)";
        $this->expectOutputString($expectedOutput);
        echo $numArray;
    }
}
