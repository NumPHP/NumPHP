<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\BadMethodCallException;
use NumPHP\Core\Exception\DivideByZeroException;
use NumPHP\Core\Exception\InvalidArgumentException;
use NumPHP\Core\Exception\MissingArgumentException;
use NumPHP\Core\NumArray\Create;
use NumPHP\Core\NumArray\Dot;
use NumPHP\Core\NumArray\Get;
use NumPHP\Core\NumArray\Map;
use NumPHP\Core\NumArray\Reduce;
use NumPHP\Core\NumArray\Set;
use NumPHP\Core\NumArray\String;
use NumPHP\Core\NumArray\Transpose;

/**
 * Class NumArray
 *
 * @package   NumPHP\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @api
 * @since     1.0.0
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
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
     *
     * @api
     * @since 1.0.0
     */
    public function __construct($data)
    {
        $result = Create::reshapeData($data);
        $this->data = $result[0];
        $this->shape = $result[1];
    }

    /**
     * Returns a string representing the NumArray
     *
     * @return string
     *
     * @api
     * @since 1.0.0
     */
    public function __toString()
    {
        return "NumArray(".String::toString($this->data).")\n";
    }

    /**
     * Returns the dimensions of the NumArray
     *
     * @return array
     *
     * @api
     * @since 1.0.0
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * Returns the number of elements the NumArray
     *
     * @return int
     *
     * @api
     * @since 1.0.0
     */
    public function getSize()
    {
        return array_product($this->getShape());
    }

    /**
     * Returns a sliced part the NumArray
     *
     * @param string|int|float $slice,... exact indices or slices like `:`, `1:8`, `3:`
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
     */
    public function get()
    {
        $args = func_get_args();

        return new NumArray(Get::getSubArray($this->data, $args));
    }

    /**
     * Replaces a value or complete parts in the NumArray. The new value is always the last argument
     *
     * @param string|int|float $slice,... exact indices or slices like `:`, `1:8`, `3:`
     * @param mixed            $subArray  given value or NumArray
     *
     * @return $this
     *
     * @api
     * @since 1.0.0
     */
    public function set()
    {
        $args = func_get_args();
        if (!count($args)) {
            throw new MissingArgumentException("No arguments given");
        }
        $subArray = array_pop($args);
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
     *
     * @api
     * @since 1.0.0
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the number of axis (dimensions) the NumArray
     *
     * @return int
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
     */
    public function add($addend)
    {
        return $this->map(
            $addend,
            function ($value1, $value2) {
                return $value1 + $value2;
            }
        );
    }

    /**
     * Subtracts an array, NumArray or numeric value from the existing NumArray
     *
     * @param mixed $subtrahend an other int, float, array or NumArray
     *
     * @return $this
     *
     * @api
     * @since 1.0.0
     */
    public function sub($subtrahend)
    {
        return $this->map(
            $subtrahend,
            function ($data1, $data2) {
                return $data1 - $data2;
            }
        );
    }

    /**
     * Multiplies the NumArray with a factor
     *
     * @param mixed $factor factor
     *
     * @return $this
     *
     * @api
     * @since 1.0.4
     */
    public function mult($factor)
    {
        return $this->map(
            $factor,
            function ($data1, $data2) {
                return $data1 * $data2;
            }
        );
    }

    /**
     * Divides the NumArray with a divisor
     *
     * @param mixed $divisor divisor
     *
     * @return $this
     *
     * @throws DivideByZeroException will be thrown, when dividing by zero
     *
     * @api
     * @since 1.0.4
     */
    public function div($divisor)
    {
        return $this->map(
            $divisor,
            function ($data1, $data2) {
                if ($data2) {
                    return $data1 / $data2;
                }
                throw new DivideByZeroException("Dividing by zero is forbidden");
            }
        );
    }

    /**
     * Summed all elements of an NumArray for the given axis
     *
     * @param int $axis given axis of sum
     *
     * @return NumArray
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
     */
    public function abs()
    {
        if (is_array($this->data)) {
            $this->data = array_map('abs', $this->data);
        } else {
            $this->data = abs($this->data);
        }
        $this->flushCache();

        return $this;
    }

    /**
     * Multiplies an array, NumArray or numeric value to the existing NumArray
     *
     * @param mixed $factor an other int, float, array or NumArray
     *
     * @return $this
     *
     * @api
     * @since 1.0.0
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
     *
     * @api
     * @since 1.0.0
     */
    public function getTranspose()
    {
        if ($this->inCache(Transpose::CACHE_KEY_TRANSPOSE)) {
            return $this->getCache(Transpose::CACHE_KEY_TRANSPOSE);
        }
        $transpose = new NumArray(5);
        $transpose->data = Transpose::getTranspose($this->data, $this->shape);
        $transpose->shape = array_reverse($this->shape);

        $this->setCache(Transpose::CACHE_KEY_TRANSPOSE, $transpose);

        return $this->getTranspose();
    }

    /**
     * Reshapes the NumArray
     *
     * @return NumArray
     *
     * @throws BadMethodCallException   will be thrown, if NumArray is only a scalar
     * @throws InvalidArgumentException will be thrown, if new shape size differs to old size
     *
     * @api
     * @since 1.0.0
     */
    public function reshape()
    {
        if (!is_array($this->data)) {
            throw new BadMethodCallException('NumArray data is not an array');
        }
        $args = func_get_args();
        if ($args !== $this->shape) {
            if (array_product($args) !== $this->getSize()) {
                throw new InvalidArgumentException("Total size of new array must be unchanged");
            }
            $this->shape = $args;
            $this->flushCache();
        }

        return $this;
    }

    public function map($array, $callback)
    {
        if (!$array instanceof NumArray) {
            $array = new NumArray($array);
        }
        $newShape = [];
        if (count($this->shape)) {
            // first NuMArray is an Array
            if (!count($array->shape)) {
                // second NumArray is a scalar
                $data2 = $array->data;
                $newData = array_map(
                    function ($value) use ($callback, $data2) {
                        return $callback($value, $data2);
                    },
                    $this->data
                );
                $newShape = $this->shape;
            } elseif ($this->shape === $array->shape) {
                // both are array and have the same shape
                $newData = array_map($callback, $this->data, $array->getData());
                $newShape = $this->shape;
            } else {
                $revShape1 = array_reverse($this->shape);
                $revShape2 = array_reverse($array->shape);
                if (!count(array_diff_assoc($revShape1, $revShape2))) {
                    $div = array_product($revShape1);
                    $chunk = array_chunk($array->data, $div);
                    $data1 = $this->data;
                    $chunk = array_map(
                        function ($value) use ($callback, $data1) {
                            return array_map($callback, $value, $data1);
                        },
                        $chunk
                    );
                    $newData = call_user_func_array('array_merge', $chunk);
                    $newShape = $array->shape;
                } elseif (!count(array_diff_assoc($revShape2, $revShape1))) {
                    $div = array_product($revShape2);
                    $chunk = array_chunk($this->data, $div);
                    $data2 = $array->data;
                    $chunk = array_map(
                        function ($value) use ($callback, $data2) {
                            return array_map($callback, $value, $data2);
                        },
                        $chunk
                    );
                    $newData = call_user_func_array('array_merge', $chunk);
                    $newShape = $this->shape;
                } else {
                    throw new InvalidArgumentException(
                        sprintf(
                            "Shape (%s) is not align with shape (%s)",
                            implode(', ', $this->shape),
                            implode(', ', $array->shape)
                        )
                    );
                }
            }
        } elseif (count($array->shape)) {
            // first NumArray is scalar and second NumArray is an array
            $data1 = $this->data;
            $newData = array_map(
                function ($value) use ($callback, $data1) {
                    return $callback($data1, $value);
                },
                $array->data
            );
            $newShape = $array->shape;
        } else {
            // both a scalar
            $newData = $callback($this->data, $array->data);
        }

        $newNum = new NumArray(0);
        $newNum->data = $newData;
        $newNum->shape = $newShape;

        return $newNum;
    }
}
