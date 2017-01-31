<?php

namespace NumPHP\NumArray;

interface FactoryInterface
{
    public function createFromData(array $data): NumArray;

    public function createZeros(int ...$axis): NumArray;
}
