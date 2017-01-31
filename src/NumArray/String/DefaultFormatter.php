<?php
declare(strict_types=1);

namespace NumPHP\NumArray\String;

use NumPHP\NumArray\NumArrayInterface;

class DefaultFormatter implements FormatterInterface
{
    private $indent;

    private $newline;

    private $delimiter;

    private $enclosureStart;

    private $enclosureEnd;

    public function __construct(
        string $indent = "  ",
        string $newline = "\n",
        string $delimiter = ",",
        string $enclosureStart = "[",
        string $enclosureEnd = "]"
    ) {
        $this->indent = $indent;
        $this->newline = $newline;
        $this->delimiter = $delimiter;
        $this->enclosureStart = $enclosureStart;
        $this->enclosureEnd = $enclosureEnd;
    }

    public function numArrayToString(NumArrayInterface $numArray): string
    {
        return $this->recursiveArrayToString($numArray->getData());
    }

    private function recursiveArrayToString(array $data, int $level = 0): string
    {
        if (isset($data[0]) && is_array($data[0])) {
            $nextLevel = $level + 1;
            $result = array_map(function ($entry) use ($nextLevel) {
                return $this->recursiveArrayToString($entry, $nextLevel);
            }, $data);
            $multiIndent = str_repeat($this->indent, $level);
            return sprintf(
                "%s%s%s%s%s%s%s",
                $multiIndent,
                $this->enclosureStart,
                $this->newline,
                implode($this->delimiter . $this->newline, $result),
                $this->newline,
                $multiIndent,
                $this->enclosureEnd
            );
        }
        return sprintf(
            "%s%s%s%s",
            str_repeat($this->indent, $level),
            $this->enclosureStart,
            implode($this->delimiter, $data),
            $this->enclosureEnd
        );
    }
}
