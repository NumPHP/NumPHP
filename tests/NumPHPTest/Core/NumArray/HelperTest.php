<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\NumArray;

use NumPHP\Core\NumArray\Helper;

/**
 * Class HelperTest
 *
 * @package   NumPHPTest\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Helper::prepareIndexArgument
     */
    public function testPrepareIndexArgument()
    {
        $this->markTestIncomplete("This test has not been implemented yet.");
    }

    /**
     * Tests Helper::getIndexesFromPosition
     */
    public function testGetIndexesFromPosition()
    {
        $shape = [3, 5, 7, 9];

        $expectedIndexes = [2, 3, 4, 5];
        $this->assertSame($expectedIndexes, Helper::getIndexesFromPosition(860, $shape));
    }

    /**
     * Tests Helper::getPositionFromIndexes
     */
    public function testGetPositionFromIndexes()
    {
        $indexes = [2, 3, 4, 5];
        $factors = [315, 63, 9, 1];

        $this->assertSame(860, Helper::getPositionFromIndexes($indexes, $factors));
    }

    /**
     * Tests Helper::getFactorsFromShapeEmpty
     */
    public function testGetFactorsFromShape()
    {
        $shape = [3, 5, 7, 9];

        $expectedFactors = [315, 63, 9, 1];
        $this->assertSame($expectedFactors, Helper::getFactorsFromShape($shape));
    }

    /**
     * Tests Helper::getFactorsFromShapeEmpty with empty shape
     */
    public function testGetFactorsFromShapeEmpty()
    {
        $shape = [];

        $expectedFactors = [];
        $this->assertSame($expectedFactors, Helper::getFactorsFromShape($shape));
    }
}
