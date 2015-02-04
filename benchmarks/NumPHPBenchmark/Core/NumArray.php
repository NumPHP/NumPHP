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

    public function tearDown()
    {
        $this->matrix1->flushCache();
        $this->matrix2->flushCache();
    }

    /**
     * @iterations 10
     */
    public function construct()
    {
        new \NumPHP\Core\NumArray($this->data);
    }

    /**
     * @iterations 10
     */
    public function toString()
    {
        $this->matrix1->__toString();
    }

    /**
     * @iterations 10
     */
    public function getShape()
    {
        $this->matrix1->getShape();
    }

    /**
     * @iterations 10
     */
    public function getSize()
    {
        $this->matrix1->getSize();
    }

    /**
     * @iterations 10
     */
    public function getData()
    {
        $this->matrix1->getData();
    }

    /**
     * @iterations 10
     */
    public function getNDim()
    {
        $this->matrix1->getNDim();
    }

    /**
     * @iterations 10
     */
    public function add()
    {
        $this->matrix1->add($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function sub()
    {
        $this->matrix1->sub($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function div()
    {
        $this->matrix1->div($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function mult()
    {
        $this->matrix1->mult($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function getTranspose()
    {
        $this->matrix1->getTranspose();
    }
}
