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
     * @var int
     */
    protected $complexity = 0;

    /**
     * @param int   $complexity
     * @param float $time
     */
    public function __construct($complexity, $time)
    {
        $this->complexity = $complexity;
        $this->time = $time;
    }

    /**
     * @return int
     */
    public function getComplexity()
    {
        return $this->complexity;
    }

    /**
     * @return float
     */
    public function getTime()
    {
        return $this->time;
    }
}
