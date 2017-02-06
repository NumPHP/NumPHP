<?php
declare(strict_types=1);

namespace NumPHP;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\Exception\MissingArgumentException;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class NumArray
{
    private $data;

    private $string;

    private $shape;

    private $size;

    private $nDim;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function __toString(): string
    {
        if (is_null($this->string)) {
            $this->string = self::recursiveToString($this->data);
        }
        return $this->string;
    }

    public function isEqual(NumArray $numArray): bool
    {
        return get_class($this) === get_class($numArray) && $this->getData() === $numArray->getData();
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
            $this->size = array_product($this->getShape());
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

    public function combine(NumArray $numArray, callable $func): NumArray
    {
        if ($this->getShape() !== $numArray->getShape()) {
            throw new IllegalArgumentException(sprintf(
                "Shape [%s] and [%s] are different",
                implode(', ', $this->getShape()),
                implode(', ', $numArray->getShape())
            ));
        }
        return new NumArray(self::recursiveArrayCombine($func, $this->getData(), $numArray->getData()));
    }

    public function add(NumArray $numArray): NumArray
    {
        return $this->combine($numArray, function ($val1, $val2) {
            return $val1 + $val2;
        });
    }

    public function sub(NumArray $numArray): NumArray
    {
        return $this->combine($numArray, function ($val1, $val2) {
            return $val1 - $val2;
        });
    }

    public function mult(NumArray $numArray): NumArray
    {
        return $this->combine($numArray, function ($val1, $val2) {
            return $val1 * $val2;
        });
    }

    public function div(NumArray $numArray): NumArray
    {
        return $this->combine($numArray, function ($val1, $val2) {
            return $val1 / $val2;
        });
    }

    public function reshape(int ...$axis): NumArray
    {
        $oldSize = $this->getSize();
        $newSize = array_product($axis);
        if ($oldSize !== $newSize) {
            throw new IllegalArgumentException(sprintf(
                'Size of new shape %d is different to size %d',
                $newSize,
                $oldSize
            ));
        }
        $data = $this->getData();
        $nDim = $this->getNDim() - 1;
        for ($i = 0; $i < $nDim; $i++) {
            $data = array_merge(...$data);
        }
        return new NumArray(self::recursiveArrayChunk($data, $axis));
    }

    public static function ones(int ...$axis): NumArray
    {
        if (empty($axis)) {
            throw new MissingArgumentException('No $axis given');
        }
        return new NumArray(self::recursiveFillArray($axis, 1));
    }

    public static function onesLike(NumArray $numArray): NumArray
    {
        $shape = $numArray->getShape();
        return self::ones(...$shape);
    }

    public static function zeros(int ...$axis): NumArray
    {
        if (empty($axis)) {
            throw new MissingArgumentException('No $axis given');
        }
        return new NumArray(self::recursiveFillArray($axis, 0));
    }

    public static function zerosLike(NumArray $numArray): NumArray
    {
        $shape = $numArray->getShape();
        return self::zeros(...$shape);
    }

    public static function eye(int $mAxis, int $nAxis = null): NumArray
    {
        if (is_null($nAxis)) {
            $nAxis = $mAxis;
        }
        if ($mAxis < 0) {
            throw new IllegalArgumentException(sprintf('$mAxis %d is smaller than 0', $mAxis));
        }
        if ($nAxis < 0) {
            throw new IllegalArgumentException(sprintf('$nAxis %d is smaller than 0', $nAxis));
        }
        $data = array_fill(0, $mAxis, array_fill(0, $nAxis, 0));
        $min = min($mAxis, $nAxis);
        for ($i = 0; $i < $min; $i++) {
            $data[$i][$i] = 1;
        }
        return new NumArray($data);
    }

    public static function identity(int $axis): NumArray
    {
        if ($axis < 0) {
            throw new IllegalArgumentException(sprintf('$axis %d is smaller than 0', $axis));
        }
        return self::eye($axis);
    }

    public static function arange(float $start, float $stop, float $step = 1.0): NumArray
    {
        if (($start > $stop && $step > 0) || ($start < $stop && $step < 0)) {
            return new NumArray([]);
        }
        $range = $step === 1.0 ? range($start, $stop) : range($start, $stop, $step);
        $end = end($range);
        if (($step > 0 && $end >= $stop) || ($step < 0 && $end <= $stop)) {
            array_pop($range);
        }
        reset($range);
        return new NumArray($range);
    }

    private static function recursiveToString(array $data, int $level = 0): string
    {
        $indent = str_repeat("  ", $level);
        if (isset($data[0]) && is_array($data[0])) {
            $nextLevel = $level + 1;
            $result = array_map(function ($entry) use ($nextLevel) {
                return self::recursiveToString($entry, $nextLevel);
            }, $data);
            return sprintf("%s[\n%s\n%s]", $indent, implode(",\n", $result), $indent);
        }
        return sprintf("%s[%s]", $indent, implode(", ", $data));
    }

    private static function recursiveFillArray(array $shape, $value): array
    {
        if (count($shape) === 1) {
            return array_fill(0, array_shift($shape), $value);
        }
        return array_fill(0, array_shift($shape), self::recursiveFillArray($shape, $value));
    }

    private static function recursiveArrayCombine(callable $func, array $arr1, array $arr2): array
    {
        if (isset($arr1[0]) && is_array($arr1[0])) {
            return array_map(function ($val1, $val2) use ($func) {
                return self::recursiveArrayCombine($func, $val1, $val2);
            }, $arr1, $arr2);
        }
        return array_map($func, $arr1, $arr2);
    }

    private static function recursiveArrayChunk(array $array, array $shape): array
    {
        if (count($shape) === 1) {
            return $array;
        }
        array_shift($shape);
        $chunks = array_chunk($array, array_product($shape));
        return array_map(function ($val) use ($shape) {
            return self::recursiveArrayChunk($val, $shape);
        }, $chunks);
    }
}
