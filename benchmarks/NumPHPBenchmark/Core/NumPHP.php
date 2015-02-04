<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPBenchmark\Core;

use Athletic\AthleticEvent;

/**
 * Class NumPHP
 *
 * @package NumPHPBenchmark\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.1.0
 */
class NumPHP extends AthleticEvent
{
    /**
     * @var \NumPHP\Core\NumArray
     */
    protected $matrix;

    public function classSetup()
    {
        $this->matrix = \NumPHP\Core\NumPHP::identity(1000);
    }

    /**
     * @iterations 10
     */
    public function generate()
    {
        \NumPHP\Core\NumPHP::generate(5, 1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function zeros()
    {
        \NumPHP\Core\NumPHP::zeros(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function zerosLike()
    {
        \NumPHP\Core\NumPHP::zerosLike($this->matrix);
    }

    /**
     * @iterations 10
     */
    public function ones()
    {
        \NumPHP\Core\NumPHP::ones(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function onesLike()
    {
        \NumPHP\Core\NumPHP::onesLike($this->matrix);
    }

    /**
     * @iterations 10
     */
    public function eye()
    {
        \NumPHP\Core\NumPHP::eye(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function identity()
    {
        \NumPHP\Core\NumPHP::identity(1000);
    }

    /**
     * @iterations 10
     */
    public function arange()
    {
        \NumPHP\Core\NumPHP::arange(0, 1000000);
    }

    /**
     * @iterations 10
     */
    public function linspace()
    {
        \NumPHP\Core\NumPHP::linspace(0, 999999, 1000000);
    }
}
