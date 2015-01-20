<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples\Benchmark;

/**
 * Interface BenchmarkInterface
 *
 * @package   NumPHPExamples\Benchmark
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.5
 */
interface BenchmarkInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return array
     */
    public function run();
}
