<?php

namespace NumPHP\NumArray;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray\String\DefaultFormatter;

class Factory implements FactoryInterface
{
    private $stringFormatter;

    public function __construct()
    {
        $this->stringFormatter = new DefaultFormatter();
    }

    public function createFromData(array $data): NumArray
    {
        return new NumArray($data, $this->stringFormatter);
    }

    public function createZeros(int ...$axis): NumArray
    {
        if (count($axis) === 0) {
            throw new MissingArgumentException('Required argument $axis not found');
        }
        return new NumArray($this->fillRecursiveArray($axis, 0), $this->stringFormatter);
    }

    private function fillRecursiveArray(array $shape, $value): array
    {
        $count = count($shape);
        if ($count === 0) {
            throw new IllegalArgumentException('Empty argument $shape is not allowed');
        } elseif (count($shape) === 1) {
            return array_fill(0, array_shift($shape), $value);
        }
        return array_fill(0, array_shift($shape), $this->fillRecursiveArray($shape, $value));
    }
}
