<?php
declare(strict_types=1);

namespace NumPHP\NumArray;

interface FactoryInterface
{
    public function createFromData(array $data): NumArrayInterface;

    public function createZeros(int ...$axis): NumArrayInterface;

    public function createZerosLike(NumArrayInterface $numArray): NumArrayInterface;
}
