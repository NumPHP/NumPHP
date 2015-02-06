<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

namespace NumPHPBenchmark\Core\NumArray;

use Athletic\AthleticEvent;
use NumPHP\Core\NumArray;

/**
 * Class Create
 *
 * @package   NumPHPBenchmark\Core\NumArray
 * @author    Gordon Lesti <info@gordonlesti.com>
 * @copyright 2014-2015 Gordon Lesti (https://gordonlesti.com/)
 * @license   http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link      http://numphp.org/
 * @since     1.1.0
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class Create extends AthleticEvent
{
    /**
     * @var array
     */
    protected $data;

    public function classSetUp()
    {
        $this->data = [];
        for ($i = 0; $i < 1000; $i++) {
            $this->data[] = array_fill(0, 1000, 1);
        }
    }

    /**
     * @iterations 10
     */
    public function create_1kx1k()
    {
        new NumArray($this->data);
    }
}
