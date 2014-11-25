<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 11/25/14
 * Time: 1:43 PM
 */

namespace NumPHP\Core;

use NumPHP\Core\Exception\InvalidArgumentException;

/**
 * Class NumArray
 * @package NumPHP\Core
 */
class NumArray
{
    /**
     * @var array
     */
    protected $shape;

    /**
     * @var array
     */
    protected $array;

    /**
     * @param $array
     */
    public function __construct($array)
    {
        $shape = [];
        $this->array = $array;
        $this->shape = self::initRecursive($array, $shape);
    }

    /**
     * @return mixed
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        $size = 1;
        foreach ($this->getShape() as $fac) {
            $size *= $fac;
        }
        return $size;
    }

    /**
     * @return mixed|NumArray
     */
    public function get()
    {
        $args = func_get_args();
        $array = self::getRecursive($this->array, $args);

        if (is_array($array)) {
            return new NumArray($array);
        }
        return $array;
    }

    /**
     * @param $array
     * @param array $args
     * @return mixed
     */
    protected static function getRecursive($array, array $args)
    {
        if (isset($args[0])) {
            $arg = $args[0];
            $matches = [];
            array_shift($args);
            if (preg_match('/^(?P<from>\d*):(?P<to>\d*)$/', $arg, $matches)) {
                $fromValue = $matches['from'];
                $toValue = $matches['to'];
                $sliced = self::slice($array, $fromValue, $toValue);
                foreach ($sliced as $index => $row) {
                    $sliced[$index] = self::getRecursive($row, $args);
                }
                return $sliced;
            }
            return self::getRecursive($array[$arg], $args);
        }
        return $array;
    }

    /**
     * @param $array
     * @param $fromValue
     * @param $toValue
     * @return array
     */
    protected static function slice(array $array, $fromValue, $toValue)
    {
        if (!$fromValue) {
            $fromValue = 0;
        }
        if (!$toValue && $toValue !== 0) {
            $toValue = count($array);
        }
        return array_slice($array, $fromValue, $toValue-$fromValue);
    }

    /**
     * @param $array
     * @param $shape
     * @param int $level
     * @return mixed
     */
    protected static function initRecursive($array, $shape, $level = 0)
    {
        if (is_array($array)) {
            $count = count($array);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException('Dimensions did not match');
            } else {
                $shape[$level] = $count;
            }
            foreach ($array as $row) {
                $shape = self::initRecursive($row, $shape, $level+1);
            }
        }
        return $shape;
    }
}
