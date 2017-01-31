<?php
declare(strict_types=1);

namespace NumPHP\NumArray;

interface NumArrayInterface
{
    public function __toString(): string;

    public function getData(): array;

    public function getShape(): array;

    public function getSize(): int;

    public function getNDim(): int;
}
