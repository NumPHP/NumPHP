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
use NumPHP\Core\NumArray\Get;
use NumPHP\Core\NumArray\Helper;
use NumPHP\Core\NumArray\Set;
use NumPHP\Core\NumArray\Shape;
use NumPHP\Core\NumArray\String;
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
     * @return mixed|NumArray
     */
    public function get()
    {
        $args = func_get_args();
        return Get::getSubArray($this->data, $args);
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
