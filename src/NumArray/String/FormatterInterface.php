<?php

namespace NumPHP\NumArray\String;

use NumPHP\NumArray\NumArray;

interface FormatterInterface
{
    public function numArrayToString(NumArray $numArray): string;
}
