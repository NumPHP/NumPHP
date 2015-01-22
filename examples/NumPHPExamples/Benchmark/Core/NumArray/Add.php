<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPExamples\Benchmark\Core\NumArray;

use NumPHP\Core\NumPHP;
use NumPHPExamples\Benchmark\BenchmarkInterface;
use NumPHPExamples\Benchmark\TestRun;

/**
 * Class Add
 * @package   NumPHPExamples\Benchmark\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.0.5
 */
class Add implements BenchmarkInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'NumArray Add';
    }

    /**
     * @return array
     */
    public function run()
    {
        $result = [];
        $numArray1 = NumPHP::ones(1000, 1000);
        $numArray2 = NumPHP::ones(1000, 1000);
        $time = microtime(true);
        $numArray1->add($numArray2);
        $timeDiff = microtime(true) - $time;

        $result[] = new TestRun("(1000x1000)+(1000x1000)", $timeDiff);

        return $result;
    }
}
