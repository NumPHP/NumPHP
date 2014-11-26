<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/25/14
 * Time: 1:43 PM
 */

namespace NumPHP\Core;

use NumPHP\Core\NumArray\Get;
use NumPHP\Core\NumArray\Shape;
use NumPHP\Core\NumArray\String;

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
     * @var array
     */
    protected $array;

    /**
     * @param $array
     */
    public function __construct($array)
    {
        $this->array = $array;
        $this->shape = Shape::getShape($array);
    }

    public function __toString()
    {
        return String::toString($this->array);
    }

    /**
     * @return array
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        $size = 1;
        foreach ($this->getShape() as $fac) {
            $size *= $fac;
        }
        return $size;
    }

    /**
     * @return mixed|NumArray
     */
    public function get()
    {
        $args = func_get_args();
        return Get::getSubArray($this->array, $args);
    }
}
