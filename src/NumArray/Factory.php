<?php
declare(strict_types=1);

namespace NumPHP\NumArray;

use NumPHP\Exception\MissingArgumentException;
use NumPHP\NumArray\String\DefaultFormatter;

class Factory implements FactoryInterface
{
    private $stringFormatter;

    public function __construct()
    {
        $this->stringFormatter = new DefaultFormatter();
    }

    public function createFromData(array $data): NumArrayInterface
    {
        return new NumArray($data, $this->stringFormatter);
    }

    public function createZeros(int ...$axis): NumArrayInterface
    {
        if (count($axis) === 0) {
            throw new MissingArgumentException('Required argument $axis not found');
        }
        return new NumArray($this->fillRecursiveArray($axis, 0), $this->stringFormatter);
    }

    public function createZerosLike(NumArrayInterface $numArray): NumArrayInterface
    {
        return call_user_func_array([$this, 'createZeros'], $numArray->getShape());
    }

    public function createOnes(int ...$axis): NumArrayInterface
    {
        if (count($axis) === 0) {
            throw new MissingArgumentException('Required argument $axis not found');
        }
        return new NumArray($this->fillRecursiveArray($axis, 1), $this->stringFormatter);
    }

    public function createOnesLike(NumArrayInterface $numArray): NumArrayInterface
    {
        return call_user_func_array([$this, 'createOnes'], $numArray->getShape());
    }

    private function fillRecursiveArray(array $shape, $value): array
    {
        if (count($shape) === 1) {
            return array_fill(0, array_shift($shape), $value);
        }
        return array_fill(0, array_shift($shape), $this->fillRecursiveArray($shape, $value));
    }
}
