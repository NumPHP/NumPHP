<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPTest\Core\Framework\Constraint;

use NumPHP\Core\NumArray;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

/**
 * Class NumArrayEqual
 *
 * @package   NumPHPTest\Core\Framework\Constraint
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class NumArrayEqual extends \PHPUnit_Framework_Constraint
{
    /**
     * Expected NumArray
     *
     * @var mixed NumArray
     */
    protected $value;

    /**
     * Creates NumArrayEqual
     *
     * @param \NumPHP\Core\NumArray $value expected NumArray
     *
     * @since 1.0.0
     */
    public function __construct(NumArray $value)
    {
        parent::__construct();

        $this->value = clone $value;
        // flush the cache
        $this->value->flushCache();
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * @param mixed  $other        Value or object to evaluate.
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @return bool
     *
     * @throws \NumPHP\Core\Exception\CacheKeyException
     *
     * @see \PHPUnit_Framework_Constraint::evaluate
     * @since 1.0.0
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $otherClone = clone $other;
        if ($otherClone instanceof NumArray) {
            // flush the cache
            $otherClone->flushCache();
        }

        $comparatorFactory = new Factory();

        try {
            $comparator = $comparatorFactory->getComparatorFor(
                $this->value,
                $otherClone
            );

            $comparator->assertEquals(
                $this->value,
                $otherClone
            );
        } catch (ComparisonFailure $f) {
            if ($returnResult) {
                return false;
            }

            throw new \PHPUnit_Framework_ExpectationFailedException(
                trim($description . "\n" .$f->getMessage()),
                $f
            );
        }

        return true;
    }

    /**
     * Returns a string representation of the object.
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function toString()
    {
        return sprintf('is equal to %s', $this->exporter->export($this->value));
    }
}
