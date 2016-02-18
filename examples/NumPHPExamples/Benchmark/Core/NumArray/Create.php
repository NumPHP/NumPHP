<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples\Benchmark\Core\NumArray;

use NumPHP\Core\NumPHP;
use NumPHP\Core\NumArray;
use NumPHPExamples\Benchmark\BenchmarkInterface;
use NumPHPExamples\Benchmark\TestRun;

/**
 * Class Create
 *
 * @package   NumPHPExamples\Benchmark\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.5
 */
class Create implements BenchmarkInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'NumArray Create';
    }

    /**
     * @return array
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    public function run()
    {
        $result = [];
        for ($i = 100; $i <= 1000; $i += 100) {
            $array = NumPHP::ones($i, $i);
            $time = microtime(true);
            $numArray = new NumArray($array->getData());
            $timeDiff = microtime(true) - $time;

            $result[$i] = new TestRun($i, $timeDiff);
        }

        return $result;
    }
}
