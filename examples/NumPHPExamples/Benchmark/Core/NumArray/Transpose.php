<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples\Benchmark\Core\NumArray;

use NumPHP\Core\NumArray;
use NumPHPExamples\Benchmark\BenchmarkInterface;
use NumPHPExamples\Benchmark\TestRun;

/**
 * Class Transpose
 *
 * @package   NumPHPExamples\Benchmark\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.1.0
 */
class Transpose implements BenchmarkInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'NumArray Transpose';
    }

    /**
     * @return array
     */
    public function run()
    {
        $result = [];
        $array = [];
        for ($i = 0; $i < 1000; $i++) {
            $array[] = range(1, 1000);
        }
        $numArray = new NumArray($array);
        $time = microtime(true);
        $transpose = $numArray->getTranspose();
        $timeDiff = microtime(true) - $time;

        $result[] = new TestRun("1000x1000", $timeDiff);

        return $result;
    }
}
