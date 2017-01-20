<?php
declare(strict_types=1);

namespace NumPHP\Core;

class NumArray
{
    private $data;

    private $shape;

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
}
