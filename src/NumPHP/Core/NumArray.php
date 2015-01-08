<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * PHP version 5
 *
 * @category  Core
 * @package   NumPHP\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\BadMethodCallException;
use NumPHP\Core\NumArray\Dot;
use NumPHP\Core\NumArray\Filter;
use NumPHP\Core\NumArray\Get;
use NumPHP\Core\NumArray\Helper;
use NumPHP\Core\NumArray\Map;
use NumPHP\Core\NumArray\Reduce;
use NumPHP\Core\NumArray\Set;
use NumPHP\Core\NumArray\Shape;
use NumPHP\Core\NumArray\String;
use NumPHP\Core\NumArray\Transpose;

/**
 * Class NumArray
 *
 * @category Core
 * @package  NumPHP\Core
 * @author   Gordon Lesti <info@gordonlesti.com>
 * @license  http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link     http://numphp.org/
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class NumArray extends Cache
{
    /**
     * The shape of the NumArray
     *
     * @var array
     */
    protected $shape;

    /**
     * The data of the NumArray
     *
     * @var array|mixed
     */
    protected $data;

    /**
     * Creates an new NumArray
     *
     * @param mixed $data given data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->shape = Shape::getShape($data);
    }

    /**
     * Returns a string representing the NumArray
     *
     * @return string
     */
    public function __toString()
    {
        return "NumArray(".String::toString($this->data).")\n";
    }

    /**
     * Returns the dimensions of the NumArray
     *
     * @return array
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Returns the number of elements the NumArray
     *
     * @return int
     */
    public function getSize()
    {
        return Helper::multiply($this->getShape());
    }

    /**
     * Returns a sliced part the NumArray
     *
     * @return NumArray
     */
    public function get()
    {
        $args = func_get_args();

        return new NumArray(Get::getSubArray($this->data, $args));
    }

    /**
     * Replaces a value or complete parts in the NumArray
     *
     * @param mixed      $subArray  given value or NumArray
     * @param string|int $slice,... exact indices or slices like `:`, `1:8`, `3:`
     *
     * @return $this
     */
    public function set($subArray)
    {
        $args = func_get_args();
        array_shift($args);
        if ($subArray instanceof NumArray) {
            $subArray = $subArray->getData();
        }
        $this->data = Set::setSubArray($this->data, $subArray, $args);
        $this->flushCache();

        return $this;
    }

    /**
     * Returns the data of the NumArray
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the number of axis (dimensions) the NumArray
     *
     * @return int
     */
    public function getNDim()
    {
        return count($this->shape);
    }

    /**
     * Adds an array, NumArray or numeric value to the existing NumArray
     *
     * @param mixed $addend an other int, float, array or NumArray
     *
     * @return $this
     */
    public function add($addend)
    {
        if ($addend instanceof NumArray) {
            $addend = $addend->getData();
        }
        $this->data = Map::mapArray(
            $this->data,
            $addend,
            function ($data1, $data2) {
                return $data1 + $data2;
            }
        );
        $this->shape = Shape::getShape($this->data);
        $this->flushCache();

        return $this;
    }

    /**
     * Subtracts an array, NumArray or numeric value from the existing NumArray
     *
     * @param mixed $subtrahend an other int, float, array or NumArray
     *
     * @return $this
     */
    public function sub($subtrahend)
    {
        if ($subtrahend instanceof NumArray) {
            $subtrahend = $subtrahend->getData();
        }
        $this->data = Map::mapArray(
            $this->data,
            $subtrahend,
            function ($data1, $data2) {
                return $data1 - $data2;
            }
        );
        $this->shape = Shape::getShape($this->data);
        $this->flushCache();

        return $this;
    }

    /**
     * Summed all elements of an NumArray for the given axis
     *
     * @param int $axis given axis of sum
     *
     * @return NumArray
     */
    public function sum($axis = null)
    {
        return Reduce::reduceArray(
            $this,
            function ($data1, $data2) {
                return $data1 + $data2;
            },
            $axis
        );
    }

    /**
     * Returns the min of the NumArray for the given axis
     *
     * @param int $axis given axis of min
     *
     * @return NumArray
     */
    public function min($axis = null)
    {
        return Reduce::reduceArray(
            $this,
            function ($data1, $data2) {
                return min($data1, $data2);
            },
            $axis
        );
    }

    /**
     * Returns the max of the NumArray for the given axis
     *
     * @param int $axis given axis of max
     *
     * @return NumArray
     */
    public function max($axis = null)
    {
        return Reduce::reduceArray(
            $this,
            function ($data1, $data2) {
                return max($data1, $data2);
            },
            $axis
        );
    }

    /**
     * Returns the mean of the NumArray for the given axis
     *
     * @param int $axis given axis of mean
     *
     * @return NumArray
     */
    public function mean($axis = null)
    {
        $divisor = $this->getSize();
        if (array_key_exists($axis, $this->shape)) {
            $divisor = $this->shape[$axis];
        }
        return $this->sum($axis)->dot(1/$divisor);
    }

    /**
     * Applies `abs` on every value of the NumArray
     *
     * @return $this
     */
    public function abs()
    {
        $this->data = Filter::filterArray(
            $this->data,
            function ($data) {
                return abs($data);
            }
        );
        $this->flushCache();

        return $this;
    }

    /**
     * Multiplies an array, NumArray or numeric value to the existing NumArray
     *
     * @param mixed $factor an other int, float, array or NumArray
     *
     * @return $this
     */
    public function dot($factor)
    {
        if (!($factor instanceof NumArray)) {
            $factor = new NumArray($factor);
        }
        $result = Dot::dotArray(
            $this->data,
            $this->shape,
            $factor->getData(),
            $factor->getShape()
        );
        $this->data = $result['data'];
        $this->shape = $result['shape'];
        $this->flushCache();

        return $this;
    }

    /**
     * Returns the transposed NumArray
     *
     * @return NumArray
     */
    public function getTranspose()
    {
        if ($this->inCache(Transpose::CACHE_KEY_TRANSPOSE)) {
            return $this->getCache(Transpose::CACHE_KEY_TRANSPOSE);
        }
        $transpose = new NumArray(
            Transpose::getTranspose($this->data, $this->getShape())
        );
        $this->setCache(Transpose::CACHE_KEY_TRANSPOSE, $transpose);

        return $transpose;
    }

    /**
     * Reshapes the NumArray
     *
     * @return NumArray
     * @throws BadMethodCallException
     */
    public function reshape()
    {
        if (!is_array($this->data)) {
            throw new BadMethodCallException('NumArray data is not an array');
        }
        $args = func_get_args();
        $this->data = Shape::reshape($this->data, $this->getShape(), $args);
        $this->shape = $args;

        return $this;
    }
}
