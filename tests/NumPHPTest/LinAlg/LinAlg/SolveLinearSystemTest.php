<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  LinAlg
 * @package   NumPHPTest\LinAlg\LinAlg
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHPTest\LinAlg\LinAlg;

use NumPHP\Core\NumArray;
use NumPHP\Core\NumPHP;
use NumPHP\LinAlg\LinAlg;
use NumPHPTest\Core\Framework\TestCase;

/**
 * Class SolveLinearSystemTest
 *
 * @category LinAlg
 * @package  NumPHPTest\LinAlg\LinAlg
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 */
class SolveLinearSystemTest extends TestCase
{
    /**
     * Tests LinAlg::solve with 3x3 matrix
     *
     * @return void
     */
    public function testSolve()
    {
        $matrix = new NumArray(
            [
                [ 11,  44,  1],
                [0.1, 0.4,  3],
                [  0,   1, -1]
            ]
        );
        $vector = NumPHP::ones(3);

        $expectedNumArray = new NumArray(
            [-1732/329, 438/329, 109/329]
        );
        $this->assertNumArrayEquals(
            $expectedNumArray,
            LinAlg::solve($matrix, $vector)
        );
    }

    /**
     * Tests LinAlg::solve with identity matrix and ones vector as arrays
     *
     * @return void
     */
    public function testSolveArray()
    {
        $matrix = NumPHP::identity(5)->getData();
        $vector = NumPHP::ones(5)->getData();

        $expectedNumArray = NumPHP::ones(5);
        $this->assertNumArrayEquals(
            $expectedNumArray,
            LinAlg::solve($matrix, $vector)
        );
    }

    /**
     * Tests if InvalidArgumentException will be thrown, when using LinAlg::solve
     * with not align matrix and vector
     *
     * @expectedException        \NumPHP\LinAlg\Exception\InvalidArgumentException
     * @expectedExceptionMessage Can not solve a linear system with matrix (4, 4)
     * and vector (3)
     *
     * @return void
     */
    public function testSolveNotAlign()
    {
        $matrix = NumPHP::identity(4);
        $vector = NumPHP::ones(3);

        LinAlg::solve($matrix, $vector);
    }
}
