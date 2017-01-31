<?php
declare(strict_types=1);

namespace NumPHP\NumArray;

use NumPHP\NumArray\String\FormatterInterface;

class NumArray implements NumArrayInterface
{
    private $data;

    private $stringFormatter;

    public function __construct(array $data, FormatterInterface $stringFormatter)
    {
        $this->data = $data;
        $this->stringFormatter = $stringFormatter;
    }

    public function __toString(): string
    {
        return $this->stringFormatter->numArrayToString($this);
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getShape(): array
    {
        $shape = [];
        $currentDataDim = $this->data;
        while (is_array($currentDataDim)) {
            $shape[] = count($currentDataDim);
            $currentDataDim = $currentDataDim[0];
        }
        return $shape;
    }

    public function getSize(): int
    {
        return array_reduce(
            $this->getShape(),
            function ($carry, $item) {
                return $carry * $item;
            },
            1
        );
    }

    public function getNDim(): int
    {
        return count($this->getShape());
    }
}
