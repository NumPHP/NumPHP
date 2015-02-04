<?php
/**
 * NumPHP - Mathematical PHP library for scientific computing
 *
 * Copyright (c) Gordon Lesti <info@gordonlesti.com>
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use NumPHP\Core\NumArray;
use NumPHP\LinAlg\LinAlg;

$matrixA = new NumArray(
    [
        [1, 6, 1],
        [2, 3, 2],
        [4, 2, 1],
    ]
);

echo "Matrix A:\n";
echo $matrixA;

echo "LU decomposition\n";
list($matrixP, $matrixL, $matrixU) = LinAlg::lud($matrixA);
echo "Matrix P:\n";
echo $matrixP;
echo "Matrix L:\n";
echo $matrixL;
echo "Matrix U:\n";
echo $matrixU;
