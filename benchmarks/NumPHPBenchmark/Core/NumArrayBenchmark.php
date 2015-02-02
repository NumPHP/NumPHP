<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPBenchmark\Core;

use NumPHP\Core\NumArray;
use PHPUBM\Framework\Benchmark;

/**
 * Class NumArrayBenchmark
 *
 * @package   NumPHPBenchmark\Core
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.0
 */
class NumArrayBenchmark extends Benchmark
{
    public function benchmarkBasics()
    {
        $array = [];
        for ($i = 0; $i < 1000; $i++) {
            $array[] = range(1, 1000);
        }

        $this->benchmark(
            function ($array) {
                return new NumArray($array);
            },
            [$array],
            '__construct 1kx1k'
        );
        $numArray = new NumArray($array);
        $numArray2 = new NumArray($array);
        $this->benchmark([$numArray, '__toString'], [], 'toString 1kx1k');
        $this->benchmark([$numArray, 'getShape'], [], 'getShape 1kx1k');
        $this->benchmark([$numArray, 'getSize'], [], 'getSize 1kx1k');
        $this->benchmark([$numArray, 'getNDim'], [], 'getNDim 1kx1k');
        $this->benchmark([$numArray, 'add'], [$numArray2], 'add 1kx1k+1kx1k');
        $this->benchmark([$numArray, 'sub'], [$numArray2], 'sub 1kx1k+1kx1k');
        $this->benchmark([$numArray, 'div'], [$numArray2], 'div 1kx1k+1kx1k');
        $this->benchmark([$numArray, 'mult'], [$numArray2], 'mult 1kx1k+1kx1k');
    }
}
