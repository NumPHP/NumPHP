<?php
declare(strict_types=1);

namespace NumPHP\NumArray;

class NumArray
{
    private $data;

    private $shape;

    private $size;

    private $nDim;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getShape(): array
    {
        if (is_null($this->shape)) {
            $shape = [];
            $currentDataDim = $this->data;
            while (is_array($currentDataDim)) {
                $shape[] = count($currentDataDim);
                $currentDataDim = $currentDataDim[0];
            }
            $this->shape = $shape;
        }
        return $this->shape;
    }

    public function getSize(): int
    {
        if (is_null($this->size)) {
            $this->size = array_reduce(
                $this->getShape(),
                function ($carry, $item) {
                    return $carry * $item;
                },
                1
            );
        }
        return $this->size;
    }

    public function getNDim(): int
    {
        if (is_null($this->nDim)) {
            $this->nDim = count($this->getShape());
        }
        return $this->nDim;
    }
}
