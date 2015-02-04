<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;

$matrix = new NumArray(
    [
        [-3,   4, 7/6],
        [ 2, 0.1,   0],
        [23,  -5,   8]
    ]
);

echo "Matrix:\n";
echo $matrix;

echo "Inverse:\n";
$inv = LinAlg::inv($matrix);
echo $inv;
