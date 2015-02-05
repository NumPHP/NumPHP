<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPBenchmark\Core;

use Athletic\AthleticEvent;
use NumPHP\Core\NumPHP;

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

    /**
     * @var \NumPHP\Core\NumArray
     */
    protected $matrix3;

    /**
     * @var \NumPHP\Core\NumArray
     */
    protected $matrix4;

    public function classSetUp()
    {
        $data = [];
        for ($i = 0; $i < 1000; $i++) {
            $data[] = range(1, 1000);
        }
        $this->data = $data;
        $this->matrix1 = NumPHP::ones(1000, 1000);
        $this->matrix2 = NumPHP::ones(1000, 1000);
        $this->matrix3 = NumPHP::ones(500, 500);
        $this->matrix4 = NumPHP::ones(500, 500);
    }

    public function tearDown()
    {
        $this->matrix1->flushCache();
        $this->matrix2->flushCache();
    }

    /**
     * @iterations 10
     */
    public function construct_1kx1k()
    {
        new \NumPHP\Core\NumArray($this->data);
    }

    /**
     * @iterations 10
     */
    public function toString_1kx1k()
    {
        $this->matrix1->__toString();
    }

    /**
     * @iterations 10
     */
    public function getShape_1kx1k()
    {
        $this->matrix1->getShape();
    }

    /**
     * @iterations 10
     */
    public function getSize_1kx1k()
    {
        $this->matrix1->getSize();
    }

    /**
     * @iterations 10
     */
    public function getData_1kx1k()
    {
        $this->matrix1->getData();
    }

    /**
     * @iterations 10
     */
    public function getNDim_1kx1k()
    {
        $this->matrix1->getNDim();
    }

    /**
     * @iterations 10
     */
    public function add_1kx1k_1kx1k()
    {
        $this->matrix1->add($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function sub_1kx1k_1kx1k()
    {
        $this->matrix1->sub($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function div_1kx1k_1kx1k()
    {
        $this->matrix1->div($this->matrix2);
    }

    /**
     * @iterations 10
     */
    public function mult_1kx1k_1kx1k()
    {
        $this->matrix1->mult($this->matrix2);
    }

    /**
     * @iterations 1
     */
    public function dot_1kx1k_1kx1k()
    {
        $this->matrix3->dot($this->matrix4);
    }

    /**
     * @iterations 10
     */
    public function getTranspose_1kx1k()
    {
        $this->matrix1->getTranspose();
    }
}
