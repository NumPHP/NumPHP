<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHPTest\Core\Framework\Constraint;

use NumPHP\Core\NumArray;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\ObjectComparator;

/**
 * Class NumArrayEqual
  * @package NumPHPTest\Core\Framework\Constraint
  */
class NumArrayEqual extends \PHPUnit_Framework_Constraint_IsEqual
{
    /**
     * @param \NumPHP\Core\NumArray $value
     */
    public function __construct(NumArray $value)
    {
        $valueClone = clone $value;
        $valueClone->flushCache();
        parent::__construct($valueClone);
    }

    /**
     * @param NumArray $other
     * @param string $description
     * @param bool $returnResult
     * @return mixed
     */
    public function evaluate(NumArray $other, $description = '', $returnResult = false)
    {
        $otherClone = clone $other;
        // flush the cache
        $otherClone->flushCache();

        return parent::evaluate($otherClone, $description, $returnResult);
    }
}
