<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples\Benchmark;

/**
 * Class TestRun
 *
 * @package   NumPHPExamples\Benchmark
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.5
 */
class TestRun
{
    /**
     * @var float
     */
    protected $time = 0.0;

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @param string $description
     * @param float  $time
     */
    public function __construct($description, $time)
    {
        $this->description = $description;
        $this->time = $time;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }
}
