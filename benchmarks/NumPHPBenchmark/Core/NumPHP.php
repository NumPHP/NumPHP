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
    public function generate_1kx1k()
    {
        \NumPHP\Core\NumPHP::generate(5, 1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function zeros_1kx1k()
    {
        \NumPHP\Core\NumPHP::zeros(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function zerosLike_1kx1k()
    {
        \NumPHP\Core\NumPHP::zerosLike($this->matrix);
    }

    /**
     * @iterations 10
     */
    public function ones_1kx1k()
    {
        \NumPHP\Core\NumPHP::ones(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function onesLike_1kx1k()
    {
        \NumPHP\Core\NumPHP::onesLike($this->matrix);
    }

    /**
     * @iterations 10
     */
    public function eye_1kx1k()
    {
        \NumPHP\Core\NumPHP::eye(1000, 1000);
    }

    /**
     * @iterations 10
     */
    public function identity_1kx1k()
    {
        \NumPHP\Core\NumPHP::identity(1000);
    }

    /**
     * @iterations 10
     */
    public function arange_1m()
    {
        \NumPHP\Core\NumPHP::arange(0, 1000000);
    }

    /**
     * @iterations 10
     */
    public function linspace_1m()
    {
        \NumPHP\Core\NumPHP::linspace(0, 999999, 1000000);
    }
}
