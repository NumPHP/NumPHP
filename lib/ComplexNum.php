<?php
declare(strict_types=1);

namespace NumPHP;

class ComplexNum
{
    private $real;

    private $imag;

    public function __construct(float $real, float $imag)
    {
        $this->real = $real;
        $this->imag = $imag;
    }

    public function __toString(): string
    {
        return sprintf("%d%s%di", $this->real, $this->imag < 0 ? "" : "+", $this->imag);
    }

    public function isEqual(ComplexNum $obj): bool
    {
        return get_class($this) === get_class($obj) &&
            $this->getReal() === $obj->getReal() &&
            $this->getImag() === $obj->getImag();
    }

    public function getReal(): float
    {
        return $this->real;
    }

    public function getImag(): float
    {
        return $this->imag;
    }

    public function add(ComplexNum $com): ComplexNum
    {
        return new static($this->getReal() + $com->getReal(), $this->getImag() + $com->getImag());
    }

    public function sub(ComplexNum $com): ComplexNum
    {
        return new static($this->getReal() - $com->getReal(), $this->getImag() - $com->getImag());
    }

    public function mult(ComplexNum $com): ComplexNum
    {
        $real1 = $this->getReal();
        $real2 = $com->getReal();
        $imag1 = $this->getImag();
        $imag2 = $com->getImag();
        return new static($real1 * $real2 - $imag1 * $imag2, $real1 * $imag2 + $imag1 * $real2);
    }

    public function div(ComplexNum $com): ComplexNum
    {
        $real1 = $this->getReal();
        $real2 = $com->getReal();
        $imag1 = $this->getImag();
        $imag2 = $com->getImag();
        $denominator = $imag1 * $imag1 + $imag2 * $imag2;
        return new static(
            ($real1 * $real2 + $imag1 * $imag2) / $denominator,
            ($imag1 * $real2 - $real1 * $imag2) / $denominator
        );
    }

    public function abs(): float
    {
        $real = $this->getReal();
        $imag = $this->getImag();
        return sqrt($real * $real + $imag * $imag);
    }
}
