<?php
/**
 * NumPHP (http://numphp.org/)
 *
 * @link https://github.com/GordonLesti/NumPHP for the canonical source repository
 * @copyright Copyright (c) 2014 Gordon Lesti (https://gordonlesti.com/)
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
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
     * @var array|mixed
     */
    protected $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->shape = Shape::getShape($data);
    }

    public function __toString()
    {
        return String::toString($this->data);
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
        return Get::getSubArray($this->data, $args);
    }

    /**
     * @return array|mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int|void
     */
    public function getNDim()
    {
        return count($this->shape);
    }
}
