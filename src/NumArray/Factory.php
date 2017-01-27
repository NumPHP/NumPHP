<?php

namespace NumPHP\NumArray;

use NumPHP\NumArray\NumArray;
use NumPHP\NumArray\String\DefaultFormatter;

class Factory
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
}
