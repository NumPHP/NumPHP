<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link http://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (http://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\BadMethodCallException;
use NumPHP\Core\Exception\InvalidArgumentException;
use NumPHP\Core\NumArray\Dot;
use NumPHP\Core\NumArray\Get;
use NumPHP\Core\NumArray\Helper;
use NumPHP\Core\NumArray\Map;
use NumPHP\Core\NumArray\Reduce;
use NumPHP\Core\NumArray\Set;
use NumPHP\Core\NumArray\Shape;
use NumPHP\Core\NumArray\String;
use NumPHP\Core\NumArray\Sum;
use NumPHP\Core\NumArray\Transpose;

/**
 * Class NumArray
 * @package NumPHP\Core
 */
class NumArray
{
    /**
     * @var array
     */
    protected $shape;

    /**
     * @var array|mixed
     */
    protected $data;

    /**
     * Creates an new NumArray
     *
     * @param $data
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
        return 'NumArray('.String::toString($this->data).')';
    }

    /**
     * Returns the dimensions othe NumArray
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
     * @param $subArray
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

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the number of axis (dimensions) the NumArray
     *
     * @return int|void
     */
    public function getNDim()
    {
        return count($this->shape);
    }

    /**
     * Adds an array, NumArray or numeric value to the existing NumArray
     *
     * @param $addend
     * @return $this
     */
    public function add($addend)
    {
        if ($addend instanceof NumArray) {
            $addend = $addend->getData();
        }
        $this->data = Map::mapArray($this->data, $addend, function ($data1, $data2) {
            return $data1 + $data2;
        });
        $this->shape = Shape::getShape($this->data);

        return $this;
    }

    /**
     * Subtracts an array, NumArray or numeric value from the existing NumArray
     *
     * @param $subtrahend
     * @return $this
     */
    public function minus($subtrahend)
    {
        if ($subtrahend instanceof NumArray) {
            $subtrahend = $subtrahend->getData();
        }
        $this->data = Map::mapArray($this->data, $subtrahend, function ($data1, $data2) {
            return $data1 - $data2;
        });
        $this->shape = Shape::getShape($this->data);

        return $this;
    }

    /**
     * Summed all elements of an NumArray for the given axis
     *
     * @param int $axis
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
     * @param int $axis
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
     * @param int $axis
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
     * @param null $axis
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
     * Multiplies an array, NumArray or numeric value to the existing NumArray
     *
     * @param $factor
     * @return $this
     */
    public function dot($factor)
    {
        if (!($factor instanceof NumArray)) {
            $factor = new NumArray($factor);
        }
        $result = Dot::dotArray($this->data, $this->shape, $factor->getData(), $factor->getShape());
        $this->data = $result['data'];
        $this->shape = $result['shape'];

        return $this;
    }

    /**
     * Returns the transposed NumArray
     *
     * @return NumArray
     */
    public function getTranspose()
    {
        return new NumArray(Transpose::getTranspose($this->data, $this->getShape()));
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
