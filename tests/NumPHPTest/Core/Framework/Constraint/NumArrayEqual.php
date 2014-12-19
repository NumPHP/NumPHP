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
use SebastianBergmann\Comparator\Factory;

/**
 * Class NumArrayEqual
  * @package NumPHPTest\Core\Framework\Constraint
  */
class NumArrayEqual extends \PHPUnit_Framework_Constraint
{
    /**
     * @var NumArray
     */
    protected $value;

    /**
     * @param \NumPHP\Core\NumArray $value
     */
    public function __construct(NumArray $value)
    {
        parent::__construct();

        $this->value = clone $value;
        $this->value->flushCache();
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
     */
    public function toString()
    {
        return sprintf('is equal to %s', $this->exporter->export($this->value));
    }
}
