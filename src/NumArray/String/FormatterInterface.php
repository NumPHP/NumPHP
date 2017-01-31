<?php
declare(strict_types=1);

namespace NumPHP\NumArray\String;

use NumPHP\NumArray\NumArrayInterface;

interface FormatterInterface
{
    public function numArrayToString(NumArrayInterface $numArray): string;
}
