<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPBenchmark\Core;

use Athletic\AthleticEvent;

/**
 * Class NumArray
 *
 * @package   NumPHPBenchmark\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.1.0
 */
class NumArray extends AthleticEvent
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var \NumPHP\Core\NumArray
     */
    protected $matrix1;

    /**
     * @var \NumPHP\Core\NumArray
     */
    protected $matrix2;

    public function classSetUp()
    {
        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data[] = range(1, 1000);
        }
        $this->data = $data;
        $this->matrix1 = new \NumPHP\Core\NumArray($data);
        $this->matrix2 = new \NumPHP\Core\NumArray($data);
    }

    public function setUp()
    {
        $this->matrix1->flushCache();
        $this->matrix2->flushCache();
    }

    /**
     * @iterations 10
     */
    public function construct()
    {
        $numArray = new \NumPHP\Core\NumArray($this->data);
    }

    /**
     * @iterations 10
     */
    public function toString()
    {
        $toString = $this->matrix1->__toString();
    }

    /**
     * @iterations 10
     */
    public function getShape()
    {
        $shape = $this->matrix1->getShape();
    }

    /**
     * @iterations 10
     */
    public function getSize()
    {
        $size = $this->matrix1->getSize();
    }

    /**
     * @iterations 10
     */
    public function getData()
    {
        $data = $this->matrix1->getData();
    }

    /**
     * @iterations 10
     */
    public function getNDim()
    {
        $nDim = $this->matrix1->getData();
    }

    /**
     * @iterations 10
     */
    public function add()
    {
        $sum = $this->matrix1->add($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function sub()
    {
        $sub = $this->matrix1->sub($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function div()
    {
        $div = $this->matrix1->div($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function mult()
    {
        $prod = $this->matrix1->mult($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function getTranspose()
    {
        $transpose = $this->matrix1->getTranspose();
    }
}
