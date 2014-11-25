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
        $this->shape = $this->initRecursive($array, $shape);
    }

    /**
     * @return mixed
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @return array|mixed
     */
    public function get()
    {
        $args = func_get_args();
        if (count($args)) {
            foreach ($args as $index) {
                $matches = [];
                if (is_string($index) && preg_match('/^(?P<from>\d*):(?P<to>\d*)$/', $index, $matches)) {
                    echo $from = $matches['from'];
                    echo $to = $matches['to'];
                } else {
                    return $this->array[$index];
                }

            }
        } else {
            return $this->array;
        }
    }

    /**
     * @param $array
     * @param $shape
     * @param int $level
     * @return mixed
     */
    protected function initRecursive($array, $shape, $level = 0)
    {
        if (is_array($array)) {
            $count = count($array);
            if (isset($shape[$level]) && $shape[$level] !== $count) {
                throw new InvalidArgumentException('Dimensions did not match');
            } else {
                $shape[$level] = $count;
            }
            foreach ($array as $row) {
                $shape = $this->initRecursive($row, $shape, $level+1);
            }
        }
        return $shape;
    }
}
