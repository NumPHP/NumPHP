<?php
declare(strict_types=1);

namespace NumPHP;

use NumPHP\Exception\IllegalArgumentException;
use NumPHP\Exception\OutOfBoundsException;
use NumPHP\Exception\MissingArgumentException;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
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
        return $this->getData() === $numArray->getData();
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

    public function get(string ...$axis)
    {
        $axisCount = count($axis);
        $usedSlice = false;
        for ($i = 0; $i < $axisCount; $i++) {
            if (strpos($axis[$i], ':') !== false) {
                $usedSlice = true;
                break;
            }
        }
        $data = self::recursiveGet($this->getData(), $axis);
        if ($usedSlice || $axisCount < $this->getNDim()) {
            return new NumArray($data);
        }
        return $data;
    }

    public function replace($data, string ...$axis): NumArray
    {
        $axisCount = count($axis);
        $usedSlice = false;
        for ($i = 0; $i < $axisCount; $i++) {
            if (strpos($axis[$i], ':') !== false) {
                $usedSlice = true;
                break;
            }
        }
        if ($usedSlice || ($axisCount < $this->getNDim())) {
            if ($data instanceof NumArray) {
                return new NumArray(self::recursiveReplace($this->getData(), $data->getData(), $axis));
            }
            throw new InvalidArgumentException('Argument $data is not type of NumArray');
        }
        return new NumArray(self::recursiveReplace($this->getData(), $data, $axis));
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
        $range = range($start, $stop, $step);
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

    private static function recursiveGet(array $data, array $axis)
    {
        $indexExplode = explode(':', array_shift($axis));
        $axisCount = count($axis);
        $dataLength = count($data);
        if (count($indexExplode) === 1) {
            $index = (int) $indexExplode[0];
            if ($index >= $dataLength || $index < -$dataLength) {
                throw new OutOfBoundsException(sprintf("Index %d out of bounds", $index));
            }
            if ($index < 0) {
                $index += $dataLength;
            }
            $extractedData = $data[$index];
            return $axisCount === 0 ? $extractedData : self::recursiveGet($extractedData, $axis);
        }
        $start = $indexExplode[0] === "" ? 0 : self::pruneIndex($indexExplode[0], $dataLength);
        $end = $indexExplode[1] === "" ? $dataLength : self::pruneIndex($indexExplode[1], $dataLength);
        $extractedData = array_slice($data, $start, max(0, $end - $start));
        if ($axisCount === 0) {
            return $extractedData;
        }
        return array_map(function ($row) use ($axis) {
            return self::recursiveGet($row, $axis);
        }, $extractedData);
    }

    private static function recursiveReplace(array $origData, $newData, array $axis): array
    {
        $indexExplode = explode(':', array_shift($axis));
        $axisCount = count($axis);
        $dataLength = count($origData);
        if (count($indexExplode) === 1) {
            $index = (int) $indexExplode[0];
            if ($index >= $dataLength || $index < -$dataLength) {
                throw new OutOfBoundsException(sprintf("Index %d out of bounds", $index));
            }
            if ($index < 0) {
                $index += $dataLength;
            }
            $origData[$index] = $axisCount === 0 ?
                $newData : self::recursiveReplace($origData[$index], $newData, $axis);
            return $origData;
        }
        $start = $indexExplode[0] === "" ? 0 : self::pruneIndex($indexExplode[0], $dataLength);
        $end = $indexExplode[1] === "" ? $dataLength : self::pruneIndex($indexExplode[1], $dataLength);
        if ($axisCount === 0) {
            array_splice($origData, $start, max(0, $end - $start), $newData);
            return $origData;
        }
        $length = max(0, $end - $start);
        array_splice(
            $origData,
            $start,
            $length,
            array_map(
                function ($origRow, $newRow) use ($axis) {
                    return self::recursiveReplace($origRow, $newRow, $axis);
                },
                array_slice($origData, $start, $length),
                $newData
            )
        );
        return $origData;
    }

    private static function pruneIndex(string $indexInput, int $maxLength): int
    {
        $index = (int) $indexInput;
        if ($index < 0) {
            $index += $maxLength;
        }
        return  min($maxLength, max(0, $index));
    }
}
