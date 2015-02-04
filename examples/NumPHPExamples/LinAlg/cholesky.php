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
        [  49,  -525,     7,   -315],
        [-525,  6921, -3279,   3483],
        [   7, -3279,  8178,   -328],
        [-315,  3483,  -328, 624556]
    ]
);

echo "Matrix A:\n";
echo $matrixA->__toString();

echo "Cholesky:\n";
$matrixL = LinAlg::cholesky($matrixA);
echo $matrixL;
